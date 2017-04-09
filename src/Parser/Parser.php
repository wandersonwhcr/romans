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
     * Create a Mapper with Tokens and Values from Grammar
     *
     * @return array Grammar Token Values Mapper
     */
    protected function buildGrammarTokenValues() : array
    {
        $tokens = $this->getGrammar()->getTokens();
        $values = [
            1, 4, 5, 9,
            10, 40, 50, 90,
            100, 400, 500, 900,
            1000,
        ];

        return array_combine($tokens, $values);
    }

    /**
     * Parse Tokens
     *
     * @param  string[] $tokens Grammar Tokens
     * @return int      Corresponding Decimal
     */
    public function parse(array $tokens) : int
    {
        $values    = $this->buildGrammarTokenValues();
        $result    = 0;
        $lastValue = null;

        foreach ($tokens as $position => $token) {
            if (! is_string($token)) {
                throw new Exception(sprintf('Invalid token type "%s" at position %d', gettype($token), $position));
            }

            if (! isset($values[$token])) {
                throw new Exception(sprintf('Unknown token "%s" at position %d', $token, $position));
            }

            $value = $values[$token];

            if (isset($lastValue) && $lastValue < $value) {
                throw new Exception('Invalid Roman Number');
            }

            $result    = $result + $value;
            $lastValue = $value;
        }

        return $result;
    }
}
