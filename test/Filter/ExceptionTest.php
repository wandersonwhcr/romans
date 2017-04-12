<?php

namespace RomansTest\Filter;

use PHPUnit\Framework\TestCase;
use Romans\Filter\Exception;

/**
 * Exception Test
 */
class ExceptionTest extends TestCase
{
    /**
     * Test Code
     */
    public function testCode()
    {
        $this->assertSame(1, Exception::INVALID_INTEGER);
    }
}
