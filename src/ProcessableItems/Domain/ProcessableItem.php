<?php

declare(strict_types=1);

namespace ElementO\ProcessableItems\Domain;

use DateTimeImmutable;

final class ProcessableItem
{
    public function __construct(
        private readonly int|null          $id,
        private readonly string            $name,
        private readonly int               $userId,
        private readonly DateTimeImmutable $scheduledAt,
        private readonly DateTimeImmutable|null $processedAt,
        private readonly string            $status,
        private readonly string|null       $statusMessage,
    ) {}

    /**
     * Factory for a freshly scheduled item (status = pending, not yet processed).
     */
    public static function scheduled(
        string            $name,
        int               $userId,
        DateTimeImmutable $scheduledAt,
    ): self {
        return new self(
            id:            null,
            name:          $name,
            userId:        $userId,
            scheduledAt:   $scheduledAt,
            processedAt:   null,
            status:        'pending',
            statusMessage: null,
        );
    }

    public function id(): int|null
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function scheduledAt(): DateTimeImmutable
    {
        return $this->scheduledAt;
    }

    public function processedAt(): DateTimeImmutable|null
    {
        return $this->processedAt;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function statusMessage(): string|null
    {
        return $this->statusMessage;
    }

    public function withId(int $id): self
    {
        return new self(
            $id,
            $this->name,
            $this->userId,
            $this->scheduledAt,
            $this->processedAt,
            $this->status,
            $this->statusMessage,
        );
    }
}
