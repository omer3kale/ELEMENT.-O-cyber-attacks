<?php

declare(strict_types=1);

namespace ElementO\Domain\Category;

enum DetectionDifficulty: string
{
    case Trivial          = 'TRIVIAL';
    case Low              = 'LOW';
    case Medium           = 'MEDIUM';
    case High             = 'HIGH';
    case NearlyImpossible = 'NEARLY_IMPOSSIBLE';

    // Display 

    public function label(): string
    {
        return match ($this) {
            self::Trivial          => 'Trivial',
            self::Low              => 'Low',
            self::Medium           => 'Medium',
            self::High             => 'High',
            self::NearlyImpossible => 'Nearly Impossible',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Trivial          => 'Detected by basic AV / IDS signatures immediately',
            self::Low              => 'Standard SIEM rules catch it within hours',
            self::Medium           => 'Requires tuned detection rules and log correlation',
            self::High             => 'Evades most EDR; needs behavioural analysis + threat hunting',
            self::NearlyImpossible => 'Fileless / LOTL / firmware; invisible to most defenders',
        };
    }

    public function score(): int
    {
        return match ($this) {
            self::Trivial          => 1,
            self::Low              => 2,
            self::Medium           => 3,
            self::High             => 4,
            self::NearlyImpossible => 5,
        };
    }

    public function minimumLogSource(): string
    {
        return match ($this) {
            self::Trivial          => 'Antivirus alerts',
            self::Low              => 'Firewall + proxy logs',
            self::Medium           => 'SIEM with EDR telemetry',
            self::High             => 'Full packet capture + memory forensics',
            self::NearlyImpossible => 'Firmware integrity monitoring + hardware attestation',
        };
    }

    // Factory 

    public static function fromDsl(string $raw): self
    {
        return self::from($raw);
    }
}
