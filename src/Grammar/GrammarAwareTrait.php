<?php
declare(strict_types=1);

namespace Romans\Grammar;

/**
 * Grammar Aware Trait
 */
trait GrammarAwareTrait
{
    /**
     * Grammar
     */
    private ?Grammar $grammar = null;

    /**
     * Set Grammar
     *
     * @param  $grammar Grammar Object
     * @return Fluent Interface
     */
    public function setGrammar(?Grammar $grammar) : self
    {
        $this->grammar = $grammar;
        return $this;
    }

    /**
     * Get Grammar
     *
     * @return Grammar Object
     */
    public function getGrammar() : ?Grammar
    {
        return $this->grammar;
    }
}
