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

    // PWA: manifest
    $manifest = json_encode([
        'name'             => 'ELEMENT.İO Cyber Attack Catalogue',
        'short_name'       => 'ELEMENT.İO',
        'description'      => 'Cyber attack profiles — ANTLR 4 DSL — MITRE ATT&CK aligned',
        'start_url'        => './',
        'display'          => 'standalone',
        'background_color' => '#0d1117',
        'theme_color'      => '#0d1117',
        'icons'            => [
            ['src' => 'icons/icon.svg', 'sizes' => 'any', 'type' => 'image/svg+xml', 'purpose' => 'any maskable'],
        ],
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($distDir . '/manifest.json', $manifest);

    // PWA: service worker
    $sw = <<<'JS'
const CACHE = 'element-o-v1';
const ASSETS = ['./', './index.html', './manifest.json', './icons/icon.svg'];

self.addEventListener('install', e => {
  e.waitUntil(caches.open(CACHE).then(c => c.addAll(ASSETS)));
  self.skipWaiting();
});

self.addEventListener('activate', e => {
  e.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.filter(k => k !== CACHE).map(k => caches.delete(k)))
    )
  );
  self.clients.claim();
});

self.addEventListener('fetch', e => {
  e.respondWith(
    caches.match(e.request).then(cached => cached || fetch(e.request))
  );
});
JS;
    file_put_contents($distDir . '/sw.js', $sw);

    // PWA: icon
    if (!is_dir($distDir . '/icons')) {
        mkdir($distDir . '/icons', 0777, true);
    }
    $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 192">'
          . '<rect width="192" height="192" rx="24" fill="#0d1117"/>'
          . '<text x="96" y="130" font-family="monospace" font-size="96" font-weight="bold" fill="#58a6ff" text-anchor="middle">E</text>'
          . '</svg>';
    file_put_contents($distDir . '/icons/icon.svg', $icon);

    echo 'Built dist/index.html — ' . count($all) . ' attacks' . PHP_EOL;
    exit(0);
} catch (Throwable $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
