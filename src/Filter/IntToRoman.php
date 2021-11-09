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
    use CacheAwareTrait;
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

        if ($this->hasCache() && $this->getCache()->hasItem($value)) {
            return $this->getCache()->getItem($value)->get();
        }

        $tokens = $this->getGrammar()->getTokens();
        $values = array_reverse($this->getGrammar()->getValuesWithModifiers(), true /* preserve keys */);
        $result = '';

        if ($value === 0) {
            $dataset = $values[0];
            $result  = array_reduce($dataset, fn($result, $token) => $result . $tokens[$token], $result);

            return $result;
        }

        foreach ($values as $current => $dataset) {
            while ($current > 0 && $value >= $current) {
                $value  = $value - $current;
                $result = array_reduce($dataset, fn($result, $token) => $result . $tokens[$token], $result);
            }
        }

        if ($this->hasCache()) {
            $this->getCache()->getItem($value)->set($result);
        }

        return $result;
    }
}
