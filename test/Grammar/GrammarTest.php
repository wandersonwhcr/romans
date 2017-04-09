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
            'T_I'  => 'I',
            'T_IV' => 'IV',
            'T_V'  => 'V',
            'T_IX' => 'IX',
            'T_X'  => 'X',
            'T_XL' => 'XL',
            'T_L'  => 'L',
            'T_XC' => 'XC',
            'T_C'  => 'C',
            'T_CD' => 'CD',
            'T_D'  => 'D',
            'T_CM' => 'CM',
            'T_M'  => 'M',
        ];

        $this->values = [
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
     * Test Values
     */
    public function testValues()
    {
        $this->assertSame($this->values, $this->grammar->getValues());
    }
}
