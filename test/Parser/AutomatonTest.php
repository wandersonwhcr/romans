<?php

namespace RomansTest\Parser;

use PHPUnit\Framework\TestCase;
use Romans\Parser\Automaton;
use Romans\Parser\Exception as ParserException;

/**
 * Automaton Test
 */
class AutomatonTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->automaton = new Automaton();
    }

    /**
     * Test States
     */
    public function testStates()
    {
        $this->assertSame(Automaton::STATE_Z, 'Z');
        $this->assertSame(Automaton::STATE_A, 'A');
        $this->assertSame(Automaton::STATE_B, 'B');
        $this->assertSame(Automaton::STATE_C, 'C');
        $this->assertSame(Automaton::STATE_D, 'D');
        $this->assertSame(Automaton::STATE_E, 'E');
        $this->assertSame(Automaton::STATE_F, 'F');
        $this->assertSame(Automaton::STATE_G, 'G');
    }

    /**
     * Test Tokens
     */
    public function testTokens()
    {
        $this->assertSame(Automaton::TOKEN_N, 'N');
        $this->assertSame(Automaton::TOKEN_I, 'I');
        $this->assertSame(Automaton::TOKEN_V, 'V');
        $this->assertSame(Automaton::TOKEN_X, 'X');
        $this->assertSame(Automaton::TOKEN_L, 'L');
        $this->assertSame(Automaton::TOKEN_C, 'C');
        $this->assertSame(Automaton::TOKEN_D, 'D');
        $this->assertSame(Automaton::TOKEN_M, 'M');
    }

    /**
     * Test Initial State
     */
    public function testInitialState()
    {
        $this->assertSame(Automaton::STATE_G, $this->automaton->getState());
    }

    /**
     * Test Initial Position
     */
    public function testInitialPosition()
    {
        $this->assertSame(0, $this->automaton->getPosition());
    }

    /**
     * Test Initial Value
     */
    public function testInitialValue()
    {
        $this->assertSame(0, $this->automaton->getValue());
    }

    /**
     * Test Zero
     */
    public function testZero()
    {
        $this->assertSame($this->automaton, $this->automaton->read([Automaton::TOKEN_N]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(0, $this->automaton->getValue());
    }

    /**
     * Test Token M
     */
    public function testTokenM()
    {
        $this->assertSame($this->automaton, $this->automaton->read([Automaton::TOKEN_M]));
        $this->assertSame(Automaton::STATE_G, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(1000, $this->automaton->getValue());

        $this->assertSame($this->automaton, $this->automaton->read([Automaton::TOKEN_M, Automaton::TOKEN_M]));
        $this->assertSame(Automaton::STATE_G, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(2000, $this->automaton->getValue());
    }

    /**
     * Test Token D
     */
    public function testTokenD()
    {
        $this->assertSame($this->automaton, $this->automaton->read([Automaton::TOKEN_D]));
        $this->assertSame(Automaton::STATE_E, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(500, $this->automaton->getValue());
    }

    /**
     * Test Invalid Transition
     */
    public function testInvalidTransition()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->automaton->read([Automaton::TOKEN_D, Automaton::TOKEN_M]);
    }

    /**
     * Test Token C
     */
    public function testTokenC()
    {
        $this->assertSame($this->automaton, $this->automaton->read([Automaton::TOKEN_C]));
        $this->assertSame(Automaton::STATE_D, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(100, $this->automaton->getValue());

        $this->assertSame($this->automaton, $this->automaton->read([Automaton::TOKEN_C, Automaton::TOKEN_C]));
        $this->assertSame(Automaton::STATE_D, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(200, $this->automaton->getValue());

        $this->assertSame($this->automaton, $this->automaton->read([
            Automaton::TOKEN_C,
            Automaton::TOKEN_C,
            Automaton::TOKEN_C,
        ]));
        $this->assertSame(Automaton::STATE_D, $this->automaton->getState());
        $this->assertSame(3, $this->automaton->getPosition());
        $this->assertSame(300, $this->automaton->getValue());
    }

    /**
     * Test Invalid Four Tokens C
     */
    public function testInvalidFourTokensC()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->automaton->read([Automaton::TOKEN_C, Automaton::TOKEN_C, Automaton::TOKEN_C, Automaton::TOKEN_C]);
    }
}
