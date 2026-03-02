<?php

declare(strict_types=1);

namespace ElementO\Domain\Attack;

use InvalidArgumentException;


final readonly class SuccessRate
{

    private const PATTERN = '/^(\d{1,3})-(\d{1,3})%$/';

    private function __construct(
        public readonly int $min,   
        public readonly int $max,   
    ) {
        if ($min < 0 || $min > 100) {
            throw new InvalidArgumentException(
                "SuccessRate min must be 0-100, got {$min}."
            );
        }
        if ($max < 0 || $max > 100) {
            throw new InvalidArgumentException(
                "SuccessRate max must be 0-100, got {$max}."
            );
        }
        if ($min > $max) {
            throw new InvalidArgumentException(
                "SuccessRate min ({$min}) cannot exceed max ({$max})."
            );
        }
    }

    public static function fromDslToken(string $token): self
    {
        $clean = trim($token, '"');

        if (preg_match(self::PATTERN, $clean, $matches) !== 1) {
            throw new InvalidArgumentException(
                "Invalid success_rate value: \"{$token}\". " .
                'Expected format MIN-MAX% (e.g. 45-65%).'
            );
        }

        return new self((int) $matches[1], (int) $matches[2]);
    }

    public static function fromString(string $value): self
    {
        return self::fromDslToken($value);
    }

    public static function fromRange(int $min, int $max): self
    {
        return new self($min, $max);
    }

    // Domain behaviour 

    public function midpoint(): float
    {
        return ($this->min + $this->max) / 2.0;
    }

    public function average(): float
    {
        return $this->midpoint();
    }

    public function spread(): int
    {
        return $this->max - $this->min;
    }

    public function isHighRisk(): bool
    {
        return $this->midpoint() >= 50.0;
    }

    public function riskTier(): string
    {
        return match (true) {
            $this->midpoint() >= 70 => 'critical',
            $this->midpoint() >= 50 => 'high',
            $this->midpoint() >= 25 => 'medium',
            default                 => 'low',
        };
    }

    public function toDslString(): string
    {
        return "{$this->min}-{$this->max}%";
    }

    public function formatted(): string
    {
        return $this->toDslString();
    }

    // Value semantics 

    public function equals(self $other): bool
    {
        return $this->min === $other->min && $this->max === $other->max;
    }

    public function __toString(): string
    {
        return $this->toDslString();
    }
}
