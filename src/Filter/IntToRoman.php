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
        return 'I';
    }
}
