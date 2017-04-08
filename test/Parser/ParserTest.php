<?php

namespace RomansTest\Parser;

use PHPUnit\Framework\TestCase;
use Romans\Grammar\Grammar;
use Romans\Parser\Parser;

/**
 * Parser Test
 */
class ParserTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->parser = new Parser();
    }

    /**
     * Test Grammar
     */
    public function testGrammar()
    {
        $grammar = new Grammar();

        $this->assertSame($this->parser, $this->parser->setGrammar($grammar));
        $this->assertSame($grammar, $this->parser->getGrammar());
    }

    /**
     * Test Parse
     */
    public function testParse()
    {
        $this->assertSame(1, $this->parser->parse([Grammar::T_I]));
        $this->assertSame(5, $this->parser->parse([Grammar::T_V]));
        $this->assertSame(10, $this->parser->parse([Grammar::T_X]));
    }

    /**
     * Test Parse with Multiple Tokens
     */
    public function testParseWithMultipleTokens()
    {
        $this->assertSame(6, $this->parser->parse([Grammar::T_V, Grammar::T_I]));
        $this->assertSame(13, $this->parser->parse([Grammar::T_X, Grammar::T_I, Grammar::T_I, Grammar::T_I]));
        $this->assertSame(111, $this->parser->parse([Grammar::T_C, Grammar::T_X, Grammar::T_I]));
    }
}
