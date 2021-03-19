<?php

declare(strict_types=1);

namespace RomansTest\Filter;

use PHPUnit\Framework\TestCase;
use Romans\Filter\RomanToInt;
use Romans\Grammar\Grammar;
use Romans\Lexer\Lexer;
use Romans\Parser\Parser;
use TypeError;

/**
 * Roman to Int Test
 */
class RomanToIntTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->filter = new RomanToInt();
    }

    /**
     * Test Constructor
     */
    public function testConstructor(): void
    {
        $grammar = new Grammar();
        $filter  = new RomanToInt($grammar);

        $this->assertInstanceOf(Lexer::class, $filter->getLexer());
        $this->assertInstanceOf(Parser::class, $filter->getParser());

        $this->assertSame($grammar, $filter->getLexer()->getGrammar());
        $this->assertSame($grammar, $filter->getParser()->getGrammar());
    }

    /**
     * Test Nullable Lexer
     */
    public function testNullableLexer(): void
    {
        $this->expectException(TypeError::class);

        $this->filter->setLexer(null);
    }

    /**
     * Test Nullable Parser
     */
    public function testNullableParser(): void
    {
        $this->expectException(TypeError::class);

        $this->filter->setParser(null);
    }

    /**
     * Test Filter
     */
    public function testFilter(): void
    {
        $this->assertSame(1, $this->filter->filter('I'));
        $this->assertSame(5, $this->filter->filter('V'));
        $this->assertSame(10, $this->filter->filter('X'));
    }

    /**
     * Test Filter with Multiple
     */
    public function testFilterWithMultiple(): void
    {
        $this->assertSame(68, $this->filter->filter('LXVIII'));
        $this->assertSame(1537, $this->filter->filter('MDXXXVII'));
    }

    /**
     * Test Filter with Lookahead
     */
    public function testFilterWithLookahead(): void
    {
        $this->assertSame(4, $this->filter->filter('IV'));
        $this->assertSame(9, $this->filter->filter('IX'));
        $this->assertSame(40, $this->filter->filter('XL'));
    }

    /**
     * Test Filter with Multiple Lookahead
     */
    public function testFilterWithMultipleLookahead(): void
    {
        $this->assertSame(469, $this->filter->filter('CDLXIX'));
        $this->assertSame(1999, $this->filter->filter('MCMXCIX'));
    }

    /**
     * Test Filter with Zero
     */
    public function testFilterWithZero(): void
    {
        $this->assertSame(0, $this->filter->filter('N'));
    }
}
