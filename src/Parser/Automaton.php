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
     * Value
     * @type int
     */
    private $value = 0;

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
     * Set Value
     *
     * @param  int  $value Value
     * @return self Fluent Interface
     */
    protected function setValue(int $value) : self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get Value
     *
     * @return int Value
     */
    public function getValue() : int
    {
        return $this->value;
    }

    /**
     * Read
     *
     * @param  string[] $tokens Tokens
     * @return self     Fluent Interface
     */
    public function read(array $tokens) : self
    {
        $length   = count($tokens);
        $position = 0;

        while ($position < $length) {
            if ($tokens[$position] === self::TOKEN_M) {
                $position = $position + 1;

                $this
                    ->setValue($this->getValue() + 1000)
                    ->setState(self::STATE_G);
            } elseif ($tokens[$position] === self::TOKEN_N) {
                $position = $position + 1;

                $this
                    ->setValue($this->getValue() + 0)
                    ->setState(self::STATE_Z);
            }
        }

        return $this;
    }
}
