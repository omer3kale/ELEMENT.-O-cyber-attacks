<?php

declare(strict_types=1);

namespace ElementO\Tests\Presentation;

use ElementO\Presentation\AttackListRenderer;
use ElementO\Presentation\I18n;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class AttackListRendererI18nTest extends TestCase
{
    /** @var array<string> */
    private array $keys;

    /** @var array<string, array<string, string>> */
    private array $tr;

    protected function setUp(): void
    {
        $ref        = new \ReflectionClass(I18n::class);
        $this->keys = I18n::KEYS;
        $this->tr   = $ref->getStaticPropertyValue('tr');
    }

    public function testAllKeysExistInTranslationTable(): void
    {
        foreach ($this->keys as $key) {
            self::assertArrayHasKey(
                $key,
                $this->tr,
                "Key '{$key}' is listed in I18N_KEYS but has no entry in the translation table."
            );
        }
    }

    #[DataProvider('languageProvider')]
    public function testEveryKeyHasTranslationForLanguage(string $lang): void
    {
        foreach ($this->keys as $key) {
            self::assertArrayHasKey(
                $lang,
                $this->tr[$key] ?? [],
                "Key '{$key}' is missing a '{$lang}' translation."
            );
            self::assertNotEmpty(
                $this->tr[$key][$lang],
                "Key '{$key}' has an empty '{$lang}' translation."
            );
        }
    }

    /** @return iterable<string, array{string}> */
    public static function languageProvider(): iterable
    {
        yield 'English' => ['en'];
        yield 'Turkish' => ['tr'];
        yield 'German'  => ['de'];
    }

    public function testAssertI18nCompleteRunsWithoutException(): void
    {
        $renderer = new AttackListRenderer();
        $html     = $renderer->render([]);
        self::assertStringContainsString('lang-toggle', $html);
    }

    public function testTranslationTableHasNoExtraUndeclaredKeys(): void
    {
        $trKeys   = array_keys($this->tr);
        $extraKeys = array_diff($trKeys, $this->keys);
        self::assertEmpty(
            $extraKeys,
            'Translation table has keys not declared in I18N_KEYS: ' . implode(', ', $extraKeys)
        );
    }
}
