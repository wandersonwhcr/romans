<?php

namespace RomansTest\Filter;

use PHPUnit\Framework\TestCase;
use Romans\Filter\RomanToInt;

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
     * Test Filter
     */
    public function testFilter()
    {
        $this->assertSame(1, $this->filter->filter('I'));
    }
}
