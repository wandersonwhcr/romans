<?php

namespace RomansTest\Filter;

use PHPUnit\Framework\TestCase;
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
    }
}
