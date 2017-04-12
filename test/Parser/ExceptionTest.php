<?php

namespace RomansTest\Parser;

use PHPUnit\Framework\TestCase;
use Romans\Parser\Exception;

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
        $this->assertSame(1, Exception::UNKNOWN_TOKEN);
        $this->assertSame(2, Exception::INVALID_TOKEN_TYPE);
        $this->assertSame(4, Exception::INVALID_ROMAN);
    }
}
