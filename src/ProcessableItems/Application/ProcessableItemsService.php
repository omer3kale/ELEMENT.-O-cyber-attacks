<?php

declare(strict_types=1);

namespace ElementO\ProcessableItems\Application;

use DateTimeImmutable;
use ElementO\ProcessableItems\Domain\DistributionStrategy;
use ElementO\ProcessableItems\Domain\ProcessableItem;
use ElementO\ProcessableItems\Domain\User;
use ElementO\ProcessableItems\Infrastructure\Database\ProcessableItemRepository;
use ElementO\ProcessableItems\Infrastructure\Time\GermanHolidayCalendar;

/**
 * Schedules processable items for a list of users within a date/time window,
 * respecting German federal holidays, office-hours and per-user minimum spacing.
 *
 * Design decisions:
 *   - "amount" is interpreted as items **per user** (not a global total).
 *     Total generated items = count($users) * $amountPerUser.
 *   - Minimum distance between any two items belonging to the same user is
 *     hard-floored to 30 minutes even when a lower value is supplied.
 *   - Valid time slots are generated in 30-minute steps inside the 09:00-16:30
 *     window (last slot starts at 16:30 so it finishes by 17:00).
 *   - If constraints leave fewer valid slots than $amountPerUser the service
 *     schedules as many as possible and returns fewer items without throwing.
 *   - Items are only persisted (INSERT) — they are never processed here.
 *
 * Distribution strategies – when to use each:
 *
 *   EVEN
 *     Picks slots at evenly-spaced indices across the available slot pool.
 *     Produces a perfectly predictable, regular cadence.
 *     Best for: compliance schedules, SLA-driven tasks, auditable workflows
 *     where reviewers must confirm items were distributed uniformly.
 *
 *   RANDOM_SPACED
 *     Shuffles the full slot pool then greedily picks items that satisfy
 *     the minimum-distance constraint.
 *     Produces unpredictable times while still guaranteeing spacing.
 *     Best for: red-team exercises, phishing simulations, or any task where
 *     predictability would allow employees / adversaries to anticipate events.
 *
 *   WEIGHTED
 *     Assigns each slot a weight (early 09–13 = 1 / mid 13–15 = 2 /
 *     late 15–17 = 3), builds a weighted pool, then samples it.
 *     Biases scheduling toward end-of-day to minimise morning-rush disruption.
 *     Best for: security-awareness tasks and training reminders that should
 *     not compete with high-priority morning work, or when regulations mandate
 *     tasks are completed in the final work-hour window.
 *
 * Trade-off summary:
 *   Predictability : EVEN > WEIGHTED > RANDOM_SPACED
 *   Late-day bias  : WEIGHTED > RANDOM_SPACED ≈ EVEN
 *   Surprise factor: RANDOM_SPACED > WEIGHTED > EVEN
 */
final class ProcessableItemsService
{
    private const OFFICE_HOUR_START   = 9;
    private const OFFICE_HOUR_END     = 17;
    private const SLOT_STEP_MINUTES   = 30;
    private const MIN_DISTANCE_FLOOR  = 30;

    public function __construct(
        private readonly ProcessableItemRepository $repository,
        private readonly GermanHolidayCalendar     $calendar,
    ) {}

    /**
     * @param  User[]              $users
     * @param  int                 $amountPerUser   Items to schedule for each user.
     * @param  DateTimeImmutable   $start           Range start (inclusive).
     * @param  DateTimeImmutable   $end             Range end   (inclusive).
     * @param  int                 $minDistanceMinutes  Min minutes between any two items
     *                                              for the same user (floored to 30).
     * @param  DistributionStrategy $strategy
     * @return ProcessableItem[]
     */
    public function scheduleItems(
        array                $users,
        int                  $amountPerUser,
        DateTimeImmutable    $start,
        DateTimeImmutable    $end,
        int                  $minDistanceMinutes,
        DistributionStrategy $strategy,
    ): array {
        $effectiveMinDistance = max($minDistanceMinutes, self::MIN_DISTANCE_FLOOR);

        $validSlots = $this->buildSlots($start, $end);

        $all = [];

        foreach ($users as $user) {
            $selected = match ($strategy) {
                DistributionStrategy::EVEN          => $this->selectEven(
                    $validSlots, $amountPerUser, $effectiveMinDistance,
                ),
                DistributionStrategy::RANDOM_SPACED => $this->selectRandomSpaced(
                    $validSlots, $amountPerUser, $effectiveMinDistance,
                ),
                DistributionStrategy::WEIGHTED      => $this->selectWeighted(
                    $validSlots, $amountPerUser, $effectiveMinDistance,
                ),
            };

            foreach ($selected as $n => $slot) {
                $all[] = ProcessableItem::scheduled(
                    name:        sprintf('User %d item #%d (%s)', $user->id(), $n + 1, $strategy->value),
                    userId:      $user->id(),
                    scheduledAt: $slot,
                );
            }
        }

        $this->repository->saveAll($all);

        return $all;
    }

