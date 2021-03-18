<?php

declare(strict_types=1);

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
    protected function setUp(): void
    {
        $this->lexer = new Lexer();
    }

    /**
     * Test Constructor
     */
    public function testConstructor(): void
    {
        $grammar = new Grammar();
        $lexer   = new Lexer($grammar);

        $this->assertSame($grammar, $lexer->getGrammar());
    }

    /**
     * Test Grammar
     */
    public function testGrammar(): void
    {
        $grammar = new Grammar();

        $this->assertSame($this->lexer, $this->lexer->setGrammar($grammar));
        $this->assertSame($grammar, $this->lexer->getGrammar());
    }

    /**
     * Test Tokenize
     */
    public function testTokenize(): void
    {
        $this->assertSame([Grammar::T_I], $this->lexer->tokenize('I'));
        $this->assertSame([Grammar::T_V], $this->lexer->tokenize('V'));
        $this->assertSame([Grammar::T_X], $this->lexer->tokenize('X'));
    }

    /**
     * Test Invalid Token
     */
    public function testInvalidToken(): void
    {
        $this->expectException(LexerException::class);
        $this->expectExceptionCode(LexerException::UNKNOWN_TOKEN);

        $this->lexer->tokenize('.');
    }

    /**
     * Test Tokenize with Multiple Tokens
     */
    public function testTokenizeWithMultipleTokens(): void
    {
        $this->assertSame([Grammar::T_I, Grammar::T_I], $this->lexer->tokenize('II'));
        $this->assertSame([Grammar::T_V, Grammar::T_I, Grammar::T_I], $this->lexer->tokenize('VII'));
        $this->assertSame([Grammar::T_X, Grammar::T_V, Grammar::T_I], $this->lexer->tokenize('XVI'));
    }

    /**
     * Test Invalid Token Message
     */
    public function testInvalidTokenMessage(): void
    {
        $this->expectException(LexerException::class);
        $this->expectExceptionMessage('Unknown token "." at position 2');
        $this->expectExceptionCode(LexerException::UNKNOWN_TOKEN);

        try {
            $this->lexer->tokenize('XV.I');
        } catch (LexerException $e) {
            $this->assertSame('.', $e->getToken());
            $this->assertSame(2, $e->getPosition());
            throw $e;
        }
    }

    /**
     * Test Tokenize with Lookahead Removal
     */
    public function testTokenizeWithLookaheadRemoval(): void
    {
        $this->assertSame([Grammar::T_I, Grammar::T_V], $this->lexer->tokenize('IV'));
        $this->assertSame([Grammar::T_I, Grammar::T_X], $this->lexer->tokenize('IX'));

        $this->assertSame([
            Grammar::T_C,
            Grammar::T_D,
            Grammar::T_X,
            Grammar::T_C,
            Grammar::T_I,
            Grammar::T_X,
        ], $this->lexer->tokenize('CDXCIX'));
    }

    /**
     * Test Tokenize With Simple And Lookahead Removal
     */
    public function testTokenizeWithSimpleAndLookaheadRemoval(): void
    {
        $this->assertSame([
            Grammar::T_C,
            Grammar::T_D,
            Grammar::T_L,
            Grammar::T_X,
            Grammar::T_I,
            Grammar::T_X,
        ], $this->lexer->tokenize('CDLXIX'));
    }

    /**
     * Test Tokenize With Empty Input
     */
    public function testTokenizeWithEmptyInput(): void
    {
        $this->assertSame([], $this->lexer->tokenize(''));
    }

    /**
     * Test Tokenize with Zero
     */
    public function testTokenizeWithZero(): void
    {
        $this->assertSame([Grammar::T_N], $this->lexer->tokenize('N'));
    }
}
