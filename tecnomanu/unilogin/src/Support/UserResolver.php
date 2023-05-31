<?php

namespace Tecnomanu\UniLogin\Support;

use Illuminate\Contracts\Auth\Authenticatable;

class UserResolver
{
    /**
     * Resolve the user model.
     *
     * @return Authenticatable
     */
    public function resolve(): Authenticatable
    {
        $userModelClass = config('auth.providers.users.model');

        return new $userModelClass;
    }
}
