<?php

namespace Romans\Parser;

use Exception as BaseException;

/**
 * Parser Exception
 */
class Exception extends BaseException
{
    const UNKNOWN_TOKEN      = 1;
    const INVALID_TOKEN_TYPE = 2;
    const INVALID_ROMAN      = 4;
}
