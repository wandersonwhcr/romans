<?php

namespace RomansTest\Filter;

use PHPUnit\Framework\TestCase;
use Romans\Filter\Exception as FilterException;
use Romans\Filter\IntToRoman;
use Romans\Grammar\Grammar;

/**
 * Int to Roman Test
 */
class IntToRomanTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->filter = new IntToRoman();
    }

    /**
     * Test Constructor
     */
    public function testConstructor()
    {
        $grammar = new Grammar();
        $filter  = new IntToRoman($grammar);

        $this->assertSame($grammar, $filter->getGrammar());
    }

    /**
     * Test Filter
     */
    public function testFilter()
    {
        $this->assertSame('I', $this->filter->filter(1));
        $this->assertSame('V', $this->filter->filter(5));
        $this->assertSame('X', $this->filter->filter(10));
    }

    /**
     * Test Filter with Multiple Tokens Result
     */
    public function testFilterWithMultipleTokensResult()
    {
        $this->assertSame('III', $this->filter->filter(3));
        $this->assertSame('DLV', $this->filter->filter(555));
    }

    /**
     * Test Filter with Lookahead
     */
    public function testFilterWithLookahead()
    {
        $this->assertSame('CDLXIX', $this->filter->filter(469));
        $this->assertSame('MCMXCIX', $this->filter->filter(1999));
    }

    /**
     * Test Filter with Zero
     */
    public function testFilterWithZero()
    {
        $this->expectException(FilterException::class);
        $this->expectExceptionMessage('Invalid integer: 0');

        $this->filter->filter(0);
    }

    /**
     * Test Filter with Negative
     */
    public function testFilterWithNegative()
    {
        $this->expectException(FilterException::class);
        $this->expectExceptionMessage('Invalid integer: -1');

        $this->filter->filter(-1);
    }
}
