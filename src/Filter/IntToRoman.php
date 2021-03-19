<?php

declare(strict_types=1);

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
    public function __construct(?Grammar $grammar = null)
    {
        $this->setGrammar($grammar ?? new Grammar());
    }

    /**
     * Filter Integer to Roman Number
     *
     * @param  int    Integer
     * @return string Roman Number Result
     */
    public function filter(int $value): string
    {
        if ($value < 0) {
            throw new Exception(sprintf('Invalid integer: %d', $value), Exception::INVALID_INTEGER);
        }

        $tokens = $this->getGrammar()->getTokens();
        $values = array_reverse($this->getGrammar()->getValuesWithModifiers(), true /* preserve keys */);
        $result = '';

        if ($value === 0) {
            $dataset = $values[0];

            foreach ($dataset as $token) {
                $result = $result . $tokens[$token];
            }

            return $result;
        }

        foreach ($values as $current => $dataset) {
            while ($current > 0 && $value >= $current) {
                $value = $value - $current;
                foreach ($dataset as $token) {
                    $result = $result . $tokens[$token];
                }
            }
        }

        return $result;
    }
}
