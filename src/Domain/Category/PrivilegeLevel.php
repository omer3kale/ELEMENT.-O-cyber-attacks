<?php

declare(strict_types=1);

namespace ElementO\Domain\Category;

enum PrivilegeLevel: string
{
    case None          = 'NONE';
    case User          = 'USER';
    case Administrator = 'ADMINISTRATOR';
    case System        = 'SYSTEM';
    case Root          = 'ROOT';

    // Display 
    public function label(): string
    {
        return match ($this) {
            self::None          => 'None',
            self::User          => 'User',
            self::Administrator => 'Administrator',
            self::System        => 'SYSTEM',
            self::Root          => 'root',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::None          => 'No prior access required — unauthenticated remote execution',
            self::User          => 'Standard unprivileged user account sufficient',
            self::Administrator => 'Local or domain administrator rights required (Windows)',
            self::System        => 'NT AUTHORITY\\SYSTEM token required (Windows kernel-level)',
            self::Root          => 'Unix root / UID 0 required',
        };
    }

    public function score(): int
    {
        return match ($this) {
            self::None          => 0,
            self::User          => 1,
            self::Administrator => 2,
            self::System        => 3,
            self::Root          => 3,   
        };
    }

    public function isElevated(): bool
    {
        return match ($this) {
            self::None, self::User => false,
            default                => true,
        };
    }

    // Factory 

    public static function fromDsl(string $raw): self
    {
        return self::from($raw);
    }
}
