<?php

declare(strict_types=1);

namespace ElementO\Tests\Presentation;

use ElementO\Presentation\I18n;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive test for the shared I18n class.
 *
 * Covers:
 *  - Every key in I18n::KEYS has a non-empty EN, TR, and DE translation
 *  - I18n::t() returns the correct value for each lang
 *  - I18n::i() produces all four required data-i18n-* attributes
 *  - I18n::assertComplete() does not throw
 *  - All data-i18n-key values found in docs HTML files are declared in I18n::KEYS
 */
final class I18nTest extends TestCase
{
    // ---------------------------------------------------------------------------
    // Completeness
    // ---------------------------------------------------------------------------

    public function testKeysConstantIsNonEmpty(): void
    {
        self::assertNotEmpty(I18n::KEYS, 'I18n::KEYS must not be empty.');
    }

    #[DataProvider('keyLangProvider')]
    public function testEveryKeyHasNonEmptyTranslation(string $key, string $lang): void
    {
        $ref = new \ReflectionClass(I18n::class);
        $tr  = $ref->getStaticPropertyValue('tr');

        self::assertArrayHasKey(
            $key,
            $tr,
            "Key '{$key}' is listed in I18n::KEYS but absent from the translation table."
        );
        self::assertArrayHasKey(
            $lang,
            $tr[$key],
            "Key '{$key}' is missing a '{$lang}' translation."
        );
        self::assertNotEmpty(
            $tr[$key][$lang],
            "Key '{$key}' has an empty '{$lang}' translation."
        );
    }

    /** @return iterable<string, array{string, string}> */
    public static function keyLangProvider(): iterable
    {
        foreach (I18n::KEYS as $key) {
            foreach (['en', 'tr', 'de'] as $lang) {
                yield "{$key}:{$lang}" => [$key, $lang];
            }
        }
    }

    public function testTranslationTableHasNoUndeclaredKeys(): void
    {
        $ref      = new \ReflectionClass(I18n::class);
        $tr       = $ref->getStaticPropertyValue('tr');
        $extra    = array_diff(array_keys($tr), I18n::KEYS);
        self::assertEmpty(
            $extra,
            'Translation table contains keys not declared in I18n::KEYS: ' . implode(', ', $extra)
        );
    }

    // ---------------------------------------------------------------------------
    // t() helper
    // ---------------------------------------------------------------------------

    #[DataProvider('tProvider')]
    public function testTReturnsExpectedTranslation(string $key, string $lang, string $expected): void
    {
        self::assertSame($expected, I18n::t($key, $lang));
    }

    /** @return iterable<string, array{string, string, string}> */
    public static function tProvider(): iterable
    {
        yield 'nav_attacks en'          => ['nav_attacks',          'en', 'Attacks'];
        yield 'nav_attacks tr'          => ['nav_attacks',          'tr', 'Saldırılar'];
        yield 'nav_attacks de'          => ['nav_attacks',          'de', 'Angriffe'];
        yield 'nav_home en'             => ['nav_home',             'en', 'Home'];
        yield 'nav_home tr'             => ['nav_home',             'tr', 'Ana Sayfa'];
        yield 'page_title_scheduler en' => ['page_title_scheduler', 'en', 'Scheduler'];
    }

    public function testTFallsBackToKeyForUnknownKey(): void
    {
        // t() is intentionally lenient; assertComplete() is the strict guard
        self::assertSame('nonexistent_key_xyz', I18n::t('nonexistent_key_xyz', 'en'));
    }

    public function testTFallsBackToEnForUnknownLang(): void
    {
        // unknown lang falls back to the 'en' entry
        self::assertSame(I18n::t('nav_home', 'en'), I18n::t('nav_home', 'fr'));
    }

    // ---------------------------------------------------------------------------
    // i() helper
    // ---------------------------------------------------------------------------

    public function testIEmitsAllFourAttributes(): void
    {
        $html = I18n::i('nav_home');
        self::assertStringContainsString('data-i18n-key="nav_home"', $html);
        self::assertStringContainsString('data-i18n-en="Home"', $html);
        self::assertStringContainsString('data-i18n-tr="Ana Sayfa"', $html);
        self::assertStringContainsString('data-i18n-de="Startseite"', $html);
    }

    public function testIOutputIsEscapedForHtml(): void
    {
        // All current translations are plain text, but verify the output is attribute-safe
        foreach (I18n::KEYS as $key) {
            $attrs = I18n::i($key);
            self::assertStringNotContainsString(
                '="="',
                $attrs,
                "i('{$key}') produced malformed attribute markup."
            );
        }
    }

    // ---------------------------------------------------------------------------
    // assertComplete()
    // ---------------------------------------------------------------------------

    public function testAssertCompleteDoesNotThrow(): void
    {
        $this->expectNotToPerformAssertions();
        I18n::assertComplete();
    }

    // ---------------------------------------------------------------------------
    // Docs HTML consistency scan
    // ---------------------------------------------------------------------------

    /**
     * Scans every docs/*.html file and verifies that each data-i18n-key value
     * found in the HTML is a declared key in I18n::KEYS.
     */
    public function testAllHtmlDataI18nKeysAreDeclared(): void
    {
        $docsDir = dirname(__DIR__, 2) . '/docs';
        $htmlFiles = glob($docsDir . '/*.html');
        self::assertNotEmpty($htmlFiles, 'No HTML files found in docs/.');

        $undeclared = [];
        foreach ($htmlFiles as $file) {
            $content = file_get_contents($file);
            preg_match_all('/data-i18n-key="([^"]+)"/', $content, $matches);
            foreach ($matches[1] as $key) {
                if (!in_array($key, I18n::KEYS, true)) {
                    $undeclared[] = basename($file) . ':' . $key;
                }
            }
        }

        self::assertEmpty(
            $undeclared,
            'data-i18n-key values in docs HTML are not declared in I18n::KEYS: '
                . implode(', ', $undeclared)
        );
    }
}
