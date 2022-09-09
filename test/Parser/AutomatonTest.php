<?php

declare(strict_types=1);

namespace RomansTest\Parser;

use PHPUnit\Framework\TestCase;
use Romans\Grammar\Grammar;
use Romans\Parser\Automaton;
use Romans\Parser\Exception as ParserException;

/**
 * Automaton Test
 */
class AutomatonTest extends TestCase
{
    /**
     * Automaton
     */
    private Automaton $automaton;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->automaton = new Automaton();
    }

    /**
     * Test States
     */
    public function testStates(): void
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
     * Test Initial State
     */
    public function testInitialState(): void
    {
        $this->assertSame(Automaton::STATE_G, $this->automaton->getState());
    }

    /**
     * Test Initial Position
     */
    public function testInitialPosition(): void
    {
        $this->assertSame(0, $this->automaton->getPosition());
    }

    /**
     * Test Initial Value
     */
    public function testInitialValue(): void
    {
        $this->assertSame(0, $this->automaton->getValue());
    }

    /**
     * Test Zero
     */
    public function testZero(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_N]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(0, $this->automaton->getValue());
    }

    /**
     * Test Token M
     */
    public function testTokenM(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_M]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(1000, $this->automaton->getValue());

        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_M, Grammar::T_M]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(2000, $this->automaton->getValue());
    }

    /**
     * Test Token D
     */
    public function testTokenD(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_D]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(500, $this->automaton->getValue());
    }

    /**
     * Test Invalid Transition
     */
    public function testInvalidTransition(): void
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->automaton->read([Grammar::T_D, Grammar::T_M]);
    }

    /**
     * Test Token C
     */
    public function testTokenC(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_C]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(100, $this->automaton->getValue());

        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_C, Grammar::T_C]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(200, $this->automaton->getValue());

        $this->assertSame($this->automaton, $this->automaton->read([
            Grammar::T_C,
            Grammar::T_C,
            Grammar::T_C,
        ]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(3, $this->automaton->getPosition());
        $this->assertSame(300, $this->automaton->getValue());
    }

    /**
     * Test Invalid Four Tokens C
     */
    public function testInvalidFourTokensC(): void
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->automaton->read([Grammar::T_C, Grammar::T_C, Grammar::T_C, Grammar::T_C]);
    }

    /**
     * Test Token L
     */
    public function testTokenL(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_L]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(50, $this->automaton->getValue());
    }

    /**
     * Test Token X
     */
    public function testTokenX(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_X]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(10, $this->automaton->getValue());

        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_X, Grammar::T_X]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(20, $this->automaton->getValue());

        $this->assertSame($this->automaton, $this->automaton->read([
            Grammar::T_X,
            Grammar::T_X,
            Grammar::T_X,
        ]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(3, $this->automaton->getPosition());
        $this->assertSame(30, $this->automaton->getValue());
    }

    /**
     * Test Invalid Four Tokens X
     */
    public function testInvalidFourTokensX(): void
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->automaton->read([Grammar::T_X, Grammar::T_X, Grammar::T_X, Grammar::T_X]);
    }

    /**
     * Test Token V
     */
    public function testTokenV(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_V]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(5, $this->automaton->getValue());
    }

    /**
     * Test Token I
     */
    public function testTokenI(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_I]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(1, $this->automaton->getPosition());
        $this->assertSame(1, $this->automaton->getValue());

        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_I, Grammar::T_I]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(2, $this->automaton->getValue());

        $this->assertSame($this->automaton, $this->automaton->read([
            Grammar::T_I,
            Grammar::T_I,
            Grammar::T_I,
        ]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(3, $this->automaton->getPosition());
        $this->assertSame(3, $this->automaton->getValue());
    }

    /**
     * Test Invalid Four Tokens I
     */
    public function testInvalidFourTokensI(): void
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessage('Invalid Roman');
        $this->expectExceptionCode(ParserException::INVALID_ROMAN);

        $this->automaton->read([Grammar::T_I, Grammar::T_I, Grammar::T_I, Grammar::T_I]);
    }

    /**
     * Test Token C followed by Token D
     */
    public function testTokenCfTokenD(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_C, Grammar::T_D]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(400, $this->automaton->getValue());
    }

    /**
     * Test Token C followed by Token M
     */
    public function testTokenCfTokenM(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_C, Grammar::T_M]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(900, $this->automaton->getValue());
    }

    /**
     * Test Token X followed by Token L
     */
    public function testTokenXfTokenL(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_X, Grammar::T_L]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(40, $this->automaton->getValue());
    }

    /**
     * Test Token X followed by Token C
     */
    public function testTokenXfTokenC(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_X, Grammar::T_C]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(90, $this->automaton->getValue());
    }

    /**
     * Test Token I followed by Token V
     */
    public function testTokenIfTokenV(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_I, Grammar::T_V]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(4, $this->automaton->getValue());
    }

    /**
     * Test Token I followed by Token X
     */
    public function testTokenIfTokenX(): void
    {
        $this->assertSame($this->automaton, $this->automaton->read([Grammar::T_I, Grammar::T_X]));
        $this->assertSame(Automaton::STATE_Z, $this->automaton->getState());
        $this->assertSame(2, $this->automaton->getPosition());
        $this->assertSame(9, $this->automaton->getValue());
    }
}
