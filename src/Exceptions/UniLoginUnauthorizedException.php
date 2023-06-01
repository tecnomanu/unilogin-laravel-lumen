<?php

namespace Tecnomanu\UniLogin\Exceptions;

use Illuminate\Validation\UnauthorizedException;

class UniLoginUnauthorizedException extends UnauthorizedException
{
    /**
     * The message to use for the response.
     *
     * @var string
     */
    protected $message = 'Access Unauthorized.';

    /**
     * The status code to use for the response.
     *
     * @var int
     */
    protected $code = 401;
}
