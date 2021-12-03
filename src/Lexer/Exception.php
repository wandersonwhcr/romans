<?php

declare(strict_types=1);

namespace Romans\Lexer;

use Exception as BaseException;

/**
 * Lexer Exception
 */
class Exception extends BaseException
{
    const UNKNOWN_TOKEN = 1<<0;

    /**
     * Token
     */
    private ?string $token = null;

    /**
     * Position
     */
    private ?int $position = null;

    /**
     * Set Token
     *
     * @param  string|null $token Token Value
     * @return self        Fluent Interface
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Get Token
     *
     * @return string|null Token Value
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Set Position
     *
     * @param  int|null $position Position Value
     * @return self     Fluent Interface
     */
    public function setPosition(?int $position): self
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Get Position
     *
     * @return int|null Position Value
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }
}
