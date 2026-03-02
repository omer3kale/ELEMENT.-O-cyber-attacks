#!/usr/bin/env php
<?php

declare(strict_types=1);

use ElementO\Infrastructure\Parser\ANTLRParserAdapter;
use ElementO\Infrastructure\Repository\FilesystemAttackRepository;

$projectRoot = dirname(__DIR__);

require $projectRoot . '/vendor/autoload.php';

try {
    $modelsDir = $projectRoot . '/models';

    $adapter    = new ANTLRParserAdapter();
    $attacks    = $adapter->parseDirectory($modelsDir);
    $repository = new FilesystemAttackRepository($attacks);

    $total = $repository->count();
    $all   = $repository->findAll();

    echo 'ELEMENTO Attack DSL - Parse Summary' . PHP_EOL;
    echo '====================================' . PHP_EOL;
    echo PHP_EOL;
    echo 'Parsed directory : ' . $modelsDir . PHP_EOL;
    echo 'Total attacks    : ' . $total . PHP_EOL;
    echo PHP_EOL;

    foreach ($all as $i => $attack) {
        $number    = $i + 1;
        $impact    = $attack->impactType !== null ? $attack->impactType->value : 'Unknown';
        $platforms = count($attack->platforms) > 0 ? implode(', ', $attack->platforms) : 'None listed';

        echo $number . ') ' . $attack->name . PHP_EOL;
        echo '   MITRE      : ' . $attack->mitreId->value . PHP_EOL;
        echo '   Category   : ' . $attack->category->value . PHP_EOL;
        echo '   Difficulty : ' . $attack->difficulty->value . PHP_EOL;
        echo '   Risk score : ' . $attack->riskScore() . '/100' . PHP_EOL;
        echo '   Impact     : ' . $impact . PHP_EOL;
        echo '   Platforms  : ' . $platforms . PHP_EOL;
        echo PHP_EOL;
    }

    exit(0);

} catch (Throwable $e) {
    echo 'ERROR: Parse pipeline failed' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}
