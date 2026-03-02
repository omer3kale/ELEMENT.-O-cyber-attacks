<?php

declare(strict_types=1);

namespace ElementO\SecurityTasks\Domain;

/**
 * Immutable value object that carries brand-specific customisations for
 * security task names.
 *
 * When a `BrandAwareTaskTemplates` instance is injected into
 * `SecurityTaskGenerator`, task names are shaped in two ways:
 *
 *   1. **Per-attack overrides** – if `$overrides` contains an entry for the
 *      attack name, those strings are used verbatim (the caller is responsible
 *      for any brand-name embedding within the strings).
 *
 *   2. **Brand-name prefix** – for every task name that does NOT have an
 *      explicit override, the brand name is prepended as a secondary tag,
 *      e.g. "[ACME Bank] [SOCIAL-ENG] Run phishing simulation for …".
 *      This lets operators quickly filter tasks by customer / tenant.
 *
 * Design decisions:
 *   - The object is final and has no setters; use `withOverride()` or
 *     `withBrandName()` to derive modified copies (copy-on-write).
 *   - Override keys are indexed by exact attack name (case-sensitive),
 *     mirroring the `$attack->name` field of `AttackAggregate`.
 *
 * Example usage:
 * ```php
 * $templates = BrandAwareTaskTemplates::create(
 *     brandName: 'ACME Bank',
 *     overrides: [
 *         'BankingAndPaymentCredentialPhishing' => [
 *             '[ACME Bank] Run ACME-specific wire-transfer alert test',
 *             '[ACME Bank] Update ACME fraud-detection rules for credential phishing',
 *         ],
 *     ],
 * );
 * $generator = new SecurityTaskGenerator($attackRepo, $service, $templates);
 * ```
 */
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
     * Returns explicit task-name overrides for the given attack name, or null
     * when no override is registered (caller falls back to generic templates).
     *
     * @return string[]|null
     */
    public function overridesFor(string $attackName): ?array
    {
        return $this->overrides[$attackName] ?? null;
    }

    /**
     * Returns true when at least one per-attack override exists.
     */
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
