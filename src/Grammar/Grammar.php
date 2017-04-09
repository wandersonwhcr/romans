<?php

namespace Romans\Grammar;

/**
 * Roman Numerals Grammar
 */
class Grammar
{
    const T_N  = 'N';
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
            'T_N'  => self::T_N,
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

    /**
     * Get Values
     *
     * @return array Values Available
     */
    public function getValues()
    {
        return [
            'T_N'  => 0,
            'T_I'  => 1,
            'T_IV' => 4,
            'T_V'  => 5,
            'T_IX' => 9,
            'T_X'  => 10,
            'T_XL' => 40,
            'T_L'  => 50,
            'T_XC' => 90,
            'T_C'  => 100,
            'T_CD' => 400,
            'T_D'  => 500,
            'T_CM' => 900,
            'T_M'  => 1000,
        ];
    }
}