    // -------------------------------------------------------------------------
    // Slot generation
    // -------------------------------------------------------------------------

    /**
     * Returns every valid 30-minute slot between $start and $end:
     *   - Monday-Friday only
     *   - 09:00 – 16:30 (last slot that finishes by 17:00)
     *   - No German federal holidays
     *
     * @return DateTimeImmutable[]
     */
    private function buildSlots(DateTimeImmutable $start, DateTimeImmutable $end): array
    {
        $slots   = [];
        $current = $start->setTime(self::OFFICE_HOUR_START, 0);
        $lastSlot = $end->setTime(self::OFFICE_HOUR_END - 1, 30); // 16:30

        while ($current <= $lastSlot) {
            $hour    = (int) $current->format('G');
            $minute  = (int) $current->format('i');
            $weekday = (int) $current->format('N'); // 1=Mon … 7=Sun
            $inHours = $hour > self::OFFICE_HOUR_START
                || ($hour === self::OFFICE_HOUR_START && $minute >= 0);
            $beforeEnd = $hour < self::OFFICE_HOUR_END - 1
                || ($hour === self::OFFICE_HOUR_END - 1 && $minute <= 30);

            if (
                $weekday >= 1
                && $weekday <= 5
                && $inHours
                && $beforeEnd
                && !$this->calendar->isHoliday($current)
            ) {
                $slots[] = $current;
            }

            $current = $current->modify(sprintf('+%d minutes', self::SLOT_STEP_MINUTES));

            // Jump to next day's 09:00 after 16:30
            if ((int) $current->format('G') >= self::OFFICE_HOUR_END) {
                $current = $current->modify('+1 day')->setTime(self::OFFICE_HOUR_START, 0);
            }
        }

        return $slots;
    }

    // -------------------------------------------------------------------------
    // Strategy implementations
    // -------------------------------------------------------------------------

    /**
     * EVEN: picks $amount slots at evenly-spaced indices across the slot pool.
     *
     * Algorithm:
     *   1. Compute step = max(floor(count/amount), ceil(minDist/slotStep)).
     *   2. Walk $slots in step-sized increments, accepting each candidate
     *      only when it is at least $minDistance minutes from the last pick.
     *
     * Characteristics:
     *   - Deterministic (no randomness).
     *   - Output is strictly monotonically ordered by time.
     *   - Distributes load uniformly; gaps are predictable and equal.
     *
     * @param  DateTimeImmutable[] $slots
     * @return DateTimeImmutable[]
     */
    private function selectEven(array $slots, int $amount, int $minDistance): array
    {
        if (empty($slots) || $amount <= 0) {
            return [];
        }

        $count = count($slots);

        if ($count <= $amount) {
            return $this->enforceMinDistance($slots, $minDistance);
        }

        $step     = (int) floor($count / $amount);
        $step     = max($step, (int) ceil($minDistance / self::SLOT_STEP_MINUTES));
        $selected = [];

        for ($i = 0; $i < $count && count($selected) < $amount; $i += $step) {
            $candidate = $slots[$i];
            if (empty($selected) || $this->distanceMinutes(end($selected), $candidate) >= $minDistance) {
                $selected[] = $candidate;
            }
        }

        return $selected;
    }

    /**
     * RANDOM_SPACED: shuffles the full slot pool then greedily selects slots
     * that satisfy the minimum-distance constraint against the *last* pick.
     *
     * Algorithm:
     *   1. Shuffle $slots with PHP's Mersenne Twister PRNG.
     *   2. Walk the shuffled list in order; accept each candidate only when it
     *      is ≥ $minDistance minutes from the previously accepted slot.
     *   3. Sort accepted slots chronologically before returning.
     *
     * Characteristics:
     *   - Non-deterministic unless the caller seeds mt_srand() beforehand.
     *   - Guarantees spacing but NOT uniform coverage — long gaps may appear.
     *   - Produced output is rarely predictable, making it suitable for
     *     adversarial or surprise-effect scenarios.
     *
     * @param  DateTimeImmutable[] $slots
     * @return DateTimeImmutable[]
     */
    private function selectRandomSpaced(array $slots, int $amount, int $minDistance): array
    {
        if (empty($slots) || $amount <= 0) {
            return [];
        }

        $shuffled = $slots;
        shuffle($shuffled);

        $selected = [];
        foreach ($shuffled as $candidate) {
            if (empty($selected) || $this->distanceMinutes(end($selected), $candidate) >= $minDistance) {
                $selected[] = $candidate;
                if (count($selected) >= $amount) {
                    break;
                }
            }
        }

        usort($selected, static fn ($a, $b) => $a <=> $b);

        return $selected;
    }

