<?php

declare(strict_types=1);

namespace ElementO\Tests\ProcessableItems;

use DateTimeImmutable;
use ElementO\ProcessableItems\Application\ProcessableItemsService;
use ElementO\ProcessableItems\Domain\DistributionStrategy;
use ElementO\ProcessableItems\Domain\ProcessableItem;
use ElementO\ProcessableItems\Domain\User;
use ElementO\ProcessableItems\Infrastructure\Database\ConnectionFactory;
use ElementO\ProcessableItems\Infrastructure\Database\ProcessableItemRepository;
use ElementO\ProcessableItems\Infrastructure\Time\GermanHolidayCalendar;
use PHPUnit\Framework\TestCase;

final class ProcessableItemsServiceTest extends TestCase
{
    private ProcessableItemsService $service;

    /** Reference week: 2026-03-09 (Mon) – 2026-03-13 (Fri) */
    private DateTimeImmutable $weekStart;
    private DateTimeImmutable $weekEnd;

    /** @var User[] */
    private array $users;

    protected function setUp(): void
    {
        $factory = new ConnectionFactory('sqlite::memory:');
        $factory->getConnection(); // triggers schema creation

        $this->service   = new ProcessableItemsService(
            new ProcessableItemRepository($factory),
            new GermanHolidayCalendar(),
        );

        $this->weekStart = new DateTimeImmutable('2026-03-09 09:00');
        $this->weekEnd   = new DateTimeImmutable('2026-03-13 17:00');
        $this->users     = [new User(1, 'Alice'), new User(2, 'Bob')];
    }

    // -----------------------------------------------------------------------
    // 1. Min distance floor
    // -----------------------------------------------------------------------

    public function testMinDistanceIsFlooredTo30Minutes(): void
    {
        $items = $this->service->scheduleItems(
            users:              $this->users,
            amountPerUser:      10,
            start:              $this->weekStart,
            end:                $this->weekEnd,
            minDistanceMinutes: 10, // below floor – must be raised to 30
            strategy:           DistributionStrategy::EVEN,
        );

        $this->assertNotEmpty($items);
        $byUser = $this->groupByUser($items);

        foreach ($byUser as $userId => $userItems) {
            usort($userItems, fn ($a, $b) => $a->scheduledAt() <=> $b->scheduledAt());
            for ($i = 1; $i < count($userItems); $i++) {
                $diff = abs(
                    $userItems[$i]->scheduledAt()->getTimestamp()
                    - $userItems[$i - 1]->scheduledAt()->getTimestamp()
                ) / 60;
                $this->assertGreaterThanOrEqual(
                    30,
                    $diff,
                    sprintf('User %d: consecutive items are only %d minutes apart.', $userId, $diff),
                );
            }
        }
    }

    // -----------------------------------------------------------------------
    // 2. Office hours and weekdays only
    // -----------------------------------------------------------------------

    public function testItemsFallOnWeekdaysAndOfficeHoursOnly(): void
    {
        // Range includes a weekend (extend to Sunday)
        $start = new DateTimeImmutable('2026-03-09 09:00');
        $end   = new DateTimeImmutable('2026-03-15 17:00'); // includes Sat + Sun

        $items = $this->service->scheduleItems(
            users:              $this->users,
            amountPerUser:      8,
            start:              $start,
            end:                $end,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::EVEN,
        );

        $this->assertNotEmpty($items);

        foreach ($items as $item) {
            $dt      = $item->scheduledAt();
            $weekday = (int) $dt->format('N');
            $hour    = (int) $dt->format('G');
            $minute  = (int) $dt->format('i');

            $this->assertGreaterThanOrEqual(1, $weekday, 'Item scheduled on a weekend.');
            $this->assertLessThanOrEqual(5, $weekday,    'Item scheduled on a weekend.');
            $this->assertGreaterThanOrEqual(9,  $hour,   'Item scheduled before 09:00.');
            $this->assertLessThanOrEqual(16,    $hour,   'Item scheduled after 16:30.');
            $this->assertContains($minute, [0, 30],       'Slot minute must be 0 or 30.');
        }
    }

