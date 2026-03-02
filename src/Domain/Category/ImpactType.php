<?php

declare(strict_types=1);

namespace ElementO\Domain\Category;

enum ImpactType: string
{
    case Financial         = 'FINANCIAL';
    case DataTheft         = 'DATA_THEFT';
    case ServiceDisruption = 'SERVICE_DISRUPTION';
    case Reputational      = 'REPUTATIONAL';
    case PhysicalImpact    = 'PHYSICAL_IMPACT';
    case Espionage         = 'ESPIONAGE';
    case Sabotage          = 'SABOTAGE';

    // Display
    public function label(): string
    {
        return match ($this) {
            self::Financial         => 'Financial',
            self::DataTheft         => 'Data Theft',
            self::ServiceDisruption => 'Service Disruption',
            self::Reputational      => 'Reputational',
            self::PhysicalImpact    => 'Physical',
            self::Espionage         => 'Espionage',
            self::Sabotage          => 'Sabotage',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Financial         => 'Direct monetary loss: wire fraud, ransom, fines',
            self::DataTheft         => 'Confidential data exfiltrated: PII, IP, credentials',
            self::ServiceDisruption => 'Availability impact: downtime, DDoS, wiper, ransomware',
            self::Reputational      => 'Brand damage, loss of customer trust, stock decline',
            self::PhysicalImpact    => 'Real-world damage: ICS/SCADA sabotage, safety systems',
            self::Espionage         => 'Long-term undetected intelligence collection',
            self::Sabotage          => 'Deliberate destruction of data, systems, or infrastructure',
        };
    }

    public function faIcon(): string
    {
        return match ($this) {
            self::Financial         => 'fa-dollar-sign',      
            self::DataTheft         => 'fa-database',         
            self::ServiceDisruption => 'fa-server',           
            self::Reputational      => 'fa-building-columns', 
            self::PhysicalImpact    => 'fa-industry',         
            self::Espionage         => 'fa-user-secret',      
            self::Sabotage          => 'fa-bomb',             
        };
    }

    public function reportCode(): string
    {
        return match ($this) {
            self::Financial         => 'FIN',
            self::DataTheft         => 'EXFIL',
            self::ServiceDisruption => 'AVAIL',
            self::Reputational      => 'BRAND',
            self::PhysicalImpact    => 'ICS',
            self::Espionage         => 'INTEL',
            self::Sabotage          => 'DEST',
        };
    }

    public function requiresGdprNotification(): bool
    {
        return match ($this) {
            self::DataTheft, self::Espionage => true,
            default                          => false,
        };
    }

    // Factory 
    public static function fromDsl(string $raw): self
    {
        return self::from($raw);
    }
}
