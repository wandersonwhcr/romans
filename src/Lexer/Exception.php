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
     * Position
     * @type int|null
     */
    private $position;

    /**
     * Set Position
     *
     * @param  int|null  $position Position Value
     * @return self Fluent Interface
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
