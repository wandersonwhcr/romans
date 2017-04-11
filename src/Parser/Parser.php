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
     * Grammar
     * @type Grammar
     */
    private $grammar;

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
            throw new Exception('Invalid Roman Number');
        }

        if ($length === 1) {
            $token = current($tokens);
            $value = $values[$tokensAvailable[$token]];

            if ($value === 0) {
                // Special Case: One Token with Nulla
                return 0;
            }
        }

        foreach ($tokens as $position => $token) {
            if (! is_string($token)) {
                throw new Exception(sprintf('Invalid token type "%s" at position %d', gettype($token), $position));
            }

            if (! isset($tokensAvailable[$token])) {
                throw new Exception(sprintf('Unknown token "%s" at position %d', $token, $position));
            }

            $value = $values[$tokensAvailable[$token]];

            if ($value === 0) {
                throw new Exception('Invalid Roman Number');
            }

            if (isset($lastValue) && $lastValue < $value) {
                throw new Exception('Invalid Roman Number');
            }

            $result    = $result + $value;
            $lastValue = $value;
        }

        return $result;
    }
}
