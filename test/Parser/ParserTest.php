<?php

namespace RomansTest\Parser;

use PHPUnit\Framework\TestCase;
use Romans\Grammar\Grammar;
use Romans\Parser\Exception as ParserException;
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
     * Test Constructor
     */
    public function testConstructor()
    {
        $grammar = new Grammar();
        $parser  = new Parser($grammar);

        $this->assertSame($grammar, $parser->getGrammar());
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

    /**
     * Test Parse with Lookahead Tokens
     */
    public function testParseWithLookaheadTokens()
    {
        $this->assertSame(9, $this->parser->parse([Grammar::T_IX]));
        $this->assertSame(99, $this->parser->parse([Grammar::T_XC, Grammar::T_IX]));
    }

    /**
     * Test Invalid Tokens
     */
    public function testInvalidToken()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid token type "integer" at position 1');
        $this->expectExceptionCode(ParserException::INVALID_TOKEN_TYPE);

        try {
            $this->parser->parse([Grammar::T_X, 0, Grammar::T_I]);
        } catch (ParserException $e) {
            $this->assertNull($e->getToken());
            $this->assertSame(1, $e->getPosition());
            throw $e;
        }
    }

    /**
     * Test Unknown Token
     */
    public function testUnknownToken()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Unknown token "." at position 1');
        $this->expectExceptionCode(ParserException::UNKNOWN_TOKEN);

        try {
            $this->parser->parse([Grammar::T_X, '.', Grammar::T_I]);
        } catch (ParserException $e) {
            $this->assertSame('.', $e->getToken());
            $this->assertSame(1, $e->getPosition());
            throw $e;
        }
    }

    /**
     * Test Invalid Syntax
     */
    public function testInvalidSyntax()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->parser->parse([Grammar::T_V, Grammar::T_C]);
    }

    /**
     * Test Another Invalid Syntax
     */
    public function testAnotherInvalidSyntax()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->parser->parse([Grammar::T_X, Grammar::T_X, Grammar::T_C]);
    }

    /**
     * Test Parse with Zero
     */
    public function testParseWithZero()
    {
        $this->assertSame(0, $this->parser->parse([Grammar::T_N]));
    }

    /**
     * Test Invalid Syntax with Zero
     */
    public function testInvalidSyntaxWithZero()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->parser->parse([Grammar::T_N, Grammar::T_I]);
    }

    /**
     * Test Invalid Syntax with Empty
     */
    public function testInvalidSyntaxWithEmpty()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->parser->parse([]);
    }

    /**
     * Test Another Invalid Syntax with Zero
     */
    public function testAnotherInvalidSyntaxWithZero()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->parser->parse([Grammar::T_I, Grammar::T_N]);
    }

    /**
     * Test Parse with One Unknown Token
     */
    public function testParseWithOneUnknownToken()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Unknown token "." at position 0');

        $this->parser->parse(['.']);
    }

    /**
     * Test Parse with One Invalid Token
     */
    public function testParseWithOneInvalidToken()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid token type "integer" at position 0');

        $this->parser->parse([0]);
    }

    /**
     * Test Parse with Two Tokens with Lookahead
     */
    public function testParseWithTwoTokensWithLookahead()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->parser->parse([Grammar::T_IX, Grammar::T_IX]);
    }

    /**
     * Test Parse with One Lookahead Token and One Simple Token
     */
    public function testParseWithOneLookaheadTokenAndOneSimpleToken()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->parser->parse([Grammar::T_IX, Grammar::T_V]);
    }

    /**
     * Test Parse with Four Simple Tokens in Sequence
     */
    public function testParseWithFourSimpleTokensInSequence()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->parser->parse([Grammar::T_I, Grammar::T_I, Grammar::T_I, Grammar::T_I]);
    }

    /**
     * Test Parse with Tokens in Sequence for Thousands
     */
    public function testParseWithTokensInSequenceForThousands()
    {
        $this->assertSame(4000, $this->parser->parse([Grammar::T_M, Grammar::T_M, Grammar::T_M, Grammar::T_M]));

        $this->assertSame(5000, $this->parser->parse([
            Grammar::T_M,
            Grammar::T_M,
            Grammar::T_M,
            Grammar::T_M,
            Grammar::T_M,
        ]));
    }
}
