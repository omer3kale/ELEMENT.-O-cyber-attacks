<?php

declare(strict_types=1);

namespace ElementO\Infrastructure\Parser;

use ElementO\Domain\Attack\AttackAggregate;
use RuntimeException;

final class ANTLRParserAdapter
{
    private readonly string $generatedDir;

    private static bool $generated = false;

    public function __construct(?string $generatedDir = null)
    {
        $this->generatedDir = $generatedDir
            ?? dirname(__DIR__, 3) . '/src/Infrastructure/Parser/Generated';
    }

    // Public API


    /**
     * @return list<AttackAggregate>
     *
     * @throws RuntimeException 
     */
    public function parseFile(string $filePath): array
    {
        if (!is_readable($filePath)) {
            throw new RuntimeException(
                sprintf('DSL file is not readable: "%s".', $filePath)
            );
        }

        return $this->parseString((string) file_get_contents($filePath));
    }

    /**
     * @return list<AttackAggregate>
     */
    public function parseString(string $content): array
    {
        $this->ensureGeneratedFilesLoaded();

        $inputStream  = \Antlr\Antlr4\Runtime\InputStream::fromString($content);
        $lexer        = new \AttackDSLLexer($inputStream);
        $tokenStream  = new \Antlr\Antlr4\Runtime\CommonTokenStream($lexer);
        $parser       = new \AttackDSLParser($tokenStream);

        $parser->removeErrorListeners();
        $parser->addErrorListener(new ThrowingErrorListener());

        $tree    = $parser->attackCollection();
        $visitor = new AttackDslVisitor();

        /** @var list<AttackAggregate> $attacks */
        $attacks = $visitor->visit($tree);

        return $attacks;
    }

    /**
     * @return list<AttackAggregate>  
     *
     * @throws RuntimeException 
     */
    public function parseDirectory(string $directory): array
    {
        if (!is_dir($directory)) {
            throw new RuntimeException(
                sprintf('DSL directory does not exist: "%s".', $directory)
            );
        }

        $files   = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS)
        );

        $attacks = [];

        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            if ($file->getExtension() !== 'attack') {
                continue;
            }

            foreach ($this->parseFile($file->getPathname()) as $attack) {
                $attacks[] = $attack;
            }
        }

        return $attacks;
    }

    // Loader

    private function ensureGeneratedFilesLoaded(): void
    {
        if (self::$generated) {
            return;
        }

        $requiredFiles = [
            $this->generatedDir . '/AttackDSLLexer.php',
            $this->generatedDir . '/AttackDSLParser.php',
            $this->generatedDir . '/AttackDSLVisitor.php',
            $this->generatedDir . '/AttackDSLBaseVisitor.php',
        ];

        foreach ($requiredFiles as $file) {
            if (!is_readable($file)) {
                throw new RuntimeException(
                    sprintf(
                        'Generated ANTLR file not found: "%s". '
                        . 'Run `composer antlr-generate` to regenerate the parser.',
                        $file
                    )
                );
            }

            require_once $file;
        }

        self::$generated = true;
    }
}
