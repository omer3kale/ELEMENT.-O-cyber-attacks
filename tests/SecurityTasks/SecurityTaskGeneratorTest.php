<?php

declare(strict_types=1);

namespace ElementO\Tests\SecurityTasks;

use DateTimeImmutable;
use ElementO\Domain\Attack\AttackAggregate;
use ElementO\Domain\Attack\MitreId;
use ElementO\Domain\Attack\SuccessRate;
use ElementO\Domain\Category\AttackCategory;
use ElementO\Domain\Category\DetectionDifficulty;
use ElementO\Domain\Category\DifficultyLevel;
use ElementO\Infrastructure\Repository\FilesystemAttackRepository;
use ElementO\ProcessableItems\Application\ProcessableItemsService;
use ElementO\ProcessableItems\Domain\DistributionStrategy;
use ElementO\ProcessableItems\Domain\User;
use ElementO\ProcessableItems\Infrastructure\Database\ConnectionFactory;
use ElementO\ProcessableItems\Infrastructure\Database\ProcessableItemRepository;
use ElementO\ProcessableItems\Infrastructure\Time\GermanHolidayCalendar;
use ElementO\SecurityTasks\Application\SecurityTaskGenerator;
use PHPUnit\Framework\TestCase;

/**
 * Tests for SecurityTaskGenerator.
 *
 * Uses an in-memory SQLite connection (no VPS required) and a real
 * GermanHolidayCalendar so CI can run these without any external services.
 */
final class SecurityTaskGeneratorTest extends TestCase
{
    private SecurityTaskGenerator $generator;

    /** @var User[] */
    private array $users;

    /** A full work week with no holidays in March 2026. */
    private DateTimeImmutable $weekStart;
    private DateTimeImmutable $weekEnd;

    protected function setUp(): void
    {
        $factory   = new ConnectionFactory('sqlite::memory:');
        $itemRepo  = new ProcessableItemRepository($factory);
        $calendar  = new GermanHolidayCalendar();
        $service   = new ProcessableItemsService($itemRepo, $calendar);

        // Generator needs an AttackRepository — use the in-memory impl.
        $attackRepo = new FilesystemAttackRepository([]);
        $this->generator = new SecurityTaskGenerator($attackRepo, $service);

        $this->users     = [new User(1, 'Alice'), new User(2, 'Bob')];
        $this->weekStart = new DateTimeImmutable('2026-03-09 09:00');
        $this->weekEnd   = new DateTimeImmutable('2026-03-13 17:00');
    }

    // -----------------------------------------------------------------------
    // 1. taskNamesForAttack – social engineering
    // -----------------------------------------------------------------------

    public function testSocialEngineeringAttackProducesPhishingTasks(): void
    {
        $attack = $this->makeAttack('SpearPhishingExecutive', AttackCategory::SocialEngineering);

        $names = $this->generator->taskNamesForAttack($attack);

        $this->assertNotEmpty($names);
        $this->assertStringContainsString('phishing', strtolower($names[0]));
    }

    // -----------------------------------------------------------------------
    // 2. taskNamesForAttack – API BOLA/IDOR
    // -----------------------------------------------------------------------

    public function testApiBolaAttackProducesAuthorizationTasks(): void
    {
        $attack = $this->makeAttack('ApiBolaIdorDataExposure', AttackCategory::Application);

        $names = $this->generator->taskNamesForAttack($attack);

        $this->assertNotEmpty($names);
        $found = false;
        foreach ($names as $name) {
            if (str_contains(strtolower($name), 'bola') || str_contains(strtolower($name), 'idor')) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, 'Expected at least one task mentioning BOLA/IDOR.');
    }

    // -----------------------------------------------------------------------
    // 3. taskNamesForAttack – SQL injection
    // -----------------------------------------------------------------------

    public function testSqlInjectionAttackProducesTestTasks(): void
    {
        $attack = $this->makeAttack('SqlInjectionEcommerce', AttackCategory::Application);

        $names = $this->generator->taskNamesForAttack($attack);

        $this->assertNotEmpty($names);
        $this->assertStringContainsStringIgnoringCase('sql injection', $names[0]);
    }

    // -----------------------------------------------------------------------
    // 4. taskNamesForAttack – cloud misconfiguration
    // -----------------------------------------------------------------------

