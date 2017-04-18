<?php

namespace Romans\Lexer;

use Romans\Grammar\Grammar;
use Romans\Grammar\GrammarAwareTrait;

/**
 * Roman Numerals Lexer
 */
class Lexer
{
    use GrammarAwareTrait;

    /**
     * Default Constructor
     *
     * @param Grammar $grammar Grammar Object
     */
    public function __construct(Grammar $grammar = null)
    {
        if (! isset($grammar)) {
            $grammar = new Grammar();
        }

        $this->setGrammar($grammar);
    }

    /**
     * Tokenize Content
     *
     * @param  string $content Input Content
     * @return array  Result Token Set
     */
    public function tokenize(string $content) : array
    {
        $tokens   = $this->getGrammar()->getTokens();
        $numerals = array_flip($tokens);

        $length   = strlen($content);
        $position = 0;
        $result   = [];

        while ($position < $length) {
            $current = $content[$position];

            if (! isset($numerals[$current])) {
                $exception = new Exception(
                    sprintf('Unknown token "%s" at position %d', $current, $position),
                    Exception::UNKNOWN_TOKEN
                );

                $exception
                    ->setToken($current)
                    ->setPosition($position);

                throw $exception;
            }

            $result[] = $current;
            $position = $position + 1;
        }

        return $result;
    }
}
