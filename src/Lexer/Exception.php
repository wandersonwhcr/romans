<?php

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
     * @type string|null
     */
    private $token;

    /**
     * Position
     * @type int|null
     */
    private $position;

    /**
     * Set Token
     *
     * @param  string|null $token Token Value
     * @return self        Fluent Interface
     */
    public function setToken($token) : self
    {
        if (! (is_string($token) || is_null($token))) {
            throw new InvalidArgumentException(
                sprintf('Invalid $token type: "%s". Must be "string" or "null"', gettype($token))
            );
        }

        $this->token = $token;
        return $this;
    }

    /**
     * Get Token
     *
     * @return string|null Token Value
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set Position
     *
     * @param  int|null $position Position Value
     * @return self     Fluent Interface
     */
    public function setPosition($position) : self
    {
        if (! (is_int($position) || is_null($position))) {
            throw new InvalidArgumentException(
                sprintf('Invalid $position type: "%s". Must be "int" or "null"', gettype($position))
            );
        }

        $this->position = $position;
        return $this;
    }

    /**
     * Get Position
     *
     * @return int|null Position Value
     */
    public function getPosition()
    {
        return $this->position;
    }
}
