<?php

declare(strict_types=1);

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
    public function testCode(): void
    {
        $this->assertSame(1, Exception::INVALID_INTEGER);
    }
}
