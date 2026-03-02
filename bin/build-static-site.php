#!/usr/bin/env php
<?php

declare(strict_types=1);

use ElementO\Infrastructure\Parser\ANTLRParserAdapter;
use ElementO\Infrastructure\Repository\FilesystemAttackRepository;
use ElementO\Presentation\AttackListRenderer;

$projectRoot = dirname(__DIR__);

require $projectRoot . '/vendor/autoload.php';

try {
    $modelsDir = $projectRoot . '/models';
    $distDir   = $projectRoot . '/dist';

    $adapter    = new ANTLRParserAdapter();
    $attacks    = $adapter->parseDirectory($modelsDir);
    $repository = new FilesystemAttackRepository($attacks);
    $all        = $repository->findAll();

    $renderer = new AttackListRenderer();
    $html     = $renderer->render($all);

    if (!is_dir($distDir)) {
        mkdir($distDir, 0777, true);
    }

    file_put_contents($distDir . '/index.html', $html);

    echo 'Built dist/index.html — ' . count($all) . ' attacks' . PHP_EOL;
    exit(0);
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
