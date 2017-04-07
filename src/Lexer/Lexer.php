<?php

namespace Romans\Lexer;

use Romans\Grammar\Grammar;

/**
 * Roman Numerals Lexer
 */
class Lexer
{
    /**
     * Tokenize Content
     *
     * @param  string $content Input Content
     * @return array  Result Token Set
     */
    public function tokenize(string $content) : array
    {
        $length = strlen($content);
        $result = [];

        for ($i = 0; $i < $length; $i++) {
            $result[] = $content[$i];
        }

        return $result;
    }
}
