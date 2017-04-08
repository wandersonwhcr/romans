<?php

namespace Romans\Grammar;

/**
 * Roman Numerals Grammar
 */
class Grammar
{
    const T_I  = 'I';
    const T_IV = 'IV';
    const T_V  = 'V';
    const T_IX = 'IX';
    const T_X  = 'X';
    const T_XL = 'XL';
    const T_L  = 'L';
    const T_XC = 'XC';
    const T_C  = 'C';
    const T_CD = 'CD';
    const T_D  = 'D';
    const T_CM = 'CM';
    const T_M  = 'M';

    /**
     * Get Tokens
     *
     * @return array Tokens Available
     */
    public function getTokens() : array
    {
        return [
            'T_I'  => self::T_I,
            'T_IV' => self::T_IV,
            'T_V'  => self::T_V,
            'T_IX' => self::T_IX,
            'T_X'  => self::T_X,
            'T_XL' => self::T_XL,
            'T_L'  => self::T_L,
            'T_XC' => self::T_XC,
            'T_C'  => self::T_C,
            'T_CD' => self::T_CD,
            'T_D'  => self::T_D,
            'T_CM' => self::T_CM,
            'T_M'  => self::T_M,
        ];
    }
}
