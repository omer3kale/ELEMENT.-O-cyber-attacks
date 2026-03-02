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

| Strategy | Algorithm | Predictability | Best for |
|---|---|---|---|
| `EVEN` | Picks slots at evenly-spaced indices; no randomness | High — output is fully deterministic | Compliance schedules, SLA-driven tasks, auditable workflows where uniform distribution must be provable |
| `RANDOM_SPACED` | Shuffles all valid slots, then greedily picks those ≥ `minDistance` apart | Low — output varies per run | Red-team exercises, phishing simulations, any task where predictability would let users anticipate events |
| `WEIGHTED` | Builds a weighted pool (early 09–13 = ×1, mid 13–15 = ×2, late 15–17 = ×3), shuffles, then greedily picks respecting spacing | Medium — biased but not deterministic | Security-awareness reminders and training nudges that must not compete with high-priority morning work |

**Trade-off summary**

```
Predictability : EVEN  > WEIGHTED > RANDOM_SPACED
Late-day bias  : WEIGHTED > RANDOM_SPACED ≈ EVEN
Surprise factor: RANDOM_SPACED > WEIGHTED > EVEN
```

### Run the demo

```bash
composer install
php bin/processable-items-demo.php
# Multi-tenant: each tenant gets its own isolated SQLite file
php bin/processable-items-demo.php --tenant=acme-corp
php bin/processable-items-demo.php --tenant=globex
```

### Multi-tenancy

`ConnectionFactory::forTenant(string $tenantSlug, string $baseDir = 'data')` creates a dedicated SQLite database per tenant (`data/{slug}.sqlite`).

- **Full schema isolation** — each tenant's rows live in a separate database file; no row-level filtering is needed.
- **Slug validation** — slugs must be 1–64 lowercase alphanumeric + hyphen characters; path-traversal attempts throw `InvalidArgumentException`.
- **Zero-config** — the data directory and schema are created automatically on first use.
- **Backward-compatible** — the default `ConnectionFactory::forFile()` path is unchanged for single-tenant usage.

### Run tests

```bash
./vendor/bin/phpunit --testsuite ProcessableItems
```

## Module 3: Security Task Generator

Bridges the attack catalog and the scheduler: reads every `AttackAggregate`, derives concrete security task names from it, and feeds them into `ProcessableItemsService` as scheduled work items.

### How it works

1. `SecurityTaskGenerator` loads all attacks from the catalog.
2. For each attack it maps category + name to human-readable task names (e.g. `ApiBolaIdorDataExposure` → `"[APP] Review API for BOLA/IDOR exposures"`;  `SqlInjectionEcommerce` → `"[APP] Run SQL injection tests against critical endpoints"`).
3. Every task name is prefixed with a **category tag** (e.g. `[SOCIAL-ENG]`, `[MALWARE]`, `[CLOUD]`, `[SUPPLY-CHAIN]`, `[AI-ML]`) so operators can filter or triage by threat domain at a glance.
4. Task templates are assigned to users in round-robin so each user gets a varied spread across the threat library.
5. `ProcessableItemsService` handles all time constraints — office hours, German holidays, per-user min spacing.

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

### Brand-aware task templates

Inject a `BrandAwareTaskTemplates` value object into `SecurityTaskGenerator` to
customise task names per customer, brand, or environment.

```php
use ElementO\SecurityTasks\Domain\BrandAwareTaskTemplates;

$templates = BrandAwareTaskTemplates::create(
    brandName: 'ACME Bank',
    overrides: [
        'BankingAndPaymentCredentialPhishing' => [
            '[ACME Bank] Run ACME wire-transfer alert drill',
            '[ACME Bank] Update fraud-detection rules for credential phishing',
        ],
    ],
);

$generator = new SecurityTaskGenerator($attackRepo, $service, $templates);
```

Behaviour:
- **Explicit override** — if an attack name has an entry in `$overrides`, those strings are used verbatim.
- **Brand prefix fallback** — every other task name is automatically prefixed `[{BrandName}] [CATEGORY-TAG] …`, e.g. `[ACME Bank] [SOCIAL-ENG] Run phishing simulation for …`.
- **Immutable design** — use `->withOverride()` and `->withBrandName()` to derive modified copies without mutating the original.

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

## Future extensions

The following capabilities are not yet implemented but are explicitly in scope for future milestones:

- **Blackout windows per user** — allow each user to declare date/time ranges when they must not receive items (e.g. PTO, conference weeks).
- **Per-user calendar import** — import iCal / Google Calendar busy blocks to derive blackout windows automatically.
- **Team-level quotas** — cap the total number of concurrent pending items across a team to avoid overloading a small group.
- **Multi-tenant `ConnectionFactory`** — one SQLite (or Postgres/MySQL) database file per tenant, selectable via CLI `--tenant` flag, with full schema isolation.
- **MySQL / PostgreSQL adapter** — replace the SQLite `ConnectionFactory` with a PDO-based adapter for production relational databases.
- **REST API layer** — a thin PSR-7 HTTP layer over `ProcessableItemsService` and `SecurityTaskGenerator` for webhook-driven or SaaS deployments.
- **Webhook notifications** — push a notification (Slack, Teams, email) when an item's scheduled time is reached or when a batch is completed.
- **Brand-aware task templates** — inject a `BrandAwareTaskTemplates` value object so task names reference the customer's actual product names, domain, or threat profile rather than generic labels.
- **`estimateCapacity()` API endpoint** — expose the capacity calculation as a lightweight dry-run endpoint so schedulers can check feasibility before committing a schedule.
