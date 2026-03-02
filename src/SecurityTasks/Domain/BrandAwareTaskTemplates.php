<?php

declare(strict_types=1);

namespace ElementO\SecurityTasks\Domain;

final class BrandAwareTaskTemplates
{
    /**
     * @param  string                  $brandName  Display name of the brand/tenant.
     * @param  array<string, string[]> $overrides  Map of attackName → task strings.
     */
    private function __construct(
        private readonly string $brandName,
        private readonly array  $overrides,
    ) {}

    /**
     * @param  array<string, string[]> $overrides
     */
    public static function create(string $brandName, array $overrides = []): self
    {
        if (trim($brandName) === '') {
            throw new \InvalidArgumentException('Brand name must not be empty.');
        }

        return new self(trim($brandName), $overrides);
    }

    public function brandName(): string
    {
        return $this->brandName;
    }

    /**
     * @return string[]|null
     */
    public function overridesFor(string $attackName): ?array
    {
        return $this->overrides[$attackName] ?? null;
    }

    public function hasOverrides(): bool
    {
        return !empty($this->overrides);
    }

    /**
     * Returns a copy with an additional or replaced per-attack override.
     *
     * @param  string[] $taskNames
     */
    public function withOverride(string $attackName, array $taskNames): self
    {
        $overrides               = $this->overrides;
        $overrides[$attackName]  = $taskNames;
        return new self($this->brandName, $overrides);
    }

    /**
     * Returns a copy with a different brand name.
     */
    public function withBrandName(string $brandName): self
    {
        return new self($brandName, $this->overrides);
    }
}
