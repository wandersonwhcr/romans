<?php

namespace RomansTest\Filter;

use PHPUnit\Framework\TestCase;
use Romans\Filter\RomanToInt;
use Romans\Lexer\Lexer;
use Romans\Parser\Parser;

/**
 * Roman to Int Test
 */
class RomanToIntTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->filter = new RomanToInt();
    }

    /**
     * Test Constructor
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(Lexer::class, $this->filter->getLexer());
        $this->assertInstanceOf(Parser::class, $this->filter->getParser());
    }

    /**
     * Test Filter
     */
    public function testFilter()
    {
        $this->assertSame(1, $this->filter->filter('I'));
    }
}
