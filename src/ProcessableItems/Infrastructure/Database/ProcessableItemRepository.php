<?php

declare(strict_types=1);

namespace ElementO\ProcessableItems\Infrastructure\Database;

use DateTimeImmutable;
use ElementO\ProcessableItems\Domain\ProcessableItem;

final class ProcessableItemRepository
{
    public function __construct(
        private readonly ConnectionFactory $connectionFactory,
    ) {}

    /**
     * Persist all items, assigning DB-generated IDs back onto each item.
     *
     * @param ProcessableItem[] $items
     */
    public function saveAll(array $items): void
    {
        $pdo  = $this->connectionFactory->getConnection();
        $stmt = $pdo->prepare(<<<SQL
            INSERT INTO processable_items
                (name, user_id, scheduled_at, processed_at, status, status_message)
            VALUES
                (:name, :user_id, :scheduled_at, :processed_at, :status, :status_message)
        SQL);

        foreach ($items as $item) {
            $stmt->execute([
                ':name'           => $item->name(),
                ':user_id'        => $item->userId(),
                ':scheduled_at'   => $item->scheduledAt()->format('Y-m-d H:i:s'),
                ':processed_at'   => $item->processedAt()?->format('Y-m-d H:i:s'),
                ':status'         => $item->status(),
                ':status_message' => $item->statusMessage(),
            ]);
        }
    }

    /**
     * @return ProcessableItem[]
     */
    public function findByUserAndRange(
        int               $userId,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
    ): array {
        $stmt = $this->connectionFactory->getConnection()->prepare(<<<SQL
            SELECT * FROM processable_items
            WHERE user_id    = :user_id
              AND scheduled_at >= :start
              AND scheduled_at <= :end
            ORDER BY scheduled_at
        SQL);

        $stmt->execute([
            ':user_id' => $userId,
            ':start'   => $start->format('Y-m-d H:i:s'),
            ':end'     => $end->format('Y-m-d H:i:s'),
        ]);

        return array_map(
            static fn (array $row): ProcessableItem => new ProcessableItem(
                id:            (int) $row['id'],
                name:          $row['name'],
                userId:        (int) $row['user_id'],
                scheduledAt:   new DateTimeImmutable($row['scheduled_at']),
                processedAt:   $row['processed_at'] !== null
                    ? new DateTimeImmutable($row['processed_at'])
                    : null,
                status:        $row['status'],
                statusMessage: $row['status_message'],
            ),
            $stmt->fetchAll(),
        );
    }
}
