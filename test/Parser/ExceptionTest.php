<?php

namespace RomansTest\Parser;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romans\Parser\Exception;

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
        $this->assertSame(2, Exception::INVALID_TOKEN_TYPE);
        $this->assertSame(4, Exception::INVALID_ROMAN);
    }

    /**
     * Test Token
     */
    public function testToken()
    {
        $this->assertNull($this->exception->getToken());

        $this->assertSame($this->exception, $this->exception->setToken('.'));
        $this->assertSame('.', $this->exception->getToken());

        $this->assertSame($this->exception, $this->exception->setToken(null));
        $this->assertNull($this->exception->getToken());
    }

    /**
     * Test Token with Invalid Type
     */
    public function testTokenWithInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->exception->setToken(0);
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
