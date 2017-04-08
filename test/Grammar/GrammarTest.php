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

    public function testAvailableTokens()
    {
        $grammar = new Grammar();

        $this->assertSame($this->tokens, $grammar->getTokens());
    }
}
