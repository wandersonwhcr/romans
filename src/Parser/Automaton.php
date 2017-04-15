<?php

namespace Romans\Parser;

/**
 * Automaton
 */
class Automaton
{
    const STATE_Z = 'Z';
    const STATE_A = 'A';
    const STATE_B = 'B';
    const STATE_C = 'C';
    const STATE_D = 'D';
    const STATE_E = 'E';
    const STATE_F = 'F';
    const STATE_G = 'G';

    const TOKEN_N = 'N';
    const TOKEN_I = 'I';
    const TOKEN_V = 'V';
    const TOKEN_X = 'X';
    const TOKEN_L = 'L';
    const TOKEN_C = 'C';
    const TOKEN_D = 'D';
    const TOKEN_M = 'M';

    /**
     * State
     * @type string
     */
    private $state = self::STATE_G;

    /**
     * Set State
     *
     * @param  string $state State Value
     * @return self   Fluent Interface
     */
    protected function setState(string $state) : self
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get State
     *
     * @return string State Value
     */
    public function getState() : string
    {
        return $this->state;
    }

    /**
     * Read
     *
     * @param  string[] $tokens Tokens
     * @return self     Fluent Interface
     */
    public function read(array $tokens) : self
    {
        $this->setState(self::STATE_Z);

        return $this;
    }
}
