<?php

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
    public function __construct(Grammar $grammar = null)
    {
        if (! isset($grammar)) {
            $grammar = new Grammar();
        }

        $this->setGrammar($grammar);
    }

    /**
     * Parse Tokens
     *
     * @param  string[] $tokens Grammar Tokens
     * @return int      Corresponding Decimal
     */
    public function parse(array $tokens) : int
    {
        $values          = $this->getGrammar()->getValues();
        $tokensAvailable = array_flip($this->getGrammar()->getTokens());

        $result    = 0;
        $lastValue = null;
        $length    = count($tokens);

        if ($length === 0) {
            throw new Exception('Invalid Roman', Exception::INVALID_ROMAN);
        }

        foreach ($tokens as $position => $token) {
            if (! is_string($token)) {
                $exception = new Exception(
                    sprintf('Invalid token type "%s" at position %d', gettype($token), $position),
                    Exception::INVALID_TOKEN_TYPE
                );

                $exception->setPosition($position);

                throw $exception;
            }

            if (! isset($tokensAvailable[$token])) {
                $exception = new Exception(
                    sprintf('Unknown token "%s" at position %d', $token, $position),
                    Exception::UNKNOWN_TOKEN
                );

                $exception->setPosition($position);

                throw $exception;
            }

            $value = $values[$tokensAvailable[$token]];

            // $value === 0 && $length === 1? One Token with Nulla

            if ($value === 0 && $length !== 1) {
                throw new Exception('Invalid Roman', Exception::INVALID_ROMAN);
            }

            if (isset($lastValue) && $lastValue < $value) {
                throw new Exception('Invalid Roman', Exception::INVALID_ROMAN);
            }

            $result    = $result + $value;
            $lastValue = $value;
        }

        return $result;
    }
}
