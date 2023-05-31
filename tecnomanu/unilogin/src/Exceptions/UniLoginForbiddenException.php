<?php

namespace Tecnomanu\UniLogin\Exceptions;

use Illuminate\Validation\UnauthorizedException;

class UniLoginForbiddenException extends UnauthorizedException
{
    /**
     * The message to use for the response.
     *
     * @var string
     */
    protected $message = 'session Unauthorized.';

    /**
     * The status code to use for the response.
     *
     * @var int
     */
    protected $code = 403;
}
