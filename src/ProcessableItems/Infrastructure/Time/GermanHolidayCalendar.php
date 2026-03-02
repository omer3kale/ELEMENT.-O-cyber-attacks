<?php

declare(strict_types=1);

namespace ElementO\ProcessableItems\Infrastructure\Time;

use DateTimeImmutable;

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
            sprintf('%04d-01-01', $year),  
            sprintf('%04d-05-01', $year), 
            sprintf('%04d-10-03', $year),  
            sprintf('%04d-12-25', $year),  
            sprintf('%04d-12-26', $year),  

            // Easter-relative
            $easter->modify('-2 days')->format('Y-m-d'),  
            $easter->modify('+1 day')->format('Y-m-d'),   
            $easter->modify('+39 days')->format('Y-m-d'), 
            $easter->modify('+50 days')->format('Y-m-d'), 
        ];
    }

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
