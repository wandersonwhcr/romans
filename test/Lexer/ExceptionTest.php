<?php

namespace RomansTest\Lexer;

use PHPUnit\Framework\TestCase;
use Romans\Lexer\Exception;

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
    }
}
