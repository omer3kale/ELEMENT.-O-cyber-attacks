<?php

declare(strict_types=1);

namespace ElementO\ProcessableItems\Infrastructure\Database;

use InvalidArgumentException;
use PDO;

/**
 * Creates and initialises a SQLite PDO connection.
 * When $dsn is omitted the connection targets the project-level data/ directory;
 * pass 'sqlite::memory:' in tests for an ephemeral in-process database.
 *
 * Multi-tenancy:
 *   Use `forTenant()` to get a dedicated SQLite file per tenant. Each tenant
 *   slug produces an isolated database `data/{slug}.sqlite` so row-level
 *   data never leaks across tenants. Schema is applied automatically on first
 *   connection, just like the single-tenant setup.
 */
final class ConnectionFactory
{
    private PDO|null $pdo = null;

    public function __construct(
        private readonly string $dsn,
    ) {}

    public static function forFile(string $projectRoot): self
    {
        $dataDir = $projectRoot . '/data';
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0777, true);
        }

        return new self('sqlite:' . $dataDir . '/processable_items.sqlite');
    }

    /**
     * Returns a ConnectionFactory whose SQLite database is isolated to a
     * single named tenant.
     *
     * The tenant slug must consist only of lowercase letters, digits, and
     * hyphens (1–64 characters) to prevent path-traversal attacks.
     * The database file is created at `{$baseDir}/{$tenantSlug}.sqlite`.
     *
     * @param  string $tenantSlug  Identifier for the tenant (e.g. "acme-corp").
     * @param  string $baseDir     Directory where tenant databases live.
     * @throws InvalidArgumentException When $tenantSlug contains invalid characters.
     */
    public static function forTenant(string $tenantSlug, string $baseDir = 'data'): self
    {
        if (!preg_match('/^[a-z0-9][a-z0-9\-]{0,62}[a-z0-9]$|^[a-z0-9]$/', $tenantSlug)) {
            throw new InvalidArgumentException(
                "Invalid tenant slug \"{$tenantSlug}\". "
                . 'Slugs must be 1–64 characters: lowercase letters, digits, and hyphens only, '
                . 'and must not start or end with a hyphen.',
            );
        }

        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0777, true);
        }

        return new self('sqlite:' . rtrim($baseDir, '/') . '/' . $tenantSlug . '.sqlite');
    }

    public function getConnection(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO($this->dsn);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->applySchema($this->pdo);
        }

        return $this->pdo;
    }

    private function applySchema(PDO $pdo): void
    {
        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS users (
                id   INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL
            );

            CREATE TABLE IF NOT EXISTS processable_items (
                id            INTEGER PRIMARY KEY AUTOINCREMENT,
                name          TEXT    NOT NULL,
                user_id       INTEGER NOT NULL,
                scheduled_at  TEXT    NOT NULL,
                processed_at  TEXT    NULL,
                status        TEXT    NOT NULL,
                status_message TEXT   NULL,
                FOREIGN KEY(user_id) REFERENCES users(id)
            );
        SQL);
    }
}