    public function testCloudAttackProducesAuditTasks(): void
    {
        $attack = $this->makeAttack('CloudMisconfigurationDataExposure', AttackCategory::Cloud);

        $names = $this->generator->taskNamesForAttack($attack);

        $this->assertNotEmpty($names);
        $found = false;
        foreach ($names as $name) {
            if (str_contains(strtolower($name), 'cloud') || str_contains(strtolower($name), 'iam')) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, 'Expected at least one cloud audit task.');
    }

    // -----------------------------------------------------------------------
    // 5. taskNamesForAttack – ransomware
    // -----------------------------------------------------------------------

    public function testRansomwareAttackProducesBackupTasks(): void
    {
        $attack = $this->makeAttack('WannaCryRansomware', AttackCategory::Malware);

        $names = $this->generator->taskNamesForAttack($attack);

        $this->assertNotEmpty($names);
    }

    // -----------------------------------------------------------------------
    // 6. taskNamesForAttack – supply chain
    // -----------------------------------------------------------------------

    public function testSupplyChainAttackProducesDependencyTasks(): void
    {
        $attack = $this->makeAttack('SolarwindsSupplyChain', AttackCategory::SupplyChain);

        $names = $this->generator->taskNamesForAttack($attack);

        $this->assertNotEmpty($names);
        $found = false;
        foreach ($names as $name) {
            if (str_contains(strtolower($name), 'supply chain') || str_contains(strtolower($name), 'dependency') || str_contains(strtolower($name), 'sbom')) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, 'Expected at least one supply-chain dependency task.');
    }

    // -----------------------------------------------------------------------
    // 7. taskNamesForAttack – default fallback
    // -----------------------------------------------------------------------

    public function testUnknownAttackProducesDefaultReviewTask(): void
    {
        $attack = $this->makeAttack('SomeObscureWeirdAttack', AttackCategory::Physical);

        $names = $this->generator->taskNamesForAttack($attack);

        $this->assertNotEmpty($names);
        $this->assertStringContainsStringIgnoringCase('review', $names[0]);
    }

    // -----------------------------------------------------------------------
    // 8. generateAndSchedule – returns items constrained to office hours
    // -----------------------------------------------------------------------

    public function testGenerateAndScheduleReturnsOfficeHourItems(): void
    {
        // Populate the generator with a real attack repository
        $attacks = [
            $this->makeAttack('SqlInjectionEcommerce', AttackCategory::Application),
            $this->makeAttack('SpearPhishingExecutive', AttackCategory::SocialEngineering),
            $this->makeAttack('CloudMisconfigurationDataExposure', AttackCategory::Cloud),
        ];
        $attackRepo = new FilesystemAttackRepository($attacks);
        $factory    = new ConnectionFactory('sqlite::memory:');
        $itemRepo   = new ProcessableItemRepository($factory);
        $service    = new ProcessableItemsService($itemRepo, new GermanHolidayCalendar());
        $generator  = new SecurityTaskGenerator($attackRepo, $service);

        $items = $generator->generateAndSchedule(
            users:              $this->users,
            tasksPerUser:       3,
            start:              $this->weekStart,
            end:                $this->weekEnd,
            minDistanceMinutes: 10, // floor will raise to 30
            strategy:           DistributionStrategy::EVEN,
        );

        $this->assertNotEmpty($items, 'Expected at least some scheduled items.');

        foreach ($items as $item) {
            $hour    = (int) $item->scheduledAt()->format('G');
            $weekday = (int) $item->scheduledAt()->format('N');
            $this->assertGreaterThanOrEqual(1, $weekday, 'Item on weekend.');
            $this->assertLessThanOrEqual(5,   $weekday, 'Item on weekend.');
            $this->assertGreaterThanOrEqual(9, $hour,   'Item before 09:00.');
            $this->assertLessThanOrEqual(16,   $hour,   'Item after 16:30.');
        }
    }

    // -----------------------------------------------------------------------
    // 9. generateAndSchedule – task names come from the attack catalog
    // -----------------------------------------------------------------------

    public function testGenerateAndScheduleUsesAttackDerivedTaskNames(): void
    {
        $attacks    = [$this->makeAttack('SqlInjectionEcommerce', AttackCategory::Application)];
        $attackRepo = new FilesystemAttackRepository($attacks);
        $factory    = new ConnectionFactory('sqlite::memory:');
        $itemRepo   = new ProcessableItemRepository($factory);
        $service    = new ProcessableItemsService($itemRepo, new GermanHolidayCalendar());
        $generator  = new SecurityTaskGenerator($attackRepo, $service);

        $items = $generator->generateAndSchedule(
            users:              [new User(1, 'Alice')],
            tasksPerUser:       2,
            start:              $this->weekStart,
            end:                $this->weekEnd,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::EVEN,
        );

        $this->assertNotEmpty($items);

        // At least one item name should reference SQL injection
        $found = false;
        foreach ($items as $item) {
            if (str_contains(strtolower($item->name()), 'sql')) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, 'Expected item names to reference SQL injection attack.');
    }

