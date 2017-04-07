<?php

namespace Romans\Lexer;

use Romans\Grammar\Grammar;

/**
 * Roman Numerals Lexer
 */
class Lexer
{
    /**
     * Grammar
     * @type Grammar
     */
    private $grammar;

    /**
     * Default Constructor
     */
    public function __construct()
    {
        $this->setGrammar(new Grammar());
    }

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

    /**
     * Tokenize Content
     *
     * @param  string $content Input Content
     * @return array  Result Token Set
     */
    public function tokenize(string $content) : array
    {
        $tokens   = $this->getGrammar()->getTokens();
        $numerals = array_flip($tokens);

        $length = strlen($content);
        $result = [];

        for ($i = 0; $i < $length; $i++) {
            $current = $content[$i];

            if (! isset($numerals[$current])) {
                throw new Exception(sprintf('Unknown token "%s" at position %d', $current, $i));
            }

            $result[] = $current;
        }

        return $result;
    }
}
