#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * bin/run-all-tenants.php
 *
 * Hosted-operator script: iterate over every configured tenant slug and
 * run the security task generator for each one.
 *
 * Tenant discovery (first match wins):
 *   1. JSON file path in $TENANTS_FILE env var  (e.g. /etc/element-io/tenants.json)
 *   2. Comma-separated list in $TENANTS env var  (e.g. "acme-corp,globex-inc")
 *   3. Default file ./tenants.json relative to the project root
 *
 * Environment variables:
 *   TENANTS_FILE   Path to a JSON file containing a flat array of slug strings.
 *   TENANTS        Comma-separated slug list (overridden by TENANTS_FILE).
 *   DATA_DIR       Base directory for per-tenant SQLite files. Default: ./data
 *   TZ             PHP timezone. Default: UTC
 *
 * Usage:
 *   php bin/run-all-tenants.php
 *   TENANTS=acme-corp,globex-inc php bin/run-all-tenants.php
 *   TENANTS_FILE=/etc/element-io/tenants.json php bin/run-all-tenants.php
 */

use ElementO\Infrastructure\Parser\ANTLRParserAdapter;
use ElementO\Infrastructure\Repository\FilesystemAttackRepository;
use ElementO\ProcessableItems\Application\ProcessableItemsService;
use ElementO\ProcessableItems\Domain\DistributionStrategy;
use ElementO\ProcessableItems\Domain\User;
use ElementO\ProcessableItems\Infrastructure\Database\ConnectionFactory;
use ElementO\ProcessableItems\Infrastructure\Database\ProcessableItemRepository;
use ElementO\ProcessableItems\Infrastructure\Database\UserRepository;
use ElementO\ProcessableItems\Infrastructure\Time\GermanHolidayCalendar;
use ElementO\SecurityTasks\Application\SecurityTaskGenerator;

$projectRoot = dirname(__DIR__);
require $projectRoot . '/vendor/autoload.php';

// ── Timezone ─────────────────────────────────────────────────────────────────
$tz = getenv('TZ') ?: 'UTC';
date_default_timezone_set($tz);

// ── Tenant discovery ─────────────────────────────────────────────────────────
$tenants = discoverTenants($projectRoot);

if (empty($tenants)) {
    fwrite(STDERR, "No tenants configured. Create tenants.json or set \$TENANTS.\n");
    exit(1);
}

// ── DATA_DIR ─────────────────────────────────────────────────────────────────
$dataDir = getenv('DATA_DIR') ?: $projectRoot . '/data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

// ── Shared attack catalog (parsed once, reused for all tenants) ───────────────
$parser     = new ANTLRParserAdapter();
$attacks    = $parser->parseDirectory($projectRoot . '/models');
$attackRepo = new FilesystemAttackRepository($attacks);
$calendar   = new GermanHolidayCalendar();

// ── Scheduling window: next full work week ─────────────────────────────────
$start = new DateTimeImmutable('next monday 09:00');
$end   = $start->modify('+4 days')->setTime(17, 0);

$totalTenants = count($tenants);
$wallStart    = microtime(true);

printf(
    "ELEMENT.İO — run-all-tenants  [%s]\n",
    (new DateTimeImmutable())->format('Y-m-d H:i:s')
);
printf("Window: %s → %s\n", $start->format('Y-m-d H:i'), $end->format('Y-m-d H:i'));
printf("Tenants: %d  |  Catalog attacks: %d\n\n", $totalTenants, count($attacks));
echo str_repeat('─', 72) . "\n";

// ── Per-tenant loop ───────────────────────────────────────────────────────────
foreach ($tenants as $slug) {
    $tenantStart = microtime(true);

    try {
        $factory   = ConnectionFactory::forTenant($slug, $dataDir);
        $userRepo  = new UserRepository($factory);
        $itemRepo  = new ProcessableItemRepository($factory);
        $service   = new ProcessableItemsService($itemRepo, $calendar);
        $generator = new SecurityTaskGenerator($attackRepo, $service);

        // Seed demo users if table is empty
        $users = $userRepo->findAll();
        if (empty($users)) {
            foreach (['Alice', 'Bob', 'Charlie'] as $name) {
                $userRepo->save(new User(0, $name));
            }
            $users = $userRepo->findAll();
        }

        // Run EVEN strategy as the canonical nightly batch
        $items = $generator->generateAndSchedule(
            users:              $users,
            tasksPerUser:       5,
            start:              $start,
            end:                $end,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::EVEN,
        );

        $elapsed = round((microtime(true) - $tenantStart) * 1000);

        printf(
            "[%-20s]  Scheduled %3d tasks for %d users (%d per user)  [%dms]\n",
            $slug,
            count($items),
            count($users),
            count($users) > 0 ? intdiv(count($items), count($users)) : 0,
            $elapsed,
        );
    } catch (\InvalidArgumentException $e) {
        printf("[%-20s]  SKIPPED — invalid slug: %s\n", $slug, $e->getMessage());
    } catch (\Throwable $e) {
        fprintf(STDERR, "[%-20s]  ERROR — %s\n", $slug, $e->getMessage());
    }
}

echo str_repeat('─', 72) . "\n";
printf(
    "Done. %d tenant(s) updated in %.2f s.\n",
    $totalTenants,
    microtime(true) - $wallStart,
);

// ─────────────────────────────────────────────────────────────────────────────

/**
 * Discover tenant slugs from the environment or a JSON file.
 *
 * @return string[]
 */
function discoverTenants(string $projectRoot): array
{
    // 1. Explicit JSON file path in environment
    $tenantsFile = getenv('TENANTS_FILE');
    if ($tenantsFile && is_readable($tenantsFile)) {
        $decoded = json_decode(file_get_contents($tenantsFile), true);
        if (is_array($decoded)) {
            return array_filter(array_map('trim', $decoded));
        }
    }

    // 2. Comma-separated list in $TENANTS env var
    $tenantsEnv = getenv('TENANTS');
    if ($tenantsEnv) {
        return array_filter(array_map('trim', explode(',', $tenantsEnv)));
    }

    // 3. Default tenants.json in project root
    $defaultFile = $projectRoot . '/tenants.json';
    if (is_readable($defaultFile)) {
        $decoded = json_decode(file_get_contents($defaultFile), true);
        if (is_array($decoded)) {
            return array_filter(array_map('trim', $decoded));
        }
    }

    return [];
}
