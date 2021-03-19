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
    private Grammar $grammar;

    /**
     * Set Grammar
     *
     * @param  Grammar $grammar Grammar Object
     * @return self    Fluent Interface
     */
    public function setGrammar(Grammar $grammar): self
    {
        $this->grammar = $grammar;
        return $this;
    }

    /**
     * Get Grammar
     *
     * @return Grammar Grammar Object
     */
    public function getGrammar(): Grammar
    {
        return $this->grammar;
    }
}
