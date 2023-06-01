<?php

namespace Tecnomanu\UniLogin\Exceptions;

use Firebase\JWT\SignatureInvalidException;

class UniLoginSignatureInvalidException extends SignatureInvalidException
{
    /**
     * The message to use for the response.
     *
     * @var string
     */
    protected $message = 'Invalid token provided.';

    /**
     * The status code to use for the response.
     *
     * @var int
     */
    protected $code = 400;
}
