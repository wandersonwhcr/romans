<?php

declare(strict_types=1);

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
    protected function setUp(): void
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
    public function testTokens(): void
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
    public function testAvailableTokens(): void
    {
        $this->assertSame($this->tokens, $this->grammar->getTokens());
    }

    /**
     * Test Modifiers
     */
    public function testModifiers(): void
    {
        $this->assertSame($this->modifiers, $this->grammar->getModifiers());
    }

    /**
     * Test Values
     */
    public function testValues(): void
    {
        $this->assertSame($this->values, $this->grammar->getValues());
    }

    /**
     * Test Values with Modifiers
     */
    public function testValuesWithModifiers(): void
    {
        $values = array_map(fn($value) => [$value], array_flip($this->values));

        $valuesWithModifiers = $values + $this->modifiers; // merge and keep keys

        ksort($valuesWithModifiers);

        $this->assertSame($valuesWithModifiers, $this->grammar->getValuesWithModifiers());
    }

    /**
     * Test Values with Modifiers Calculate Once
     */
    public function testValuesWithModifiersCalculateOnce(): void
    {
        $grammar = $this->getMockBuilder(Grammar::class)
            ->onlyMethods(['getValues', 'getModifiers'])
            ->getMock();

        $grammar->expects($this->once())
            ->method('getValues');

        $grammar->expects($this->once())
            ->method('getModifiers');

        $grammar->getValuesWithModifiers();
        $grammar->getValuesWithModifiers();
    }

    /**
     * Test Values with Modifiers Initialization
     */
    public function testValuesWithModifiersInitialization(): void
    {
        $reflection = new ReflectionClass(Grammar::class);
        $property   = $reflection->getProperty('valuesWithModifiers');

        $property->setAccessible(true);

        $this->assertNull($property->getValue($this->grammar));
    }
}
