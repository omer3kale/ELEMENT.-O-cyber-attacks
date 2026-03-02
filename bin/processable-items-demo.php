#!/usr/bin/env php
<?php

declare(strict_types=1);

use ElementO\ProcessableItems\Application\ProcessableItemsService;
use ElementO\ProcessableItems\Domain\DistributionStrategy;
use ElementO\ProcessableItems\Domain\User;
use ElementO\ProcessableItems\Infrastructure\Database\ConnectionFactory;
use ElementO\ProcessableItems\Infrastructure\Database\ProcessableItemRepository;
use ElementO\ProcessableItems\Infrastructure\Database\UserRepository;
use ElementO\ProcessableItems\Infrastructure\Time\GermanHolidayCalendar;

$projectRoot = dirname(__DIR__);
require $projectRoot . '/vendor/autoload.php';

// Parse CLI options 
$opts   = getopt('', ['tenant:']);
$tenant = $opts['tenant'] ?? null;

// Bootstrap
$factory = $tenant !== null
    ? ConnectionFactory::forTenant($tenant, $projectRoot . '/data')
    : ConnectionFactory::forFile($projectRoot);
$userRepo   = new UserRepository($factory);
$itemRepo   = new ProcessableItemRepository($factory);
$calendar   = new GermanHolidayCalendar();
$service    = new ProcessableItemsService($itemRepo, $calendar);

if ($tenant !== null) {
    echo "Tenant: {$tenant}\n";
}

// Seed demo users if table is empty
$users = $userRepo->findAll();
if (empty($users)) {
    foreach (['Alice', 'Bobby', 'Delta'] as $name) {
        $userRepo->save(new User(0, $name));
    }
    $users = $userRepo->findAll();
}

// Date range
$start = new DateTimeImmutable('next monday 09:00');
$end   = $start->modify('+4 days')->setTime(17, 0);

echo sprintf(
    "Scheduling from %s to %s for %d users\n\n",
    $start->format('Y-m-d H:i'),
    $end->format('Y-m-d H:i'),
    count($users),
);

$strategies = DistributionStrategy::cases();

foreach ($strategies as $strategy) {
    echo str_repeat('-', 72) . "\n";
    echo sprintf("Strategy: %s\n", $strategy->value);
    echo str_repeat('-', 72) . "\n";
    printf("%-12s  %-19s  %s\n", 'User', 'Scheduled At', 'Item Name');
    echo str_repeat('-', 72) . "\n";

    $items = $service->scheduleItems(
        users:              $users,
        amountPerUser:      5,
        start:              $start,
        end:                $end,
        minDistanceMinutes: 15,   
        strategy:           $strategy,
    );

    foreach ($items as $item) {
        $userName = '';
        foreach ($users as $u) {
            if ($u->id() === $item->userId()) {
                $userName = $u->name();
                break;
            }
        }
        printf(
            "%-12s  %-19s  %s\n",
            $userName,
            $item->scheduledAt()->format('Y-m-d H:i'),
            $item->name(),
        );
    }

    echo "\n";
}

echo "Done. Items written to data/" . ($tenant ?? 'processable_items') . ".sqlite\n";