    // -----------------------------------------------------------------------
    // 10. generateAndSchedule – round-robin gives different starting tasks
    //     to different users when there are enough templates
    // -----------------------------------------------------------------------

    public function testRoundRobinGivesDifferentTasksToUsers(): void
    {
        // Use enough attacks to have multiple templates
        $attacks = [
            $this->makeAttack('SqlInjectionEcommerce',          AttackCategory::Application),
            $this->makeAttack('ApiBolaIdorDataExposure',        AttackCategory::Application),
            $this->makeAttack('SpearPhishingExecutive',         AttackCategory::SocialEngineering),
            $this->makeAttack('CloudMisconfigurationDataExposure', AttackCategory::Cloud),
        ];
        $attackRepo = new FilesystemAttackRepository($attacks);
        $factory    = new ConnectionFactory('sqlite::memory:');
        $itemRepo   = new ProcessableItemRepository($factory);
        $service    = new ProcessableItemsService($itemRepo, new GermanHolidayCalendar());
        $generator  = new SecurityTaskGenerator($attackRepo, $service);

        $users = [new User(1, 'Alice'), new User(2, 'Bob'), new User(3, 'Charlie')];

        $items = $generator->generateAndSchedule(
            users:              $users,
            tasksPerUser:       1,
            start:              $this->weekStart,
            end:                $this->weekEnd,
            minDistanceMinutes: 30,
            strategy:           DistributionStrategy::EVEN,
        );

        $this->assertCount(3, $items, 'Expected exactly one item per user.');

        $firstTaskNames = array_map(fn ($i) => $i->name(), $items);
        // Not all three should be identical (round-robin shifts offset)
        $this->assertGreaterThan(
            1,
            count(array_unique($firstTaskNames)),
            'Round-robin should produce different leading task for at least two users.',
        );
    }

    // -----------------------------------------------------------------------
    // 11. taskNamesForAttack – all names are prefixed with a category tag
    // -----------------------------------------------------------------------

    public function testTaskNamesArePrefixedWithCategoryTag(): void
    {
        $cases = [
            [$this->makeAttack('PhishingSim', AttackCategory::SocialEngineering), '[SOCIAL-ENG]'],
            [$this->makeAttack('ApiBolaIdorDataExposure', AttackCategory::Application),  '[APP]'],
            [$this->makeAttack('CloudMisconfigurationDataExposure', AttackCategory::Cloud), '[CLOUD]'],
            [$this->makeAttack('WannaCryRansomware', AttackCategory::Malware), '[MALWARE]'],
            [$this->makeAttack('SolarwindsSupplyChain', AttackCategory::SupplyChain), '[SUPPLY-CHAIN]'],
            [$this->makeAttack('MobileGrievous', AttackCategory::Mobile), '[MOBILE]'],
            [$this->makeAttack('IotBotnet', AttackCategory::Iot), '[IOT]'],
            [$this->makeAttack('PromptInjectionInternalLlmAgent', AttackCategory::AiMl), '[AI-ML]'],
            [$this->makeAttack('ObscureAttack', AttackCategory::Physical), '[PHYSICAL]'],
        ];

        foreach ($cases as [$attack, $expectedTag]) {
            $names = $this->generator->taskNamesForAttack($attack);
            $this->assertNotEmpty($names, "No task names for {$attack->name}");
            foreach ($names as $name) {
                $this->assertStringStartsWith(
                    $expectedTag,
                    $name,
                    "Task name for {$attack->name} should start with {$expectedTag}, got: {$name}",
                );
            }
        }
    }

    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    private function makeAttack(string $name, AttackCategory $category): AttackAggregate
    {
        return AttackAggregate::create(
            name:                $name,
            mitreId:             MitreId::fromString('T1059'),
            category:            $category,
            difficulty:          DifficultyLevel::Medium,
            attackVector:        'Test attack vector description.',
            targetProfile:       'Test target profile.',
            successRate:         SuccessRate::fromRange(40, 60),
            averageImpact:       'Medium financial impact.',
            deliveryMethod:      'Email',
            detectionDifficulty: DetectionDifficulty::Medium,
            preventionMeasures:  ['Patch systems', 'Train users'],
        );
    }
}
