<?php

declare(strict_types=1);

namespace ElementO\ProcessableItems\Infrastructure\Time;

use DateTimeImmutable;

/**
 * Provides German federal public holiday detection for a rolling window of years.
 *
 * Scope note: Only nation-wide (federal) holidays are covered. State-specific
 * holidays (e.g. Corpus Christi, Epiphany in Bavaria) are omitted — a full
 * per-state implementation is out of scope for this challenge.
 *
 * Easter-based dates are computed algorithmically (Anonymous Gregorian / Meeus
 * algorithm) so the calendar stays correct across years without manual updates.
 */
final class GermanHolidayCalendar
{
    /** @var array<string, true>  key = 'Y-m-d' */
    private array $cache = [];

    public function isHoliday(DateTimeImmutable $date): bool
    {
        $year = (int) $date->format('Y');
        $key  = $date->format('Y-m-d');

        if (!isset($this->cache[$year])) {
            foreach ($this->holidaysForYear($year) as $d) {
                $this->cache[$d] = true;
            }
            // sentinel so we don't recompute
            $this->cache[$year] = true;
        }

        return isset($this->cache[$key]);
    }

    /** @return string[]  'Y-m-d' strings */
    private function holidaysForYear(int $year): array
    {
        $easter = $this->easterSunday($year);

        return [
            // Fixed dates
            sprintf('%04d-01-01', $year),  // New Year's Day
            sprintf('%04d-05-01', $year),  // Labour Day
            sprintf('%04d-10-03', $year),  // German Unity Day
            sprintf('%04d-12-25', $year),  // Christmas Day
            sprintf('%04d-12-26', $year),  // Second Christmas Day

            // Easter-relative
            $easter->modify('-2 days')->format('Y-m-d'),  // Good Friday
            $easter->modify('+1 day')->format('Y-m-d'),   // Easter Monday
            $easter->modify('+39 days')->format('Y-m-d'), // Ascension Day
            $easter->modify('+50 days')->format('Y-m-d'), // Whit Monday
        ];
    }

    /**
     * Computes Easter Sunday using the Anonymous Gregorian algorithm.
     */
    private function easterSunday(int $year): DateTimeImmutable
    {
        $a = $year % 19;
        $b = intdiv($year, 100);
        $c = $year % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day   = (($h + $l - 7 * $m + 114) % 31) + 1;

        return new DateTimeImmutable(sprintf('%04d-%02d-%02d', $year, $month, $day));
    }
}
