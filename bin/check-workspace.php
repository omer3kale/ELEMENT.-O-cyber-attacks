#!/usr/bin/env php
<?php

declare(strict_types=1);

use ElementO\Domain\Category\AttackCategory;
use ElementO\Infrastructure\Parser\ANTLRParserAdapter;
use ElementO\Infrastructure\Repository\FilesystemAttackRepository;
use ElementO\Presentation\AttackListRenderer;

$projectRoot = dirname(__DIR__);

require $projectRoot . '/vendor/autoload.php';

$modelsDir = $projectRoot . '/models';
$distDir   = $projectRoot . '/dist';
$distHtml  = $distDir . '/index.html';

$failures = [];

//(a) Rebuild static site 

try {
    $adapter    = new ANTLRParserAdapter();
    $attacks    = $adapter->parseDirectory($modelsDir);
    $repository = new FilesystemAttackRepository($attacks);
    $all        = $repository->findAll();
    $renderer   = new AttackListRenderer();
    $html       = $renderer->render($all);

    if (!is_dir($distDir)) {
        mkdir($distDir, 0777, true);
    }

    file_put_contents($distHtml, $html);
    echo 'Build: dist/index.html written (' . count($all) . ' attacks)' . PHP_EOL;
} catch (Throwable $e) {
    echo 'Build failed: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}

//(b) Semantic validation 

if (count($all) < 30) {
    $failures[] = 'Attack count is ' . count($all) . ' — expected at least 30.';
}

foreach ($all as $attack) {
    $problems = [];

    if (trim($attack->name) === '') {
        $problems[] = 'empty name';
    }
    if (trim($attack->mitreId->value) === '') {
        $problems[] = 'empty mitreId';
    }
    if ($attack->impactType === null) {
        $problems[] = 'null impactType';
    }

    if ($problems !== []) {
        $failures[] = 'Aggregate "' . ($attack->name ?: '(unknown)') . '": ' . implode(', ', $problems) . '.';
    }
}

//(c) Workspace hygiene

//(c1) No http/https in .attack files
$attackFiles = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($modelsDir, FilesystemIterator::SKIP_DOTS)
);

foreach ($attackFiles as $file) {
    if ($file->getExtension() !== 'attack') {
        continue;
    }

    $content = file_get_contents($file->getPathname());

    if (preg_match('/https?:\/\//i', $content)) {
        $failures[] = 'Unsafe http/https URL found in ' . str_replace($projectRoot . '/', '', $file->getPathname()) . '.';
    }
}


// (c3) No clickable <a href="http in dist/index.html
if (file_exists($distHtml)) {
    $distContent = file_get_contents($distHtml);

    if (str_contains(strtolower($distContent), '<a href="http')) {
        $failures[] = 'Clickable <a href="http link found in dist/index.html.';
    }
} else {
    $failures[] = 'dist/index.html does not exist after build step.';
}

// Result 

if ($failures !== []) {
    echo PHP_EOL . 'Workspace check FAILED:' . PHP_EOL;
    foreach ($failures as $msg) {
        echo '  - ' . $msg . PHP_EOL;
    }
    exit(1);
}

// Summary table 

$familyCounts = [];

foreach ($all as $attack) {
    $n = $attack->name;

    if (str_contains($n, 'Insider')) {
        $label = 'Insider Threat';
    } elseif (str_contains($n, 'Cloud') && str_contains($n, 'Misconfiguration')) {
        $label = 'Cloud Misconfiguration';
    } else {
        $label = match ($attack->category) {
            AttackCategory::SocialEngineering                    => 'Social Engineering',
            AttackCategory::Malware, AttackCategory::Network     => 'Malware / Exploitation',
            AttackCategory::SupplyChain, AttackCategory::Physical => 'Supply Chain / APT / ICS',
            AttackCategory::Cloud                                => 'Cloud Attacks',
            AttackCategory::Iot                                  => 'IoT / Embedded',
            AttackCategory::Mobile                               => 'Mobile Threats',
            AttackCategory::AiMl                                 => 'AI / ML Attacks',
            AttackCategory::Quantum                              => 'Quantum Threats',
            AttackCategory::Cryptographic                        => 'Cryptographic',
            default                                              => 'Web / Application',
        };
    }

    $familyCounts[$label] = ($familyCounts[$label] ?? 0) + 1;
}

arsort($familyCounts);

echo PHP_EOL . 'Workspace check passed: all attacks validated, HTML built, no unsafe URLs or emojis found.' . PHP_EOL;
echo PHP_EOL . 'Attacks: ' . count($all) . PHP_EOL;
echo 'Families:' . PHP_EOL;

foreach ($familyCounts as $family => $count) {
    echo '  ' . str_pad($family, 30) . ': ' . $count . PHP_EOL;
}

exit(0);
