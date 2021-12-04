<?php

declare(strict_types=1);

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
     * @var array<int,string[]>|null
     */
    private ?array $valuesWithModifiers = null;

    /**
     * Get Tokens
     *
     * @return array<string,int> Tokens Available
     */
    public function getTokens(): array
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
     * @return array<string,int> Values Available
     */
    public function getValues(): array
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

    /**
     * Get Modifiers
     *
     * @return array<int,string[]> Modifiers Available
     */
    public function getModifiers(): array
    {
        return [
            4   => ['T_I', 'T_V'],
            9   => ['T_I', 'T_X'],
            40  => ['T_X', 'T_L'],
            90  => ['T_X', 'T_C'],
            400 => ['T_C', 'T_D'],
            900 => ['T_C', 'T_M'],
        ];
    }

    /**
     * Get Values with Modifiers
     *
     * @return array<int,string[]> Values with Modifiers Available
     */
    public function getValuesWithModifiers(): array
    {
        if (isset($this->valuesWithModifiers)) {
            return $this->valuesWithModifiers;
        }

        $values = array_map(fn($value) => [$value], array_flip($this->getValues()));

        $valuesWithModifiers = $values + $this->getModifiers(); // merge and keep keys (append)

        ksort($valuesWithModifiers);

        $this->valuesWithModifiers = $valuesWithModifiers;

        return $this->valuesWithModifiers;
    }
}
