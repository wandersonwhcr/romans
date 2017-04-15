<?php

namespace Romans\Grammar;

/**
 * Roman Numerals Grammar
 */
class Grammar
{
    const T_N = 'N';
    const T_I = 'I';
    const T_V = 'V';
    const T_X = 'X';
    const T_L = 'L';
    const T_C = 'C';
    const T_D = 'D';
    const T_M = 'M';

    /**
     * Get Tokens
     *
     * @return array Tokens Available
     */
    public function getTokens() : array
    {
        return [
            'T_N' => self::T_N,
            'T_I' => self::T_I,
            'T_V' => self::T_V,
            'T_X' => self::T_X,
            'T_L' => self::T_L,
            'T_C' => self::T_C,
            'T_D' => self::T_D,
            'T_M' => self::T_M,
        ];
    }

    /**
     * Get Values
     *
     * @return array Values Available
     */
    public function getValues()
    {
        return [
            'T_N' => 0,
            'T_I' => 1,
            'T_V' => 5,
            'T_X' => 10,
            'T_L' => 50,
            'T_C' => 100,
            'T_D' => 500,
            'T_M' => 1000,
        ];
    }
}
