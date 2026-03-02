<?php

declare(strict_types=1);

namespace ElementO\Tests\SecurityTasks;

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
use ElementO\SecurityTasks\Domain\BrandAwareTaskTemplates;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class BrandAwareSecurityTaskGeneratorTest extends TestCase
{
    // BrandAwareTaskTemplates – value object tests

    public function testCreateWithValidBrandName(): void
    {
        $templates = BrandAwareTaskTemplates::create('ACME Bank');

        $this->assertSame('ACME Bank', $templates->brandName());
        $this->assertFalse($templates->hasOverrides());
    }

    public function testCreateTrimsWhitespaceFromBrandName(): void
    {
        $templates = BrandAwareTaskTemplates::create('  Globex Corp  ');

        $this->assertSame('Globex Corp', $templates->brandName());
    }

    public function testCreateWithEmptyBrandNameThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        BrandAwareTaskTemplates::create('');
    }

    public function testCreateWithWhitespaceOnlyBrandNameThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        BrandAwareTaskTemplates::create('   ');
    }

    public function testCreateWithOverridesRegistersOverride(): void
    {
        $templates = BrandAwareTaskTemplates::create('ACME Bank', [
            'BankingAndPaymentCredentialPhishing' => [
                '[ACME Bank] Run ACME wire-transfer alert drill',
            ],
        ]);

        $this->assertTrue($templates->hasOverrides());
        $this->assertNotNull($templates->overridesFor('BankingAndPaymentCredentialPhishing'));
        $this->assertNull($templates->overridesFor('AnyOtherAttack'));
    }

    public function testWithOverrideReturnsCopyNotMutation(): void
    {
        $original = BrandAwareTaskTemplates::create('ACME Bank');
        $modified = $original->withOverride('SqlInjectionEcommerce', ['[ACME] Test SQL hardening']);

        $this->assertFalse($original->hasOverrides(), 'Original should be unchanged.');
        $this->assertTrue($modified->hasOverrides(),  'Modified copy should have override.');
    }

    public function testWithBrandNameReturnsCopyNotMutation(): void
    {
        $original = BrandAwareTaskTemplates::create('ACME Bank');
        $renamed  = $original->withBrandName('Globex');

        $this->assertSame('ACME Bank', $original->brandName(), 'Original should be unchanged.');
        $this->assertSame('Globex',    $renamed->brandName(),  'Copy should have new name.');
    }

    // SecurityTaskGenerator with BrandAwareTaskTemplates

    private function makeGenerator(?BrandAwareTaskTemplates $brand = null): SecurityTaskGenerator
    {
        $factory   = new ConnectionFactory('sqlite::memory:');
        $itemRepo  = new ProcessableItemRepository($factory);
        $service   = new ProcessableItemsService($itemRepo, new GermanHolidayCalendar());
        $attackRepo = new FilesystemAttackRepository([]);
        return new SecurityTaskGenerator($attackRepo, $service, $brand);
    }

    private function makeAttack(string $name, AttackCategory $category): AttackAggregate
    {
        return AttackAggregate::create(
            name:                $name,
            mitreId:             MitreId::fromString('T1566'),
            category:            $category,
            difficulty:          DifficultyLevel::Medium,
            attackVector:        'Test vector.',
            targetProfile:       'Test profile.',
            successRate:         SuccessRate::fromRange(30, 70),
            averageImpact:       'Medium.',
            deliveryMethod:      'Email',
            detectionDifficulty: DetectionDifficulty::Medium,
            preventionMeasures:  ['Train users'],
        );
    }

    public function testWithoutBrandTemplatesTaskNameHasOnlyCategoryTag(): void
    {
        $generator = $this->makeGenerator(null);
        $attack    = $this->makeAttack('SpearPhishingExec', AttackCategory::SocialEngineering);
        $names     = $generator->taskNamesForAttack($attack);

        $this->assertNotEmpty($names);
        // Without brand: name should start with [SOCIAL-ENG] directly
        $this->assertStringStartsWith('[SOCIAL-ENG]', $names[0]);
        // No extra brand prefix chars before the tag
        $this->assertStringNotContainsString('] [', $names[0]);
    }

    public function testWithBrandTemplatesGenericNameHasBrandAndCategoryTag(): void
    {
        $brand     = BrandAwareTaskTemplates::create('ACME Bank');
        $generator = $this->makeGenerator($brand);
        $attack    = $this->makeAttack('SpearPhishingExec', AttackCategory::SocialEngineering);
        $names     = $generator->taskNamesForAttack($attack);

        $this->assertNotEmpty($names);
        // With brand + no override: format is "[ACME Bank] [SOCIAL-ENG] ..."
        $this->assertStringStartsWith('[ACME Bank] [SOCIAL-ENG]', $names[0]);
    }

    public function testBrandOverrideTakesPrecedenceOverGenericTemplate(): void
    {
        $customTask = '[ACME Bank] Validate ACME payment gateway isolation controls';
        $brand      = BrandAwareTaskTemplates::create('ACME Bank', [
            'BankingAndPaymentCredentialPhishing' => [$customTask],
        ]);
        $generator  = $this->makeGenerator($brand);
        $attack     = $this->makeAttack(
            'BankingAndPaymentCredentialPhishing',
            AttackCategory::SocialEngineering,
        );

        $names = $generator->taskNamesForAttack($attack);

        $this->assertSame([$customTask], $names, 'Override should be used verbatim.');
    }

    public function testBrandOverrideDoesNotAffectOtherAttacks(): void
    {
        $brand = BrandAwareTaskTemplates::create('ACME Bank', [
            'BankingAndPaymentCredentialPhishing' => ['[ACME] Custom override'],
        ]);
        $generator = $this->makeGenerator($brand);

        // A different attack should use the generic path with brand prefix
        $attack = $this->makeAttack('SqlInjectionEcommerce', AttackCategory::Application);
        $names  = $generator->taskNamesForAttack($attack);

        $this->assertNotEmpty($names);
        $this->assertStringStartsWith('[ACME Bank] [APP]', $names[0]);
        $this->assertStringNotContainsString('Custom override', $names[0]);
    }

    public function testMultipleOverridesCanCoexist(): void
    {
        $brand = BrandAwareTaskTemplates::create('Globex')
            ->withOverride('SqlInjectionEcommerce',          ['[Globex] SQL pen-test'])
            ->withOverride('CloudMisconfigurationDataExposure', ['[Globex] Cloud audit']);

        $generator = $this->makeGenerator($brand);

        $sqlNames   = $generator->taskNamesForAttack(
            $this->makeAttack('SqlInjectionEcommerce', AttackCategory::Application),
        );
        $cloudNames = $generator->taskNamesForAttack(
            $this->makeAttack('CloudMisconfigurationDataExposure', AttackCategory::Cloud),
        );

        $this->assertSame(['[Globex] SQL pen-test'],   $sqlNames);
        $this->assertSame(['[Globex] Cloud audit'],    $cloudNames);
    }

    public function testBrandNameIsIncludedInGenericFallbackForAllCategories(): void
    {
        $brand     = BrandAwareTaskTemplates::create('Initech');
        $generator = $this->makeGenerator($brand);

        $cases = [
            [$this->makeAttack('SomeRansomware',   AttackCategory::Malware),       '[Initech]'],
            [$this->makeAttack('SomeIotBot',        AttackCategory::Iot),           '[Initech]'],
            [$this->makeAttack('SomeMobileSpyware', AttackCategory::Mobile),        '[Initech]'],
            [$this->makeAttack('SomeSupplyChain',   AttackCategory::SupplyChain),   '[Initech]'],
            [$this->makeAttack('SomeNetworkAttack', AttackCategory::Network),       '[Initech]'],
            [$this->makeAttack('CryptoAttack',      AttackCategory::Cryptographic), '[Initech]'],
        ];

        foreach ($cases as [$attack, $expectedBrand]) {
            $names = $generator->taskNamesForAttack($attack);
            $this->assertNotEmpty($names, "No names for {$attack->name}");
            $this->assertStringStartsWith(
                $expectedBrand,
                $names[0],
                "Expected brand prefix for {$attack->name}",
            );
        }
    }
}
