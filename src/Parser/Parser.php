<?php

namespace Romans\Parser;

use Romans\Grammar\GrammarAwareTrait;

/**
 * Parser
 */
class Parser
{
    use GrammarAwareTrait;

    /**
     * Parse Tokens
     *
     * @param  string[] $tokens Grammar Tokens
     * @return int      Corresponding Decimal
     */
    public function parse(array $tokens) : int
    {
        return 1;
    }
}
