<?php

namespace Romans\Parser;

use Romans\Grammar\Grammar;

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

    /**
     * State
     * @type string
     */
    private $state;

    /**
     * Position
     * @type int
     */
    private $position;

    /**
     * Value
     * @type int
     */
    private $value;

    /**
     * Default Constructor
     */
    public function __construct()
    {
        $this->reset();
    }

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
     * Add Position
     *
     * @param  int  $offset Offset Value
     * @return self Fluent Interface
     */
    protected function addPosition(int $offset) : self
    {
        $this->setPosition($this->getPosition() + $offset);
        return $this;
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
     * Add Value
     *
     * @param  int  $offset Offset Value
     * @return self Fluent Interface
     */
    protected function addValue(int $offset) : self
    {
        $this->setValue($this->getValue() + $offset);
        return $this;
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
                    if ($token === Grammar::T_N) {
                        $this
                            ->setState(self::STATE_Z)
                            ->addPosition(1);
                    } elseif ($token === Grammar::T_M) {
                        $this
                            ->setState(self::STATE_G)
                            ->addPosition(1)
                            ->addValue(1000);
                    } else {
                        $this->setState(self::STATE_F);
                    }
                    break;

                case self::STATE_F:
                    if ($token === Grammar::T_D) {
                        $this
                            ->setState(self::STATE_E)
                            ->addPosition(1)
                            ->addValue(500);
                    } elseif ($token === Grammar::T_C && $this->getPosition() + 1 < $length) {
                        if ($tokens[$this->getPosition() + 1] === Grammar::T_D) {
                            $this
                                ->setState(self::STATE_D)
                                ->addPosition(2)
                                ->addValue(400);
                        } elseif ($tokens[$this->getPosition() + 1] === Grammar::T_M) {
                            $this
                                ->setState(self::STATE_D)
                                ->addPosition(2)
                                ->addValue(900);
                        } else {
                            $this->setState(self::STATE_E);
                        }
                    } else {
                        $this->setState(self::STATE_E);
                    }
                    break;

                case self::STATE_E:
                    if ($token === Grammar::T_C) {
                        if ($this->getPosition() + 1 < $length
                            && $tokens[$this->getPosition() + 1] === Grammar::T_C) {
                            if ($this->getPosition() + 2 < $length
                                && $tokens[$this->getPosition() + 2] === Grammar::T_C) {
                                $this
                                    ->setState(self::STATE_D)
                                    ->addPosition(3)
                                    ->addValue(300);
                            } else {
                                $this
                                    ->setState(self::STATE_D)
                                    ->addPosition(2)
                                    ->addValue(200);
                            }
                        } else {
                            $this
                                ->setState(self::STATE_D)
                                ->addPosition(1)
                                ->addValue(100);
                        }
                    } else {
                        $this->setState(self::STATE_D);
                    }
                    break;

                case self::STATE_D:
                    if ($token === Grammar::T_L) {
                        $this
                            ->setState(self::STATE_C)
                            ->addPosition(1)
                            ->addValue(50);
                    } elseif ($token === Grammar::T_X && $this->getPosition() + 1 < $length) {
                        if ($tokens[$this->getPosition() + 1] === Grammar::T_L) {
                            $this
                                ->setState(self::STATE_B)
                                ->addPosition(2)
                                ->addValue(40);
                        } elseif ($tokens[$this->getPosition() + 1] === Grammar::T_C) {
                            $this
                                ->setState(self::STATE_B)
                                ->addPosition(2)
                                ->addValue(90);
                        } else {
                            $this->setState(self::STATE_C);
                        }
                    } else {
                        $this->setState(self::STATE_C);
                    }
                    break;

                case self::STATE_C:
                    if ($token === Grammar::T_X) {
                        if ($this->getPosition() + 1 < $length
                            && $tokens[$this->getPosition() + 1] === Grammar::T_X) {
                            if ($this->getPosition() + 2 < $length
                                && $tokens[$this->getPosition() + 2] === Grammar::T_X) {
                                $this
                                    ->setState(self::STATE_B)
                                    ->addPosition(3)
                                    ->addValue(30);
                            } else {
                                $this
                                    ->setState(self::STATE_B)
                                    ->addPosition(2)
                                    ->addValue(20);
                            }
                        } else {
                            $this
                                ->setState(self::STATE_B)
                                ->addPosition(1)
                                ->addValue(10);
                        }
                    } else {
                        $this->setState(self::STATE_B);
                    }
                    break;

                case self::STATE_B:
                    if ($token === Grammar::T_V) {
                        $this
                            ->setState(self::STATE_A)
                            ->addPosition(1)
                            ->addValue(5);
                    } elseif ($token === Grammar::T_I && $this->getPosition() + 1 < $length) {
                        if ($tokens[$this->getPosition() + 1] === Grammar::T_V) {
                            $this
                                ->setState(self::STATE_Z)
                                ->addPosition(2)
                                ->addValue(4);
                        } elseif ($tokens[$this->getPosition() + 1] === Grammar::T_X) {
                            $this
                                ->setState(self::STATE_Z)
                                ->addPosition(2)
                                ->addValue(9);
                        } else {
                            $this->setState(self::STATE_A);
                        }
                    } else {
                        $this->setState(self::STATE_A);
                    }
                    break;

                case self::STATE_A:
                    if ($token === Grammar::T_I) {
                        if ($this->getPosition() + 1 < $length
                            && $tokens[$this->getPosition() + 1] === Grammar::T_I) {
                            if ($this->getPosition() + 2 < $length
                                && $tokens[$this->getPosition() + 2] === Grammar::T_I) {
                                $this
                                    ->setState(self::STATE_Z)
                                    ->addPosition(3)
                                    ->addValue(3);
                            } else {
                                $this
                                    ->setState(self::STATE_Z)
                                    ->addPosition(2)
                                    ->addValue(2);
                            }
                        } else {
                            $this
                                ->setState(self::STATE_Z)
                                ->addPosition(1)
                                ->addValue(1);
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
