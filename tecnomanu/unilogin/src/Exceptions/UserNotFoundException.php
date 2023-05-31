<?php

namespace Tecnomanu\UniLogin\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    /**
     * The message to use for the response.
     *
     * @var string
     */
    protected $message = 'User not found.';

    /**
     * The status code to use for the response.
     *
     * @var int
     */
    protected $code = 404;
}
