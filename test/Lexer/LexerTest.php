<?php

namespace RomansTest\Lexer;

use PHPUnit\Framework\TestCase;
use Romans\Grammar\Grammar;
use Romans\Lexer\Exception as LexerException;
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
        $this->assertSame([Grammar::T_V], $this->lexer->tokenize('V'));
        $this->assertSame([Grammar::T_X], $this->lexer->tokenize('X'));
    }

    /**
     * Test Invalid Token
     */
    public function testInvalidToken()
    {
        $this->expectException(LexerException::class);

        $this->lexer->tokenize('.');
    }

    /**
     * Test Tokenize with Multiple Tokens
     */
    public function testTokenizeWithMultipleTokens()
    {
        $this->assertSame([Grammar::T_I, Grammar::T_I], $this->lexer->tokenize('II'));
        $this->assertSame([Grammar::T_V, Grammar::T_I, Grammar::T_I], $this->lexer->tokenize('VII'));
        $this->assertSame([Grammar::T_X, Grammar::T_V, Grammar::T_I], $this->lexer->tokenize('XVI'));
    }
}
