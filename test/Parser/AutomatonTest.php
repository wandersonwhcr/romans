<?php

namespace RomansTest\Parser;

use PHPUnit\Framework\TestCase;
use Romans\Parser\Automaton;

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
}
