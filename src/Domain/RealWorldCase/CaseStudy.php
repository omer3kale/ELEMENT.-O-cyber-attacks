<?php

declare(strict_types=1);

namespace ElementO\Domain\RealWorldCase;

use InvalidArgumentException;

final readonly class CaseStudy
{
    private const YEAR_MIN = 1988;   
    private const YEAR_MAX = 2030;   

    public function __construct(
        public readonly int     $year,

        public readonly string  $victim,

        public readonly string  $impact,

        public readonly ?string $attribution = null,
    ) {
        if ($year < self::YEAR_MIN || $year > self::YEAR_MAX) {
            throw new InvalidArgumentException(
                "CaseStudy year {$year} is out of range "
                . '[' . self::YEAR_MIN . ', ' . self::YEAR_MAX . '].'
            );
        }

        if (trim($victim) === '') {
            throw new InvalidArgumentException('CaseStudy victim cannot be empty.');
        }

        if (trim($impact) === '') {
            throw new InvalidArgumentException('CaseStudy impact cannot be empty.');
        }
    }

    // Named constructors 

    public static function create(
        int     $year,
        string  $victim,
        string  $impact,
        ?string $attribution = null,
    ): self {
        return new self($year, $victim, $impact, $attribution);
    }

    public static function withUnknownAttribution(
        int    $year,
        string $victim,
        string $impact,
    ): self {
        return new self($year, $victim, $impact, null);
    }

    // Domain behaviour 

    public function hasAttribution(): bool
    {
        return $this->attribution !== null;
    }

    public function isStateSponsoredSuspect(): bool
    {
        if ($this->attribution === null) {
            return false;
        }

        $stateSponsoredKeywords = [
            'APT', 'Lazarus', 'Cozy Bear', 'Fancy Bear', 'Sandworm',
            'HAFNIUM', 'Volt Typhoon', 'Salt Typhoon', 'GRU', 'FSB',
            'DPRK', 'PLA Unit', 'MSS', 'IRGC', 'OilRig',
        ];

        foreach ($stateSponsoredKeywords as $keyword) {
            if (str_contains($this->attribution, $keyword)) {
                return true;
            }
        }

        return false;
    }

    public function summary(): string
    {
        $base = "{$this->year} — {$this->victim}: {$this->impact}";

        if ($this->attribution !== null) {
            $base .= " [{$this->attribution}]";
        }

        return $base;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'year'        => $this->year,
            'victim'      => $this->victim,
            'impact'      => $this->impact,
            'attribution' => $this->attribution,
        ];
    }

    // Value semantics 

    public function equals(self $other): bool
    {
        return $this->year       === $other->year
            && $this->victim     === $other->victim
            && $this->impact     === $other->impact
            && $this->attribution === $other->attribution;
    }

    public function __toString(): string
    {
        return $this->summary();
    }
}
