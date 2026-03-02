<?php

declare(strict_types=1);

namespace ElementO\Domain\Attack;

use InvalidArgumentException;

final readonly class MitreId
{

    private const PATTERN = '/^T\d{4}(\.\d{3})?$/';

    private const BASE_URL = 'https://attack.mitre.org/techniques/';

    private function __construct(
        public readonly string $value,
    ) {
        if (preg_match(self::PATTERN, $value) !== 1) {
            throw new InvalidArgumentException(
                "Invalid MITRE ATT&CK ID: \"{$value}\". " .
                'Expected format T#### or T####.###'
            );
        }
    }

    // Named constructors 

    public static function fromString(string $raw): self
    {
        return new self(strtoupper(trim($raw)));
    }

    // Domain behaviour 

    public function isSubTechnique(): bool
    {
        return str_contains($this->value, '.');
    }

    public function parentTechnique(): self
    {
        if (!$this->isSubTechnique()) {
            return $this;
        }

        return new self(explode('.', $this->value)[0]);
    }

    public function subTechniqueId(): ?string
    {
        if (!$this->isSubTechnique()) {
            return null;
        }

        return explode('.', $this->value)[1];
    }

    public function url(): string
    {
        if (!$this->isSubTechnique()) {
            return self::BASE_URL . $this->value . '/';
        }

        [$parent, $sub] = explode('.', $this->value);
        return self::BASE_URL . $parent . '/' . $sub . '/';
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
