<?php

declare(strict_types=1);

namespace ElementO\ProcessableItems\Infrastructure\Database;

use ElementO\ProcessableItems\Domain\User;

final class UserRepository
{
    public function __construct(
        private readonly ConnectionFactory $connectionFactory,
    ) {}

    /** @return User[] */
    public function findAll(): array
    {
        $stmt = $this->connectionFactory->getConnection()
            ->query('SELECT id, name FROM users ORDER BY id');

        return array_map(
            static fn (array $row): User => new User((int) $row['id'], $row['name']),
            $stmt->fetchAll(),
        );
    }

    public function save(User $user): User
    {
        $pdo  = $this->connectionFactory->getConnection();
        $stmt = $pdo->prepare('INSERT INTO users (name) VALUES (:name)');
        $stmt->execute([':name' => $user->name()]);

        return new User((int) $pdo->lastInsertId(), $user->name());
    }
}