    /**
     * WEIGHTED: biases scheduling toward later-day slots using a pool-sampling
     * approach.
     *
     * Slot weights:
     *   09:00 – 12:30  (early)  weight = 1
     *   13:00 – 14:30  (mid)    weight = 2
     *   15:00 – 16:30  (late)   weight = 3
     *
     * Algorithm:
     *   1. Build a weighted pool: each slot index appears $weight times.
     *      A late slot therefore appears 3× as often as an early slot.
     *   2. Shuffle the pool with PHP's Mersenne Twister PRNG.
     *   3. Walk the shuffled pool; for each entry accept the underlying slot
     *      when it has not been used yet AND is ≥ $minDistance from the last
     *      accepted slot.
     *   4. Sort accepted slots chronologically before returning.
     *
     * Characteristics:
     *   - Non-deterministic unless the caller seeds mt_srand() beforehand.
     *   - Late-window slots (~15:00–17:00) are sampled ~3× more frequently
     *     than early-window slots, minimising disruption to morning work.
     *   - The greedy distance check ensures spacing is always respected.
     *
     * @param  DateTimeImmutable[] $slots
     * @return DateTimeImmutable[]
     */
    private function selectWeighted(array $slots, int $amount, int $minDistance): array
    {
        if (empty($slots) || $amount <= 0) {
            return [];
        }

        // Build weighted pool: each slot appears weight-many times
        $pool = [];
        foreach ($slots as $idx => $slot) {
            $hour   = (int) $slot->format('G');
            $weight = match (true) {
                $hour < 13  => 1,
                $hour < 15  => 2,
                default     => 3,
            };
            for ($w = 0; $w < $weight; $w++) {
                $pool[] = $idx;
            }
        }

        shuffle($pool);

        $selected  = [];
        $usedIdx   = [];

        foreach ($pool as $idx) {
            if (isset($usedIdx[$idx])) {
                continue;
            }
            $candidate = $slots[$idx];
            if (empty($selected) || $this->distanceMinutes(end($selected), $candidate) >= $minDistance) {
                $selected[]      = $candidate;
                $usedIdx[$idx]   = true;
                if (count($selected) >= $amount) {
                    break;
                }
            }
        }

        usort($selected, static fn ($a, $b) => $a <=> $b);

        return $selected;
    }

    /**
     * Remove slots that violate minDistance when walking the list in order.
     * Used as a post-filter for EVEN when the full slot list is returned.
     *
     * @param  DateTimeImmutable[] $slots
     * @return DateTimeImmutable[]
     */
    private function enforceMinDistance(array $slots, int $minDistance): array
    {
        $out = [];
        foreach ($slots as $slot) {
            if (empty($out) || $this->distanceMinutes(end($out), $slot) >= $minDistance) {
                $out[] = $slot;
            }
        }
        return $out;
    }

    private function distanceMinutes(DateTimeImmutable $a, DateTimeImmutable $b): int
    {
        $diff = abs($b->getTimestamp() - $a->getTimestamp());
        return (int) floor($diff / 60);
    }

    // -------------------------------------------------------------------------
    // Capacity estimation
    // -------------------------------------------------------------------------

    /**
     * Returns the maximum number of items that could be scheduled for a
     * single user in the given date/time range, given the minimum spacing.
     *
     * This is a pure calculation — it builds the slot list without touching
     * the database or any user state.
     *
     * The result is an upper bound: EVEN strategy can always saturate it;
     * RANDOM_SPACED and WEIGHTED may schedule fewer due to greedy ordering.
     *
     * @param  DateTimeImmutable $start              Range start (inclusive).
     * @param  DateTimeImmutable $end                Range end   (inclusive).
     * @param  int               $minDistanceMinutes Min spacing (floored to 30).
     * @return int Maximum schedulable items for one user.
     */
    public function estimateCapacity(
        DateTimeImmutable $start,
        DateTimeImmutable $end,
        int $minDistanceMinutes = self::MIN_DISTANCE_FLOOR,
    ): int {
        $effective = max($minDistanceMinutes, self::MIN_DISTANCE_FLOOR);
        $slots     = $this->buildSlots($start, $end);
        return count($this->enforceMinDistance($slots, $effective));
    }
}
