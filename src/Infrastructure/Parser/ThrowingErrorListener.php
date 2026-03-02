<?php

declare(strict_types=1);

namespace ElementO\Infrastructure\Parser;

use Antlr\Antlr4\Runtime\Error\Listeners\BaseErrorListener;
use Antlr\Antlr4\Runtime\Error\Exceptions\RecognitionException;
use Antlr\Antlr4\Runtime\Parser;
use Antlr\Antlr4\Runtime\Recognizer;
use RuntimeException;

final class ThrowingErrorListener extends BaseErrorListener
{
    public function syntaxError(
        Recognizer $recognizer,
        ?object $offendingSymbol,
        int $line,
        int $charPositionInLine,
        string $msg,
        ?RecognitionException $e,
    ): void {
        throw new RuntimeException(
            sprintf(
                'DSL parse error at line %d:%d — %s',
                $line,
                $charPositionInLine,
                $msg
            )
        );
    }
}
