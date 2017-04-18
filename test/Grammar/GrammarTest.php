<?php

namespace RomansTest\Grammar;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Romans\Grammar\Grammar;

/**
 * Grammar Test
 */
class GrammarTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->grammar = new Grammar();

        $this->tokens = [
            'T_N' => 'N',
            'T_I' => 'I',
            'T_V' => 'V',
            'T_X' => 'X',
            'T_L' => 'L',
            'T_C' => 'C',
            'T_D' => 'D',
            'T_M' => 'M',
        ];

        $this->values = [
            'T_N' => 0,
            'T_I' => 1,
            'T_V' => 5,
            'T_X' => 10,
            'T_L' => 50,
            'T_C' => 100,
            'T_D' => 500,
            'T_M' => 1000,
        ];

        $this->modifiers = [
            4   => ['T_I', 'T_V'],
            9   => ['T_I', 'T_X'],
            40  => ['T_X', 'T_L'],
            90  => ['T_X', 'T_C'],
            400 => ['T_C', 'T_D'],
            900 => ['T_C', 'T_M'],
        ];
    }

    /**
     * Test Tokens
     */
    public function testTokens()
    {
        $reflection = new ReflectionClass(Grammar::class);

        foreach ($this->tokens as $token => $numeral) {
            $this->assertTrue($reflection->hasConstant($token));
            $this->assertSame($numeral, $reflection->getConstant($token));
        }
    }

    /**
     * Test Available Tokens
     */
    public function testAvailableTokens()
    {
        $this->assertSame($this->tokens, $this->grammar->getTokens());
    }

    /**
     * Test Modifiers
     */
    public function testModifiers()
    {
        $this->assertSame($this->modifiers, $this->grammar->getModifiers());
    }

    /**
     * Test Values
     */
    public function testValues()
    {
        $this->assertSame($this->values, $this->grammar->getValues());
    }

    /**
     * Test Values with Modifiers
     */
    public function testValuesWithModifiers()
    {
        $values = array_map(function ($value) {
            return [$value];
        }, array_flip($this->values));

        $valuesWithModifiers = $values + $this->modifiers; // merge and keep keys

        ksort($valuesWithModifiers);

        $this->assertSame($valuesWithModifiers, $this->grammar->getValuesWithModifiers());
    }
}