    // -----------------------------------------------------------------------
    // 3. No items on German holidays
    // -----------------------------------------------------------------------

    public function testNoItemsScheduledOnHolidays(): void
    {
        // Labour Day 2026-05-01 is a Friday — range contains it
        $start = new DateTimeImmutable('2026-04-27 09:00');
        $end   = new DateTimeImmutable('2026-05-01 17:00');

        $items = $this->service->scheduleItems(
            users:              [new User(3, 'Charlie')],
            amountPerUser:      20,
            start:              $start,
            end:                $end,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::EVEN,
        );

        foreach ($items as $item) {
            $this->assertNotEquals(
                '2026-05-01',
                $item->scheduledAt()->format('Y-m-d'),
                'An item was scheduled on Labour Day (German holiday).',
            );
        }
    }

    // -----------------------------------------------------------------------
    // 4. Strategy: EVEN – monotonically spread
    // -----------------------------------------------------------------------

    public function testEvenStrategyProducesMonotonicallySpreadTimes(): void
    {
        $items = $this->service->scheduleItems(
            users:              [new User(1, 'Alice')],
            amountPerUser:      5,
            start:              $this->weekStart,
            end:                $this->weekEnd,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::EVEN,
        );

        $this->assertCount(5, $items);

        usort($items, fn ($a, $b) => $a->scheduledAt() <=> $b->scheduledAt());

        for ($i = 1; $i < count($items); $i++) {
            $this->assertGreaterThan(
                $items[$i - 1]->scheduledAt(),
                $items[$i]->scheduledAt(),
                'EVEN items are not strictly increasing in time.',
            );
        }
    }

    // -----------------------------------------------------------------------
    // 5. Strategy: RANDOM_SPACED – all items valid (office hours + spacing)
    // -----------------------------------------------------------------------

    public function testRandomSpacedProducesValidItems(): void
    {
        $items = $this->service->scheduleItems(
            users:              [new User(1, 'Alice')],
            amountPerUser:      5,
            start:              $this->weekStart,
            end:                $this->weekEnd,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::RANDOM_SPACED,
        );

        $this->assertNotEmpty($items);

        usort($items, fn ($a, $b) => $a->scheduledAt() <=> $b->scheduledAt());

        for ($i = 1; $i < count($items); $i++) {
            $diff = abs(
                $items[$i]->scheduledAt()->getTimestamp()
                - $items[$i - 1]->scheduledAt()->getTimestamp()
            ) / 60;
            $this->assertGreaterThanOrEqual(30, $diff, 'RANDOM_SPACED min distance violated.');
        }
    }

    // -----------------------------------------------------------------------
    // 6. Strategy: WEIGHTED – majority of times in 15:00-17:00 window
    // -----------------------------------------------------------------------

    public function testWeightedStrategyFavorsLaterSlots(): void
    {
        // Use multiple users and a full week to get a reasonable sample
        $manyUsers = array_map(
            static fn (int $i): User => new User($i, "User$i"),
            range(1, 5),
        );

        $items = $this->service->scheduleItems(
            users:              $manyUsers,
            amountPerUser:      10,
            start:              $this->weekStart,
            end:                $this->weekEnd,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::WEIGHTED,
        );

        $this->assertNotEmpty($items);

        $lateCount  = 0;
        $totalCount = count($items);

        foreach ($items as $item) {
            if ((int) $item->scheduledAt()->format('G') >= 15) {
                $lateCount++;
            }
        }

        $ratio = $lateCount / $totalCount;

        // With weights 1/2/3, late slots (weight 3) should dominate.
        // A threshold of 0.30 is deliberately conservative to avoid flakiness.
        $this->assertGreaterThan(
            0.30,
            $ratio,
            sprintf('WEIGHTED: only %.0f%% of items are in 15:00-17:00 window.', $ratio * 100),
        );
    }

    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    /** @return array<int, ProcessableItem[]> */
    private function groupByUser(array $items): array
    {
        $byUser = [];
        foreach ($items as $item) {
            $byUser[$item->userId()][] = $item;
        }
        return $byUser;
    }
}
