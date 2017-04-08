<?php

namespace Romans\Grammar;

/**
 * Grammar Aware Trait
 */
trait GrammarAwareTrait
{
    /**
     * Grammar
     * @type Grammar
     */
    private $grammar;

    /**
     * Set Grammar
     *
     * @param  Grammar $grammar Grammar Object
     * @return self    Fluent Interface
     */
    public function setGrammar(Grammar $grammar) : self
    {
        $this->grammar = $grammar;
        return $this;
    }

    /**
     * Get Grammar
     *
     * @return Grammar Grammar Object
     */
    public function getGrammar() : Grammar
    {
        return $this->grammar;
    }
}
