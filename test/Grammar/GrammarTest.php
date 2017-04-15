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
