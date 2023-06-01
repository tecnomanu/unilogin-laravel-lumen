<?php

namespace Tecnomanu\UniLogin\Exceptions;

use Firebase\JWT\ExpiredException;

class UniLoginExpiredException extends ExpiredException
{
    /**
     * The message to use for the response.
     *
     * @var string
     */
    protected $message = 'Token has expired';

    /**
     * The status code to use for the response.
     *
     * @var int
     */
    protected $code = 401;
}
