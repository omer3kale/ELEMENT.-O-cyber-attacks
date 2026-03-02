<?php

declare(strict_types=1);

namespace ElementO\Domain\Attack;

use InvalidArgumentException;

final readonly class AttackId
{

    private const PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

    private function __construct(
        public readonly string $value,
    ) {
        if (preg_match(self::PATTERN, $value) !== 1) {
            throw new InvalidArgumentException(
                "Invalid AttackId: \"{$value}\" is not a valid UUID v4."
            );
        }
    }

    // Named constructors

    public static function generate(): self
    {
        $data    = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40); // version 4
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80); // variant bits

        return new self(vsprintf(
            '%s%s-%s-%s-%s-%s%s%s',
            str_split(bin2hex($data), 4)
        ));
    }

    public static function fromString(string $value): self
    {
        return new self(strtolower($value));
    }

    // Value semantics 

    public function equals(self $other): bool
    {
        return strtolower($this->value) === strtolower($other->value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
