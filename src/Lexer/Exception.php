<?php
declare(strict_types=1);

namespace Romans\Lexer;

use Exception as BaseException;
use InvalidArgumentException;

/**
 * Lexer Exception
 */
class Exception extends BaseException
{
    const UNKNOWN_TOKEN = 1;

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
     * @param  $token Token Value
     * @return Fluent Interface
     */
    public function setToken(?string $token) : self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Get Token
     *
     * @return Token Value
     */
    public function getToken() : ?string
    {
        return $this->token;
    }

    /**
     * Set Position
     *
     * @param  $position Position Value
     * @return Fluent Interface
     */
    public function setPosition(?int $position) : self
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Get Position
     *
     * @return Position Value
     */
    public function getPosition() : ?int
    {
        return $this->position;
    }
}
