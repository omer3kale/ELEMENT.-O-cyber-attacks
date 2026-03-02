<?php

declare(strict_types=1);

namespace ElementO\Domain\Attack;

use InvalidArgumentException;

final readonly class CapecId
{
    private const PATTERN  = '/^CAPEC-\d+$/';
    private const BASE_URL = 'https://capec.mitre.org/data/definitions/';

    private function __construct(
        public readonly string $value,   
    ) {
        if (preg_match(self::PATTERN, $this->value) !== 1) {
            throw new InvalidArgumentException(
                "Invalid CAPEC ID: \"{$value}\". Expected format CAPEC-### (e.g. CAPEC-98)."
            );
        }
    }

    // Named constructors 

    public static function fromString(string $raw): self
    {
        return new self(strtoupper(trim($raw)));
    }

    // Domain behaviour 

    public function numericId(): int
    {
        return (int) str_replace('CAPEC-', '', $this->value);
    }

    public function url(): string
    {
        return self::BASE_URL . $this->numericId() . '.html';
    }

    // Value semantics 

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
