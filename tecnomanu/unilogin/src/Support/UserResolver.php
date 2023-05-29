<?php

namespace Tecnomanu\UniLogin\Support;

use Illuminate\Contracts\Auth\Authenticatable;

class UserResolver
{
    // /**
    //  * Invoke the UserResolver to get a new user model instance.
    //  *
    //  * @return Authenticatable
    //  */
    // public function __invoke(): Authenticatable
    // {
    //     $userModelClass = config('auth.providers.users.model');

    //     return new $userModelClass;
    // }

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
