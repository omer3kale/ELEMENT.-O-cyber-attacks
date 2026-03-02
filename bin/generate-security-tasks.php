#!/usr/bin/env php
<?php

declare(strict_types=1);

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

// Parse CLI options
$opts   = getopt('', ['tenant:']);
$tenant = $opts['tenant'] ?? null;

// Bootstrap attack catalog 
$parser    = new ANTLRParserAdapter();
$attacks   = $parser->parseDirectory($projectRoot . '/models');
$attackRepo = new FilesystemAttackRepository($attacks);

// Bootstrap processable-items infrastructure
$factory  = $tenant !== null
    ? ConnectionFactory::forTenant($tenant, $projectRoot . '/data')
    : ConnectionFactory::forFile($projectRoot);
$userRepo = new UserRepository($factory);
$itemRepo = new ProcessableItemRepository($factory);
$calendar = new GermanHolidayCalendar();
$service  = new ProcessableItemsService($itemRepo, $calendar);

if ($tenant !== null) {
    echo "Tenant: {$tenant}\n";
}

// Seed demo users if table is empty
$users = $userRepo->findAll();
if (empty($users)) {
    foreach (['Alice', 'Bob', 'Charlie'] as $name) {
        $userRepo->save(new User(0, $name));
    }
    $users = $userRepo->findAll();
}

// Generator 
$generator = new SecurityTaskGenerator($attackRepo, $service);

// Date range: next full work week 
$start = new DateTimeImmutable('next monday 09:00');
$end   = $start->modify('+4 days')->setTime(17, 0);

echo sprintf(
    "Generating security tasks from %d catalog attacks\n",
    count($attacks),
);
echo sprintf(
    "Scheduling range: %s to %s  |  %d users\n\n",
    $start->format('Y-m-d H:i'),
    $end->format('Y-m-d H:i'),
    count($users),
);

// Run all three strategies
foreach (DistributionStrategy::cases() as $strategy) {
    echo str_repeat('=', 80) . "\n";
    echo sprintf("Strategy: %s\n", $strategy->value);
    echo str_repeat('=', 80) . "\n";
    printf("%-12s  %-19s  %s\n", 'User', 'Scheduled At', 'Task');
    echo str_repeat('-', 80) . "\n";

    $items = $generator->generateAndSchedule(
        users:              $users,
        tasksPerUser:       5,
        start:              $start,
        end:                $end,
        minDistanceMinutes: 20,   
        strategy:           $strategy,
    );

    // Build user-id
    $userNames = [];
    foreach ($users as $u) {
        $userNames[$u->id()] = $u->name();
    }

    foreach ($items as $item) {
        printf(
            "%-12s  %-19s  %s\n",
            $userNames[$item->userId()] ?? "User {$item->userId()}",
            $item->scheduledAt()->format('Y-m-d H:i'),
            $item->name(),
        );
    }

    echo "\n";
    printf(
        "  Totals: %d items across %d users (%d per user)\n\n",
        count($items),
        count($users),
        count($users) > 0 ? intdiv(count($items), count($users)) : 0,
    );
}

echo "Done. Items written to data/" . ($tenant ?? 'processable_items') . ".sqlite\n";
