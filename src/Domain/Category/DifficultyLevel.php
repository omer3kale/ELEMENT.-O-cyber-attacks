<?php

declare(strict_types=1);

namespace ElementO\Domain\Category;

enum DifficultyLevel: string
{
    case Trivial     = 'TRIVIAL';
    case Easy        = 'EASY';
    case Medium      = 'MEDIUM';
    case Hard        = 'HARD';
    case Expert      = 'EXPERT';
    case NationState = 'NATION_STATE';

    // Display 

    public function label(): string
    {
        return match ($this) {
            self::Trivial     => 'Trivial',
            self::Easy        => 'Easy',
            self::Medium      => 'Medium',
            self::Hard        => 'Hard',
            self::Expert      => 'Expert',
            self::NationState => 'Nation-State',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Trivial     => 'No skill required — automated tools, script kiddies',
            self::Easy        => 'Basic technical knowledge, freely available toolkits',
            self::Medium      => 'Intermediate skill, some custom tooling needed',
            self::Hard        => 'Advanced expertise, significant resources required',
            self::Expert      => 'Elite offensive skill, custom zero-day development',
            self::NationState => 'APT-level: state-sponsored, unlimited resources, OPSEC',
        };
    }

    public function badgeClass(): string
    {
        return 'badge-' . strtolower(str_replace('_', '-', $this->value));
    }

    public function score(): int
    {
        return match ($this) {
            self::Trivial     => 1,
            self::Easy        => 2,
            self::Medium      => 3,
            self::Hard        => 4,
            self::Expert      => 5,
            self::NationState => 6,
        };
    }

    // Comparisons 

    public function isHarderThan(self $other): bool
    {
        return $this->score() > $other->score();
    }

    public function isEasierThan(self $other): bool
    {
        return $this->score() < $other->score();
    }

    // Factory 

    public static function fromDsl(string $raw): self
    {
        return self::from($raw);
    }
}
