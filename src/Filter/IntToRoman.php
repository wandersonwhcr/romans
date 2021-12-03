<?php

declare(strict_types=1);

namespace Romans\Filter;

use Romans\Cache\CacheAwareTrait;
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
     * Helper to Cache a Result from Value
     *
     * @param int    $value Integer
     * @param string Roman Number Result
     */
    private function cache(int $value, string $result): void
    {
        if ($this->hasCache()) {
            $item = $this->getCache()->getItem((string) $value)->set($result);
            $this->getCache()->save($item);
        }
    }

    /**
     * Filter Integer to Roman Number
     *
     * @param  int    Integer
     * @return string Roman Number Result
     */
    public function filter(int $value): string
    {
        ($value < 0)
            && throw new Exception(sprintf('Invalid integer: %d', $value), Exception::INVALID_INTEGER);

        if ($this->hasCache() && $this->getCache()->hasItem((string) $value)) {
            return $this->getCache()->getItem((string) $value)->get();
        }

        $tokens = $this->getGrammar()->getTokens();
        $values = array_reverse($this->getGrammar()->getValuesWithModifiers(), preserve_keys: true);
        $result = '';

        if ($value === 0) {
            $dataset = $values[0];
            $result  = array_reduce($dataset, fn($result, $token) => $result . $tokens[$token], $result);

            $this->cache($value, $result);

            return $result;
        }

        foreach ($values as $current => $dataset) {
            while ($current > 0 && $value >= $current) {
                $value  = $value - $current;
                $result = array_reduce($dataset, fn($result, $token) => $result . $tokens[$token], $result);
            }
        }

        $this->cache($value, $result);

        return $result;
    }
}
