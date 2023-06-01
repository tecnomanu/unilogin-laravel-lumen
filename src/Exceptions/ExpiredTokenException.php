<?php

namespace Tecnomanu\UniLogin\Exceptions;

use Exception;

class ExpiredTokenException extends Exception
{
    /**
     * The message to use for the response.
     *
     * @var string
     */
    protected $message = 'The provided token has expired.';

    /**
     * The status code to use for the response.
     *
     * @var int
     */
    protected $code = 401;
}
