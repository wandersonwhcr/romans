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
     * Test Tokens
     */
    public function testTokens()
    {
        $reflection = new ReflectionClass(Grammar::class);

        $numerals = [
            'I',
            'IV',
            'V',
            'IX',
            'X',
            'XL',
            'L',
            'XC',
            'C',
            'CD',
            'D',
            'CM',
            'M',
        ];

        foreach ($numerals as $numeral) {
            $token = 'T_' . $numeral;

            $this->assertTrue($reflection->hasConstant($token));
            $this->assertSame($numeral, $reflection->getConstant($token));
        }
    }
}
