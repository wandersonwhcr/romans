<?php

namespace Romans\Filter;

use Romans\Grammar\Grammar;
use Romans\Grammar\GrammarAwareTrait;

/**
 * Int to Roman
 */
class IntToRoman
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
     * Filter Integer to Roman Number
     *
     * @param  int    Integer
     * @return string Roman Number Result
     */
    public function filter(int $value) : string
    {
        if ($value < 0) {
            throw new Exception(sprintf('Invalid integer: %d', $value), Exception::INVALID_INTEGER);
        }

        $tokens = $this->getGrammar()->getTokens();
        $values = array_reverse($this->getGrammar()->getValues());

        if ($value === 0) {
            $token = array_search(0, $values);

            return $tokens[$token];
        }

        $result = '';

        foreach ($values as $token => $current) {
            while ($current > 0 && $value >= $current) {
                $value  = $value - $current;
                $result = $result . $tokens[$token];
            }
        }

        return $result;
    }
}
