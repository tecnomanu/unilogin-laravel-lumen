<?php

namespace Tecnomanu\UniLogin\Support;

use Illuminate\Support\Facades\Facade;

class UniLogin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'unilogin';
    }
}
