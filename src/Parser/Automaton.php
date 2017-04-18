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

            switch ($state) {
                case self::STATE_G:
                    if ($token === self::TOKEN_N) {
                        $this
                            ->setState(self::STATE_Z)
                            ->setPosition($this->getPosition() + 1);
                    } elseif ($token === self::TOKEN_M) {
                        $this
                            ->setState(self::STATE_G)
                            ->setPosition($this->getPosition() + 1)
                            ->setValue($this->getValue() + 1000);
                    } else {
                        $this->setState(self::STATE_F);
                    }
                    break;

                case self::STATE_F:
                    if ($token === self::TOKEN_D) {
                        $this
                            ->setState(self::STATE_E)
                            ->setPosition($this->getPosition() + 1)
                            ->setValue($this->getValue() + 500);
                    } elseif ($token === self::TOKEN_C && $this->getPosition() + 1 < $length) {
                        if ($tokens[$this->getPosition() + 1] === self::TOKEN_D) {
                            $this
                                ->setState(self::STATE_D)
                                ->setPosition($this->getPosition() + 2)
                                ->setValue($this->getValue() + 400);
                        } elseif ($tokens[$this->getPosition() + 1] === self::TOKEN_M) {
                            $this
                                ->setState(self::STATE_D)
                                ->setPosition($this->getPosition() + 2)
                                ->setValue($this->getValue() + 900);
                        } else {
                            $this->setState(self::STATE_E);
                        }
                    } else {
                        $this->setState(self::STATE_E);
                    }
                    break;

                case self::STATE_E:
                    if ($token === self::TOKEN_C) {
                        if ($this->getPosition() + 1 < $length
                            && $tokens[$this->getPosition() + 1] === self::TOKEN_C) {
                            if ($this->getPosition() + 2 < $length
                                && $tokens[$this->getPosition() + 2] === self::TOKEN_C) {
                                $this
                                    ->setState(self::STATE_D)
                                    ->setPosition($this->getPosition() + 3)
                                    ->setValue($this->getValue() + 300);
                            } else {
                                $this
                                    ->setState(self::STATE_D)
                                    ->setPosition($this->getPosition() + 2)
                                    ->setValue($this->getValue() + 200);
                            }
                        } else {
                            $this
                                ->setState(self::STATE_D)
                                ->setPosition($this->getPosition() + 1)
                                ->setValue($this->getValue() + 100);
                        }
                    } else {
                        $this->setState(self::STATE_D);
                    }
                    break;

                case self::STATE_D:
                    if ($token === self::TOKEN_L) {
                        $this
                            ->setState(self::STATE_C)
                            ->setPosition($this->getPosition() + 1)
                            ->setValue($this->getValue() + 50);
                    } elseif ($token === self::TOKEN_X && $this->getPosition() + 1 < $length) {
                        if ($tokens[$this->getPosition() + 1] === self::TOKEN_L) {
                            $this
                                ->setState(self::STATE_B)
                                ->setPosition($this->getPosition() + 2)
                                ->setValue($this->getValue() + 40);
                        } elseif ($tokens[$this->getPosition() + 1] === self::TOKEN_C) {
                            $this
                                ->setState(self::STATE_B)
                                ->setPosition($this->getPosition() + 2)
                                ->setValue($this->getValue() + 90);
                        } else {
                            $this->setState(self::STATE_C);
                        }
                    } else {
                        $this->setState(self::STATE_C);
                    }
                    break;

                case self::STATE_C:
                    if ($token === self::TOKEN_X) {
                        if ($this->getPosition() + 1 < $length
                            && $tokens[$this->getPosition() + 1] === self::TOKEN_X) {
                            if ($this->getPosition() + 2 < $length
                                && $tokens[$this->getPosition() + 2] === self::TOKEN_X) {
                                $this
                                    ->setState(self::STATE_B)
                                    ->setPosition($this->getPosition() + 3)
                                    ->setValue($this->getValue() + 30);
                            } else {
                                $this
                                    ->setState(self::STATE_B)
                                    ->setPosition($this->getPosition() + 2)
                                    ->setValue($this->getValue() + 20);
                            }
                        } else {
                            $this
                                ->setState(self::STATE_B)
                                ->setPosition($this->getPosition() + 1)
                                ->setValue($this->getValue() + 10);
                        }
                    } else {
                        $this->setState(self::STATE_B);
                    }
                    break;

                case self::STATE_B:
                    if ($token === self::TOKEN_V) {
                        $this
                            ->setState(self::STATE_A)
                            ->setPosition($this->getPosition() + 1)
                            ->setValue($this->getValue() + 5);
                    } elseif ($token === self::TOKEN_I && $this->getPosition() + 1 < $length) {
                        if ($tokens[$this->getPosition() + 1] === self::TOKEN_V) {
                            $this
                                ->setState(self::STATE_Z)
                                ->setPosition($this->getPosition() + 2)
                                ->setValue($this->getValue() + 4);
                        } elseif ($tokens[$this->getPosition() + 1] === self::TOKEN_X) {
                            $this
                                ->setState(self::STATE_Z)
                                ->setPosition($this->getPosition() + 2)
                                ->setValue($this->getValue() + 9);
                        } else {
                            $this->setState(self::STATE_A);
                        }
                    } else {
                        $this->setState(self::STATE_A);
                    }
                    break;

                case self::STATE_A:
                    if ($token === self::TOKEN_I) {
                        if ($this->getPosition() + 1 < $length
                            && $tokens[$this->getPosition() + 1] === self::TOKEN_I) {
                            if ($this->getPosition() + 2 < $length
                                && $tokens[$this->getPosition() + 2] === self::TOKEN_I) {
                                $this
                                    ->setState(self::STATE_Z)
                                    ->setPosition($this->getPosition() + 3)
                                    ->setValue($this->getValue() + 3);
                            } else {
                                $this
                                    ->setState(self::STATE_Z)
                                    ->setPosition($this->getPosition() + 2)
                                    ->setValue($this->getValue() + 2);
                            }
                        } else {
                            $this
                                ->setState(self::STATE_Z)
                                ->setPosition($this->getPosition() + 1)
                                ->setValue($this->getValue() + 1);
                        }
                    } else {
                        $this->setState(self::STATE_Z);
                    }
                    break;

                default:
                    throw (new Exception('Invalid Roman', Exception::INVALID_ROMAN))
                        ->setPosition($this->getPosition())
                        ->setToken($token);
            }
        }

        return $this;
    }
}
