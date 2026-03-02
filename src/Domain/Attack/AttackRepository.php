<?php

declare(strict_types=1);

namespace ElementO\Domain\Attack;

use ElementO\Domain\Category\AttackCategory;
use ElementO\Domain\Category\DifficultyLevel;

interface AttackRepository
{

    // Write operations

    public function save(AttackAggregate $attack): void;

    public function delete(AttackId $id): void;

    public function clear(): void;


    // Read 


    public function findById(AttackId $id): ?AttackAggregate;

    public function findByMitreId(MitreId $mitreId): ?AttackAggregate;

    // Read 

    /**
     * @return list<AttackAggregate>
     */
    public function findByCategory(AttackCategory $category): array;

    /**
     * @return list<AttackAggregate>
     */
    public function findByDifficulty(DifficultyLevel $difficulty): array;

    /**
     * @return list<AttackAggregate>
     */
    public function findByPlatform(string $platform): array;

    /**
     * @return list<AttackAggregate>
     */
    public function findAll(): array;


    // Aggregate queries


    public function count(): int;

    public function exists(MitreId $mitreId): bool;
}
