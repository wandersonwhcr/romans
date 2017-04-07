<?php

namespace RomansTest\Lexer;

use PHPUnit\Framework\TestCase;
use Romans\Grammar\Grammar;
use Romans\Lexer\Lexer;

/**
 * Lexer Test
 */
class LexerTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->lexer = new Lexer();
    }

    /**
     * Test Tokenize
     */
    public function testTokenize()
    {
        $this->assertSame([Grammar::T_I], $this->lexer->tokenize('I'));
    }
}
