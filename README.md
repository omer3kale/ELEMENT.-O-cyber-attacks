### Goal ### 

***How to approach ambiguous requirements***

Spec for "amountPerUse" seems open to interpretation I chose the per-user reading, each user gets the same number of scheduled items, so total output = "count($users) × amountPerUser" and documented that decision directly in the method docblock so it is visible. Rather than throwing an exception when a constraint cannot be satisfied, the service silently returns fewer items, because a partial schedule is more useful than a hard failure for scheduling. Every other ambiguous edge, holiday coverage scope, whether a 16:45 slot "fits" inside office hours, is resolved with one conservative rule and annotated inline at the point of enforcement.

***How to structure code and responsibilities***

The module is split into three layers following DDD bounded contexts: "Domain" holds "ProcessableItem", "User", and "DistributionStrategy" with zero infrastructure imports; "Application" contains "ProcessableItemsService" as the single entry point for all scheduling logic; "Infrastructure" owns SQLite persistence ("ConnectionFactory", "ProcessableItemRepository") and the "GermanHolidayCalendar". No infrastructure detail leaks into the domain, the calendar is injected via the constructor, so the service never touches a file path or database driver directly.

***How to reason about time-based logic and constraints***

Slot generation is a pure pipeline: first collect every valid candidate slot into an array, then hand that pool to the chosen distribution strategy for selection. "DateTimeImmutable" is used throughout, so no date mutation can silently shift a scheduled time mid-loop. The 30-minute floor is enforced with a single call at service entry, making it structurally impossible for any strategy to bypass the rule.
*"minDistanceMinutes" = "max($minDistanceMinutes, self::MIN_DISTANCE_FLOOR)"*

***How to communicate assumptions and trade-offs***

Every decision appears in three places: a "Design decisions and assumptions" block inside the service docblock, the distribution strategy comparison table in this README, and the git commit messages that reference which requirement drove each change. The strategy table quantifies predictability, late-day bias, and surprise factor so a future maintainer can pick the right strategy without reading implementation code. Edge cases, holiday-dense weeks, windows shorter than "minDistanceMinutes", "amountPerUser = 0" are each covered by a named test and referenced in a comment next to the enforcement logic.


### Technical Setup ###

***Stack***
PHP 8.2 · SQLite · ANTLR 4.13.1 · PHPUnit · Composer PSR-4.

SQLite was chosen over MySQL because it needs no server, works without Docker, and swapping it for any other SQL provider only requires a new "ConnectionFactory" implementation, the service layer never sees a driver. ANTLR was brought in to parse the custom ".attack" DSL into typed domain objects; it is the only third-party dependency and it keeps the threat library extensible without touching PHP.

### Domain Concept ###

I treat every bounded context as its own world with its own language. The attack catalog world speaks in ".attack" DSL files, parsed by an ANTLR 4 grammar into typed "AttackAggregate" objects, adding a new threat pattern means dropping a file in "models/", no PHP changes required. The scheduler world speaks in "ProcessableItem", "User", and "DistributionStrategy" — it knows nothing about attacks, only about slots and constraints. The two worlds meet at one seam — "SecurityTaskGenerator" — which translates attack names into task names and hands them to "ProcessableItemsService", so neither world bleeds into the other.


### What We Are Interested In ###

***How you structure the service and its responsibilities***

"ProcessableItemsService" owns exactly one responsibility, generating a schedule, and delegates calendar rules to "GermanHolidayCalendar" and persistence to "ProcessableItemRepository", both injected via constructor so either can be swapped or mocked without touching business logic.

***How you handle ambiguous requirements***

"amountPerUser" is interpreted as a desired maximum per individual user, not a global pool; if the window cannot fit that many, the service returns fewer items rather than throwing an exception. The interpretation and the fallback behaviour are both stated in the method docblock at the call site so whoever uses the service never has to guess.

**How you explain decisions and assumptions**

