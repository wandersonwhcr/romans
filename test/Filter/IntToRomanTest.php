<?php

namespace RomansTest\Filter;

use PHPUnit\Framework\TestCase;
use Romans\Filter\IntToRoman;

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
     * Test Filter
     */
    public function testFilter()
    {
        $this->assertSame('I', $this->filter->filter(1));
    }
}
