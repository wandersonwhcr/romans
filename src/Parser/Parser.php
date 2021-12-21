<?php

declare(strict_types=1);

namespace Romans\Parser;

use Romans\Grammar\Grammar;
use Romans\Grammar\GrammarAwareTrait;

/**
 * Parser
 */
class Parser
{
    use GrammarAwareTrait;

    /**
     * Default Constructor
     *
     * @param Grammar $grammar Grammar Object
     */
    public function __construct(?Grammar $grammar = null)
    {
        $this->setGrammar($grammar ?? new Grammar());
    }

    /**
     * Parse Tokens
     *
     * @param  string[] $tokens Grammar Tokens
     * @return int      Corresponding Decimal
     */
    public function parse(array $tokens): int
    {
        (count($tokens) === 0)
            && throw new Exception('Invalid Roman', Exception::INVALID_ROMAN);

        $tokensAvailable = array_flip($this->getGrammar()->getTokens());

        foreach ($tokens as $position => $token) {
            if (! is_string($token)) {
                $exception = new Exception(
                    sprintf('Invalid token type "%s" at position %d', gettype($token), $position),
                    Exception::INVALID_TOKEN_TYPE,
                );

                $exception->setPosition($position);

                throw $exception;
            }

            if (! isset($tokensAvailable[$token])) {
                $exception = new Exception(
                    sprintf('Unknown token "%s" at position %d', $token, $position),
                    Exception::UNKNOWN_TOKEN,
                );

                $exception
                    ->setToken($token)
                    ->setPosition($position);

                throw $exception;
            }
        }

        return (new Automaton($this->getGrammar()))->read($tokens)->getValue();
    }
}