Each design choice is captured in the method docblocks on `ProcessableItemsService` and in the distribution strategy trade-off table below, so future maintainers know why each rule exists without reading implementation code. PHPUnit test names are written as plain-English statements — `testMinDistanceFloorIsEnforced`, `testWeightedStrategyProducesLaterAverageSlot` — so the test suite doubles as living documentation of the business rules.

**How you would extend or refactor the solution in the future**

Swapping SQLite for PostgreSQL only requires a new `ConnectionFactory` — the service depends on `ProcessableItemRepository`, not a driver, so zero business logic changes. Concrete next steps already scoped: blackout windows per user, iCal/Google Calendar import for busy blocks, team-level quotas, a PSR-7 REST layer, and webhook notifications when a scheduled item's time is reached.

---

## Distribution strategies

| Strategy | Algorithm | Predictability | Best for |
|---|---|---|---|
| `EVEN` | Evenly-spaced indices — no randomness | High — fully deterministic | Compliance schedules, auditable workflows |
| `RANDOM_SPACED` | Shuffles pool, greedily picks slots ≥ minDistance apart | Low — varies per run | Phishing simulations, anything where predictability lets users anticipate |
| `WEIGHTED` | Weighted pool (09–13 ×1, 13–15 ×2, 15–17 ×3), shuffled, greedy pick | Medium — biased but not deterministic | Awareness reminders that should not compete with morning work |

\`\`\`
Predictability : EVEN  > WEIGHTED > RANDOM_SPACED
Late-day bias  : WEIGHTED > RANDOM_SPACED ≈ EVEN
Surprise factor: RANDOM_SPACED > WEIGHTED > EVEN
\`\`\`

---

## Language support

The catalog and documentation share a single i18n layer (`src/Presentation/I18n.php`) with 100% EN/TR/DE coverage for all UI keys; this implementation is treated as stable and is only changed when adding new keys or fixing bugs.

- **51 keys** span catalog UI, navigation, page titles, CTA buttons, and section headings.
- The toggle persists the user's choice to `localStorage`; it is rendered client-side in pure JS with no build step.
- `I18n::assertComplete()` is called at renderer entry and in CI — any missing translation is a hard failure, not a silent fallback.
- `I18nTest` and `AttackListRendererI18nTest` enforce 100% key × language matrix coverage.

---

## Optional

**Tests:** 46 tests, 369 assertions — zero warnings, zero skipped.

\`\`\`bash
./vendor/bin/phpunit
# OK (46 tests, 369 assertions)
\`\`\`

**Commit history** — 9 clean, single-concern commits:

\`\`\`
b2f933c  P20+P21: GitHub Pages docs site, run-all-tenants, two deployment paths
676651b  Add multi-tenant ConnectionFactory, BrandAwareTaskTemplates, tenant/brand tests
796406a  Fix CI: seed MT RNG in weighted test; add estimateCapacity, category tags, strategy docblocks
30f3dbf  Add Module 3: SecurityTaskGenerator bridges attack catalog with scheduler
b0e7d90  Add ProcessableItems module: service, SQLite, holiday calendar, PHPUnit tests
afb3453  Rebrand to ELEMENT.İO, remove meta tagline, add PWA
138bb05  Fix PSR-4 namespace in composer.json
bd6d424  Add ANTLR generated parser files so CI can run without Java
886ca54  Add full attack catalog, renderer, workspace checks, modal popups, Pages deployment
\`\`\`

**Design decisions captured in code:**
- `amountPerUser` interpretation documented in `scheduleItems()` docblock
- 30-min floor enforced at entry, not inside each strategy — one place to change
- `DateTimeImmutable` throughout — no mutation bugs possible in long date windows
- Holiday coverage: federal holidays only; state-specific holidays are out of scope and noted inline

**Edge cases explicitly handled:**
- Holiday-dense weeks (Christmas Eve → New Year) may return zero items — no exception, documented
- Window shorter than `minDistanceMinutes` → zero items, no exception
- `amountPerUser = 0` → empty array, no slot generation triggered
- Per-user scheduling is independent — one user hitting zero slots does not affect others
