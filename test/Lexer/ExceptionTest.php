<?php

namespace RomansTest\Lexer;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romans\Lexer\Exception;

/**
 * Exception Test
 */
class ExceptionTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->exception = new Exception();
    }

    /**
     * Test Code
     */
    public function testCode()
    {
        $this->assertSame(1, Exception::UNKNOWN_TOKEN);
    }

    /**
     * Test Position
     */
    public function testPosition()
    {
        $this->assertNull($this->exception->getPosition());

        $this->assertSame($this->exception, $this->exception->setPosition(1));
        $this->assertSame(1, $this->exception->getPosition());

        $this->assertSame($this->exception, $this->exception->setPosition(0));
        $this->assertSame(0, $this->exception->getPosition());

        $this->assertSame($this->exception, $this->exception->setPosition(null));

        $this->assertNull($this->exception->getPosition());
    }

    /**
     * Test Position with Invalid Type
     */
    public function testPositionWithInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->exception->setPosition('FOOBAR');
    }
}
