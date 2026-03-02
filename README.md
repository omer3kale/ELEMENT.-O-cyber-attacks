# ELEMENT.-O / Cyber Attack Catalogue

A structured catalogue of 30 real-world cyber attack patterns, defined in a custom ANTLR 4 DSL, backed by a PHP 8.2 domain layer, and rendered as a static dark-theme HTML page.

## Local usage

```bash
composer install
php bin/check-workspace.php
php -S localhost:8000 -t dist
```

GitHub Actions CI runs `php bin/check-workspace.php` on every push to ensure the catalog and static site build are consistent and safe.

## Project structure

```
grammar/          AttackDSL ANTLR 4 grammar
models/           30 .attack DSL files
src/
  Domain/         Aggregates, value objects, enums
  Infrastructure/ ANTLR parser adapter, filesystem repository
  Presentation/   Static HTML renderer
bin/
  parse-attacks.php       Validate all models
  build-static-site.php   Generate dist/index.html
  check-workspace.php     Quality gate (build + semantic + hygiene)
dist/             Generated static site
```

## Tech

- PHP 8.2
- ANTLR 4.13.1
- Composer / PSR-4
- MITRE ATT&CK aligned
