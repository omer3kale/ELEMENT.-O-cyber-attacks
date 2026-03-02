<?php

declare(strict_types=1);

namespace ElementO\Domain\RealWorldCase;

use InvalidArgumentException;

final readonly class BrandImpersonation
{
    public function __construct(

        public readonly string $realBrand,

        public readonly string $spoofVariant,
    ) {
        if (trim($realBrand) === '') {
            throw new InvalidArgumentException('BrandImpersonation realBrand cannot be empty.');
        }

        if (trim($spoofVariant) === '') {
            throw new InvalidArgumentException('BrandImpersonation spoofVariant cannot be empty.');
        }
    }

    // Named constructors 

    public static function create(string $realBrand, string $spoofVariant): self
    {
        return new self($realBrand, $spoofVariant);
    }

    // Domain behaviour 

    public function techniqueCategory(): string
    {
        $variant = strtolower($this->spoofVariant);

        return match (true) {
            str_contains($variant, 'homoglyph')
                || str_contains($variant, 'cyrillic')
                || str_contains($variant, 'unicode')   => 'Homoglyph',

            str_contains($variant, 'digit')
                || preg_match('/[0-9]→|→[0-9]/', $variant) === 1
                                                        => 'Digit substitution',

            str_contains($variant, 'subdomain')        => 'Subdomain spoofing',

            str_contains($variant, 'tld')
                || str_contains($variant, '.co')        => 'TLD swap',

            str_contains($variant, 'insert')
               || str_contains($variant, 'extra')       => 'Character insertion',

            str_contains($variant, 'remov')
                || str_contains($variant, 'delet')      => 'Character removal',

            str_contains($variant, 'swap')
                || str_contains($variant, 'transpos')   => 'Transposition',

            default                                     => 'Character substitution',
        };
    }

    public function brandSlug(): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($this->realBrand)));
    }

    public function displayLine(): string
    {
        
        $spoof = trim(explode('(', $this->spoofVariant)[0]);

        return "{$this->realBrand} → {$spoof}";
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'real_brand'    => $this->realBrand,
            'spoof_variant' => $this->spoofVariant,
            'technique'     => $this->techniqueCategory(),
            'display'       => $this->displayLine(),
        ];
    }

    // Value semantics 
    public function equals(self $other): bool
    {
        return $this->realBrand    === $other->realBrand
            && $this->spoofVariant === $other->spoofVariant;
    }

    public function __toString(): string
    {
        return $this->displayLine();
    }
}
