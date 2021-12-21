<?php

declare(strict_types=1);

namespace Romans\Parser;

use Romans\Grammar\Grammar;
use Romans\Grammar\GrammarAwareTrait;

/**
 * Automaton
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Automaton
{
    use GrammarAwareTrait;

    const STATE_A = 'A';
    const STATE_B = 'B';
    const STATE_C = 'C';
    const STATE_D = 'D';
    const STATE_E = 'E';
    const STATE_F = 'F';
    const STATE_G = 'G';
    const STATE_Y = 'Y';
    const STATE_Z = 'Z';

    /**
     * State
     */
    private string $state;

    /**
     * Position
     */
    private int $position;

    /**
     * Value
     */
    private int $value;

    /**
     * Tokens
     * @var string[]
     */
    private array $tokens;

    /**
     * Default Constructor
     *
     * @param Grammar $grammar Grammar Object
     */
    public function __construct(?Grammar $grammar = null)
    {
        $this
            ->setGrammar($grammar ?? new Grammar())
            ->reset();
    }

    /**
     * Set State
     *
     * @param  string $state State Value
     * @return self   Fluent Interface
     */
    protected function setState(string $state): self
    {
        $this->state = $state;
        return $this;
    }

    /**
     * Get State
     *
     * @return string State Value
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Set Position
     *
     * @param  int  $value Position Value
     * @return self Fluent Interface
     */
    protected function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Get Position
     *
     * @return int Position Value
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * Add Position
     *
     * @param  int  $offset Offset Value
     * @return self Fluent Interface
     */
    protected function addPosition(int $offset): self
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
    protected function setValue(int $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get Value
     *
     * @return int Value
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Add Value
     *
     * @param  int  $offset Offset Value
     * @return self Fluent Interface
     */
    protected function addValue(int $offset): self
    {
        $this->setValue($this->getValue() + $offset);
        return $this;
    }

    /**
     * Add Token Value
     *
     * @param  string $token    Token
     * @param  string $modifier Modifier Token
     * @param  int    $quantity Quantity
     * @return self   Fluent Interface
     */
    protected function addTokenValue(string $token, ?string $modifier = null, int $quantity = 1): self
    {
        $tokens   = array_flip($this->getGrammar()->getTokens());
        $values   = $this->getGrammar()->getValuesWithModifiers();
        $elements = [];

        if (isset($modifier)) {
            $elements[] = $tokens[$modifier];
        }

        $elements[] = $tokens[$token];

        $this->addValue((array_search($elements, $values)) * $quantity);

        return $this;
    }

    /**
     * Set Tokens
     *
     * @param  string[] $tokens Token Values
     * @return self     Fluent Interface
     */
    protected function setTokens(array $tokens): self
    {
        $this->tokens = $tokens;
        return $this;
    }

    /**
     * Get Tokens
     *
     * @return string[] Token Values
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * Get Token
     *
     * @param  int    $offset Position Offset
     * @return string Token
     */
    protected function getToken(int $offset = 0): string
    {
        return $this->getTokens()[$this->getPosition() + $offset];
    }

    /**
     * Has Token?
     *
     * @param  int  $offset Position Offset
     * @return bool Confirmation
     */
    protected function hasToken(int $offset = 0): bool
    {
        return ($this->getPosition() + $offset) < count($this->getTokens());
    }

    /**
     * Reset Counters
     *
     * @return self Fluent Interface
     */
    protected function reset(): self
    {
        $this
            ->setState(self::STATE_G)
            ->setPosition(0)
            ->setValue(0);

        return $this;
    }

    /**
     * Do Transition from Y
     *
     * @return self Fluent Interface
     */
    private function doTransitionFromY(): self
    {
        if ($this->getToken() !== '$') {
            throw (new Exception('Invalid Roman', Exception::INVALID_ROMAN))
                ->setPosition($this->getPosition())
                ->setToken($this->getToken());
        }

        // done!
        $this->setState(self::STATE_Z);
        return $this;
    }

    /**
     * Do Transition from G
     *
     * @return self Fluent Interface
     */
    private function doTransitionFromG(): self
    {
        if ($this->getToken() === Grammar::T_N) {
            $this
                ->setState(self::STATE_Y)
                ->addPosition(1);
            return $this;
        }

        if ($this->getToken() === Grammar::T_M) {
            $this
                ->setState(self::STATE_G)
                ->addPosition(1)
                ->addTokenValue(Grammar::T_M);
            return $this;
        }

        $this->setState(self::STATE_F);
        return $this;
    }

    /**
     * Do Transition from F
     *
     * @return self Fluent Interface
     */
    private function doTransitionFromF(): self
    {
        if ($this->getToken() === Grammar::T_D) {
            $this
                ->setState(self::STATE_E)
                ->addPosition(1)
                ->addTokenValue(Grammar::T_D);
            return $this;
        }

        if ($this->getToken() === Grammar::T_C && $this->hasToken(1) && $this->getToken(1) === Grammar::T_D) {
            $this
                ->setState(self::STATE_D)
                ->addPosition(2)
                ->addTokenValue(Grammar::T_D, Grammar::T_C);
            return $this;
        }

        if ($this->getToken() === Grammar::T_C && $this->hasToken(1) && $this->getToken(1) === Grammar::T_M) {
            $this
                ->setState(self::STATE_D)
                ->addPosition(2)
                ->addTokenValue(Grammar::T_M, Grammar::T_C);
            return $this;
        }

        $this->setState(self::STATE_E);
        return $this;
    }

    /**
     * Do Transition from E
     *
     * @return self Fluent Interface
     */
    private function doTransitionFromE(): self
    {
        if ($this->getToken() === Grammar::T_C) {
            if ($this->hasToken(1) && $this->getToken(1) === Grammar::T_C) {
                if ($this->hasToken(2) && $this->getToken(2) === Grammar::T_C) {
                    $this
                        ->setState(self::STATE_D)
                        ->addPosition(3)
                        ->addTokenValue(Grammar::T_C, quantity: 3);
                    return $this;
                }

                $this
                    ->setState(self::STATE_D)
                    ->addPosition(2)
                    ->addTokenValue(Grammar::T_C, quantity: 2);
                return $this;
            }

            $this
                ->setState(self::STATE_D)
                ->addPosition(1)
                ->addTokenValue(Grammar::T_C);
            return $this;
        }

        $this->setState(self::STATE_D);
        return $this;
    }

    /**
     * Do Transition from D
     *
     * @return self Fluent Interface
     */
    private function doTransitionFromD(): self
    {
        if ($this->getToken() === Grammar::T_L) {
            $this
                ->setState(self::STATE_C)
                ->addPosition(1)
                ->addTokenValue(Grammar::T_L);
            return $this;
        }

        if ($this->getToken() === Grammar::T_X && $this->hasToken(1) && $this->getToken(1) === Grammar::T_L) {
            $this
                ->setState(self::STATE_B)
                ->addPosition(2)
                ->addTokenValue(Grammar::T_L, Grammar::T_X);
            return $this;
        }

        if ($this->getToken() === Grammar::T_X && $this->hasToken(1) && $this->getToken(1) === Grammar::T_C) {
            $this
                ->setState(self::STATE_B)
                ->addPosition(2)
                ->addTokenValue(Grammar::T_C, Grammar::T_X);
            return $this;
        }

        $this->setState(self::STATE_C);
        return $this;
    }

    /**
     * Do Transition from C
     *
     * @return self Fluent Interface
     */
    private function doTransitionFromC(): self
    {
        if ($this->getToken() === Grammar::T_X) {
            if ($this->hasToken(1) && $this->getToken(1) === Grammar::T_X) {
                if ($this->hasToken(2) && $this->getToken(2) === Grammar::T_X) {
                    $this
                        ->setState(self::STATE_B)
                        ->addPosition(3)
                        ->addTokenValue(Grammar::T_X, quantity: 3);
                    return $this;
                }

                $this
                    ->setState(self::STATE_B)
                    ->addPosition(2)
                    ->addTokenValue(Grammar::T_X, quantity: 2);
                return $this;
            }

            $this
                ->setState(self::STATE_B)
                ->addPosition(1)
                ->addTokenValue(Grammar::T_X);
            return $this;
        }

        $this->setState(self::STATE_B);
        return $this;
    }

    /**
     * Do Transition from B
     *
     * @return self Fluent Interface
     */
    private function doTransitionFromB(): self
    {
        if ($this->getToken() === Grammar::T_V) {
            $this
                ->setState(self::STATE_A)
                ->addPosition(1)
                ->addTokenValue(Grammar::T_V);
            return $this;
        }

        if ($this->getToken() === Grammar::T_I && $this->hasToken(1) && $this->getToken(1) === Grammar::T_V) {
            $this
                ->setState(self::STATE_Y)
                ->addPosition(2)
                ->addTokenValue(Grammar::T_V, Grammar::T_I);
            return $this;
        }

        if ($this->getToken() === Grammar::T_I && $this->hasToken(1) && $this->getToken(1) === Grammar::T_X) {
            $this
                ->setState(self::STATE_Y)
                ->addPosition(2)
                ->addTokenValue(Grammar::T_X, Grammar::T_I);
            return $this;
        }

        $this->setState(self::STATE_A);
        return $this;
    }

    /**
     * Do Transition From A
     *
     * @return self Fluent Interface
     */
    private function doTransitionFromA(): self
    {
        if ($this->getToken() === Grammar::T_I) {
            if ($this->hasToken(1) && $this->getToken(1) === Grammar::T_I) {
                if ($this->hasToken(2) && $this->getToken(2) === Grammar::T_I) {
                    $this
                        ->setState(self::STATE_Y)
                        ->addPosition(3)
                        ->addTokenValue(Grammar::T_I, quantity: 3);
                    return $this;
                }

                $this
                    ->setState(self::STATE_Y)
                    ->addPosition(2)
                    ->addTokenValue(Grammar::T_I, quantity: 2);
                return $this;
            }

            $this
                ->setState(self::STATE_Y)
                ->addPosition(1)
                ->addTokenValue(Grammar::T_I);
            return $this;
        }

        $this->setState(self::STATE_Y);
        return $this;
    }

    /**
     * Do Transition
     *
     * @return self Fluent Interface
     */
    private function doTransition(): self
    {
        match ($this->getState()) {
            self::STATE_G => $this->doTransitionFromG(),
            self::STATE_F => $this->doTransitionFromF(),
            self::STATE_E => $this->doTransitionFromE(),
            self::STATE_D => $this->doTransitionFromD(),
            self::STATE_C => $this->doTransitionFromC(),
            self::STATE_B => $this->doTransitionFromB(),
            self::STATE_A => $this->doTransitionFromA(),
            self::STATE_Y => $this->doTransitionFromY(),
        };

        return $this;
    }

    /**
     * Read
     *
     * @param  string[] $tokens Tokens
     * @return self     Fluent Interface
     */
    public function read(array $tokens): self
    {
        array_push($tokens, '$');

        $this
            ->setTokens($tokens)
            ->reset();

        while ($this->getState() !== self::STATE_Z) {
            $this->doTransition();
        }

        return $this;
    }
}
