<?php

declare(strict_types=1);

namespace ElementO\Tests\ProcessableItems;

use DateTimeImmutable;
use ElementO\ProcessableItems\Application\ProcessableItemsService;
use ElementO\ProcessableItems\Domain\DistributionStrategy;
use ElementO\ProcessableItems\Domain\User;
use ElementO\ProcessableItems\Infrastructure\Database\ConnectionFactory;
use ElementO\ProcessableItems\Infrastructure\Database\ProcessableItemRepository;
use ElementO\ProcessableItems\Infrastructure\Time\GermanHolidayCalendar;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests for multi-tenant ConnectionFactory::forTenant().
 *
 * File-based tests use a per-class temporary directory that is removed on
 * tearDown so no artefacts linger in the project tree.
 */
final class ConnectionFactoryTenantTest extends TestCase
{
    private string $tmpDir;

    protected function setUp(): void
    {
        $this->tmpDir = sys_get_temp_dir() . '/element-o-tenant-tests-' . getmypid();
        if (!is_dir($this->tmpDir)) {
            mkdir($this->tmpDir, 0777, true);
        }
    }

    protected function tearDown(): void
    {
        // Remove all SQLite files created during tests
        foreach (glob($this->tmpDir . '/*.sqlite') ?: [] as $f) {
            @unlink($f);
        }
        @rmdir($this->tmpDir);
    }

    // -----------------------------------------------------------------------
    // 1. Valid slug → ConnectionFactory is created and schema is applied
    // -----------------------------------------------------------------------

    public function testForTenantWithValidSlugCreatesDatabase(): void
    {
        $factory = ConnectionFactory::forTenant('acme-corp', $this->tmpDir);
        $pdo     = $factory->getConnection();

        // Schema should exist after first getConnection()
        $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll();
        $names  = array_column($tables, 'name');

        $this->assertContains('users',             $names, 'users table missing.');
        $this->assertContains('processable_items', $names, 'processable_items table missing.');
    }

    public function testForTenantWithSingleCharSlugIsValid(): void
    {
        $factory = ConnectionFactory::forTenant('a', $this->tmpDir);
        $this->assertNotNull($factory->getConnection());
    }

    // -----------------------------------------------------------------------
    // 2. Invalid slug → InvalidArgumentException
    // -----------------------------------------------------------------------

    #[DataProvider('invalidSlugProvider')]
    public function testForTenantWithInvalidSlugThrows(string $slug): void
    {
        $this->expectException(InvalidArgumentException::class);
        ConnectionFactory::forTenant($slug, $this->tmpDir);
    }

    /** @return array<string, array{string}> */
    public static function invalidSlugProvider(): array
    {
        return [
            'empty string'         => [''],
            'starts with hyphen'   => ['-acme'],
            'ends with hyphen'     => ['acme-'],
            'uppercase letter'     => ['ACME'],
            'path traversal'       => ['../etc/passwd'],
            'slash in slug'        => ['acme/corp'],
            'space in slug'        => ['acme corp'],
            'too long (65 chars)'  => [str_repeat('a', 65)],
        ];
    }

    // -----------------------------------------------------------------------
    // 3. Two tenants are isolated — data written to A never appears in B
    // -----------------------------------------------------------------------

    public function testTenantDataIsIsolated(): void
    {
        $start  = new DateTimeImmutable('2026-03-09 09:00');
        $end    = new DateTimeImmutable('2026-03-13 17:00');
        $userA  = new User(1, 'AliceTenantA');
        $userB  = new User(1, 'BobTenantB');

        // --- Tenant A ---
        $factoryA = ConnectionFactory::forTenant('tenant-alpha', $this->tmpDir);
        $serviceA = new ProcessableItemsService(
            new ProcessableItemRepository($factoryA),
            new GermanHolidayCalendar(),
        );
        $itemsA = $serviceA->scheduleItems(
            users:              [$userA],
            amountPerUser:      2,
            start:              $start,
            end:                $end,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::EVEN,
        );

        // --- Tenant B ---
        $factoryB = ConnectionFactory::forTenant('tenant-beta', $this->tmpDir);
        $serviceB = new ProcessableItemsService(
            new ProcessableItemRepository($factoryB),
            new GermanHolidayCalendar(),
        );
        $itemsB = $serviceB->scheduleItems(
            users:              [$userB],
            amountPerUser:      3,
            start:              $start,
            end:                $end,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::EVEN,
        );

        // Verify correct counts per tenant
        $this->assertCount(2, $itemsA, 'Tenant A should have exactly 2 items.');
        $this->assertCount(3, $itemsB, 'Tenant B should have exactly 3 items.');

        // Verify database isolation: each tenant's SQLite file contains only
        // its own rows — the counts reflect independent storage, not a shared pool.
        $countInA = (int) $factoryA->getConnection()
            ->query('SELECT COUNT(*) FROM processable_items')
            ->fetchColumn();
        $countInB = (int) $factoryB->getConnection()
            ->query('SELECT COUNT(*) FROM processable_items')
            ->fetchColumn();

        $this->assertSame(2, $countInA, 'Tenant A database should contain exactly 2 rows.');
        $this->assertSame(3, $countInB, 'Tenant B database should contain exactly 3 rows.');

        // Verify SQLite files are separate
        $this->assertFileExists($this->tmpDir . '/tenant-alpha.sqlite');
        $this->assertFileExists($this->tmpDir . '/tenant-beta.sqlite');
    }

    // -----------------------------------------------------------------------
    // 4. Tenant data persists across reconnection (same slug reuses db file)
    // -----------------------------------------------------------------------

    public function testTenantDatabasePersistsBetweenConnections(): void
    {
        $start = new DateTimeImmutable('2026-03-09 09:00');
        $end   = new DateTimeImmutable('2026-03-13 17:00');
        $user  = new User(1, 'PersistUser');

        // First connection — write 2 items
        $factory1 = ConnectionFactory::forTenant('persist-test', $this->tmpDir);
        $service1 = new ProcessableItemsService(
            new ProcessableItemRepository($factory1),
            new GermanHolidayCalendar(),
        );
        $service1->scheduleItems(
            users:              [$user],
            amountPerUser:      2,
            start:              $start,
            end:                $end,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::EVEN,
        );

        // Second connection to the same slug — verify rows still exist
        $factory2 = ConnectionFactory::forTenant('persist-test', $this->tmpDir);
        $pdo      = $factory2->getConnection();
        $count    = (int) $pdo->query('SELECT COUNT(*) FROM processable_items')->fetchColumn();

        $this->assertGreaterThanOrEqual(2, $count, 'Rows should persist across reconnection.');
    }
}
