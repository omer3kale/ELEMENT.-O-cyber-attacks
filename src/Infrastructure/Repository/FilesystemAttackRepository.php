<?php

declare(strict_types=1);

namespace ElementO\Infrastructure\Repository;

use ElementO\Domain\Attack\AttackAggregate;
use ElementO\Domain\Attack\AttackId;
use ElementO\Domain\Attack\AttackRepository;
use ElementO\Domain\Attack\MitreId;
use ElementO\Domain\Category\AttackCategory;
use ElementO\Domain\Category\DifficultyLevel;

final class FilesystemAttackRepository implements AttackRepository
{
    private array $byId     = [];
    private array $byMitreId = [];
    private array $all      = [];

    /**
     * @param list<AttackAggregate> $attacks
     */
    public function __construct(array $attacks = [])
    {
        foreach ($attacks as $attack) {
            $this->index($attack);
        }
    }

    public function save(AttackAggregate $attack): void
    {
        $id     = $attack->id->value;
        $mitre  = $attack->mitreId->value;

        if (isset($this->byId[$id])) {
            $this->all = array_values(
                array_filter($this->all, fn (AttackAggregate $a) => $a->id->value !== $id)
            );
        }

        $this->index($attack);
    }

    public function findById(AttackId $id): ?AttackAggregate
    {
        return $this->byId[$id->value] ?? null;
    }

    public function findByMitreId(MitreId $mitreId): ?AttackAggregate
    {
        return $this->byMitreId[$mitreId->value] ?? null;
    }

    public function findByCategory(AttackCategory $category): array
    {
        return array_values(
            array_filter($this->all, fn (AttackAggregate $a) => $a->category === $category)
        );
    }

    public function findByDifficulty(DifficultyLevel $difficulty): array
    {
        return array_values(
            array_filter($this->all, fn (AttackAggregate $a) => $a->difficulty === $difficulty)
        );
    }

    public function findByPlatform(string $platform): array
    {
        return array_values(
            array_filter($this->all, fn (AttackAggregate $a) => in_array($platform, $a->platforms, strict: true))
        );
    }

    public function findAll(): array
    {
        return $this->all;
    }

    public function count(): int
    {
        return count($this->all);
    }

    public function exists(MitreId $mitreId): bool
    {
        return isset($this->byMitreId[$mitreId->value]);
    }

    public function delete(AttackId $id): void
    {
        if (!isset($this->byId[$id->value])) {
            return;
        }

        $attack = $this->byId[$id->value];

        unset($this->byId[$id->value]);
        unset($this->byMitreId[$attack->mitreId->value]);

        $this->all = array_values(
            array_filter($this->all, fn (AttackAggregate $a) => $a->id->value !== $id->value)
        );
    }

    public function clear(): void
    {
        $this->byId      = [];
        $this->byMitreId = [];
        $this->all       = [];
    }

    private function index(AttackAggregate $attack): void
    {
        $this->all[]                            = $attack;
        $this->byId[$attack->id->value]         = $attack;
        $this->byMitreId[$attack->mitreId->value] = $attack;
    }
}
