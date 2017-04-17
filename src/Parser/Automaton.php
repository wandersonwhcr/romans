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
     * Position
     * @type int
     */
    private $position = 0;

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
     * Set Position
     *
     * @param  int  $value Position Value
     * @return self Fluent Interface
     */
    protected function setPosition(int $position) : self
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Get Position
     *
     * @return int Position Value
     */
    public function getPosition() : int
    {
        return $this->position;
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
     * Reset Counters
     *
     * @return self Fluent Interface
     */
    protected function reset() : self
    {
        $this
            ->setState(self::STATE_G)
            ->setPosition(0)
            ->setValue(0);

        return $this;
    }

    /**
     * Read
     *
     * @param  string[] $tokens Tokens
     * @return self     Fluent Interface
     */
    public function read(array $tokens) : self
    {
        $this->reset();

        $length = count($tokens);

        while ($this->getPosition() < $length) {
            $state = $this->getState();
            $token = $tokens[$this->getPosition()];

            if ($state === self::STATE_G && $token === self::TOKEN_N) {
                $this
                    ->setState(self::STATE_Z)
                    ->setPosition($this->getPosition() + 1)
                    ->setValue($this->getValue() + 0);
            } elseif ($state === self::STATE_G && $token === self::TOKEN_M) {
                $this
                    ->setState(self::STATE_G)
                    ->setPosition($this->getPosition() + 1)
                    ->setValue($this->getValue() + 1000);
            } elseif ($state === self::STATE_G) {
                $this
                    ->setState(self::STATE_F);
            } elseif ($state === self::STATE_F && $token === self::TOKEN_D) {
                $this
                    ->setState(self::STATE_E)
                    ->setPosition($this->getPosition() + 1)
                    ->setValue($this->getValue() + 500);
            } elseif ($state === self::STATE_F) {
                $this
                    ->setState(self::STATE_E);
            } elseif ($state === self::STATE_E && $token === self::TOKEN_C) {
                $this
                    ->setPosition($this->getPosition() + 1)
                    ->setValue($this->getValue() + 100);

                // lookahead +1
                if ($this->getPosition() < $length) {
                    $token = $tokens[$this->getPosition()];
                    if ($token === self::TOKEN_C) {
                        $this
                            ->setPosition($this->getPosition() + 1)
                            ->setValue($this->getValue() + 100);
                    }

                    // lookahed +2
                    if ($this->getPosition() < $length) {
                        $token = $tokens[$this->getPosition()];
                        if ($token === self::TOKEN_C) {
                            $this
                                ->setPosition($this->getPosition() + 1)
                                ->setValue($this->getValue() + 100);
                        }
                    }
                }

                $this
                    ->setState(self::STATE_D);
            } elseif ($state === self::STATE_E) {
                $this
                    ->setState(self::STATE_D);
            } elseif ($state === self::STATE_D && $token === self::TOKEN_L) {
                $this
                    ->setState(self::STATE_C)
                    ->setPosition($this->getPosition() + 1)
                    ->setValue($this->getValue() + 50);
            } elseif ($state === self::STATE_D) {
                $this
                    ->setState(self::STATE_C);
            } elseif ($state === self::STATE_C && $token === self::TOKEN_X) {
                $this
                    ->setPosition($this->getPosition() + 1)
                    ->setValue($this->getValue() + 10);

                // lookahead +1
                if ($this->getPosition() < $length) {
                    $token = $tokens[$this->getPosition()];
                    if ($token === self::TOKEN_X) {
                        $this
                            ->setPosition($this->getPosition() + 1)
                            ->setValue($this->getValue() + 10);
                    }

                    // lookahed +2
                    if ($this->getPosition() < $length) {
                        $token = $tokens[$this->getPosition()];
                        if ($token === self::TOKEN_X) {
                            $this
                                ->setPosition($this->getPosition() + 1)
                                ->setValue($this->getValue() + 10);
                        }
                    }
                }

                $this
                    ->setState(self::STATE_B);
            } elseif ($state === self::STATE_C) {
                $this
                    ->setState(self::STATE_B);
            } elseif ($state === self::STATE_B && $token === self::TOKEN_V) {
                $this
                    ->setState(self::STATE_A)
                    ->setPosition($this->getPosition() + 1)
                    ->setValue($this->getValue() + 5);
            } elseif ($state === self::STATE_B) {
                $this
                    ->setState(self::STATE_A);
            } elseif ($state === self::STATE_A && $token === self::TOKEN_I) {
                $this
                    ->setPosition($this->getPosition() + 1)
                    ->setValue($this->getValue() + 1);

                // lookahead +1
                if ($this->getPosition() < $length) {
                    $token = $tokens[$this->getPosition()];
                    if ($token === self::TOKEN_I) {
                        $this
                            ->setPosition($this->getPosition() + 1)
                            ->setValue($this->getValue() + 1);
                    }

                    // lookahed +2
                    if ($this->getPosition() < $length) {
                        $token = $tokens[$this->getPosition()];
                        if ($token === self::TOKEN_I) {
                            $this
                                ->setPosition($this->getPosition() + 1)
                                ->setValue($this->getValue() + 1);
                        }
                    }
                }

                $this
                    ->setState(self::STATE_Z);
            } else {
                $exception = new Exception('Invalid Roman', Exception::INVALID_ROMAN);

                $exception
                    ->setToken($token)
                    ->setPosition($this->getPosition());

                throw $exception;
            }
        }

        return $this;
    }
}
