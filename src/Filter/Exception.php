<?php

declare(strict_types=1);

namespace Romans\Filter;

use Exception as BaseException;

/**
 * Filter Exception
 */
class Exception extends BaseException
{
    const INVALID_INTEGER = 1<<0;
}
