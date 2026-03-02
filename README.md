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
  ProcessableItems/
    Domain/       User, ProcessableItem, DistributionStrategy
    Application/  ProcessableItemsService
    Infrastructure/
      Database/   ConnectionFactory, UserRepository, ProcessableItemRepository
      Time/       GermanHolidayCalendar
bin/
  parse-attacks.php              Validate all models
  build-static-site.php          Generate dist/index.html
  check-workspace.php            Quality gate (build + semantic + hygiene)
  processable-items-demo.php     ProcessableItems scheduling demo
tests/
  ProcessableItems/              PHPUnit test suite
dist/             Generated static site
data/             SQLite database (git-ignored)
```

## Processable Items Challenge

A self-contained scheduling module that lives alongside the attack catalogue.

### Design decisions and assumptions

- **Amount interpretation** — `amountPerUser` means items per individual user, not a global pool. Total generated items = `count($users) * $amountPerUser`.
- **Min-distance floor** — Any `minDistanceMinutes` value below 30 is silently raised to 30. This prevents item flooding while keeping the API lenient.
- **Valid slots** — Generated in 30-minute steps from 09:00 to 16:30 (slots that finish by 17:00), Monday–Friday only, skipping German federal holidays.
- **Holiday coverage** — Federal holidays only (New Year, Good Friday, Easter Monday, Ascension, Whit Monday, Labour Day, German Unity Day, Christmas × 2). State-specific holidays are out of scope.
- **Partial scheduling** — If constraints cause fewer available slots than requested, the service returns fewer items without throwing. This is documented in the method docblock.
- **No processing** — The service only creates `status = pending` items; no item is ever processed by this module.

### Distribution strategies

| Strategy | Behaviour |
|---|---|
| `EVEN` | Picks slots at evenly-spaced indices across the full valid window |
| `RANDOM_SPACED` | Shuffles all valid slots then greedily picks those >= minDistance apart |
| `WEIGHTED` | Slots 15:00–17:00 get 3x weight, 13:00–15:00 get 2x, earlier get 1x; respects minDistance |

### Run the demo

```bash
composer install
php bin/processable-items-demo.php
```

### Run tests

```bash
./vendor/bin/phpunit --testsuite ProcessableItems
```

## Module 3: Security Task Generator

Bridges the attack catalog and the scheduler: reads every `AttackAggregate`, derives concrete security task names from it, and feeds them into `ProcessableItemsService` as scheduled work items.

### How it works

1. `SecurityTaskGenerator` loads all attacks from the catalog.
2. For each attack it maps category + name to human-readable task names (e.g. `ApiBolaIdorDataExposure` → `"Review API for BOLA/IDOR exposures"`; `SqlInjectionEcommerce` → `"Run SQL injection tests against critical endpoints"`).
3. Task templates are assigned to users in round-robin so each user gets a varied spread across the threat library.
4. `ProcessableItemsService` handles all time constraints - office hours, German holidays, per-user min spacing.

### Story

> We turn our ATT&CK-style threat library into scheduled, time-bound security work items for real users, respecting office hours, German holidays, and per-user pacing via the Processable Items service.

### Run the generator

```bash
php bin/generate-security-tasks.php
```

### Run SecurityTasks tests

```bash
./vendor/bin/phpunit --testsuite SecurityTasks
```

### Run all tests

```bash
./vendor/bin/phpunit --testsuite All
```

## Tech

- PHP 8.2
- ANTLR 4.13.1
- Composer / PSR-4
- MITRE ATT&CK aligned
- SQLite (in-process, zero-config)
