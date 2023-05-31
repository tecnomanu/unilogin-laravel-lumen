<?php

namespace Tecnomanu\UniLogin\Contracts\Repositories;

use App\Models\User;

/**
 * UserRepositoryContract
 * 
 * Defines the contract that the user repository  must adhere to.
 */
interface UserRepositoryContract
{
    /**
     * Find a user by email.
     *
     * @param  string  $email
     * @return User|null
     */
    public function findByEmail(string $email);
}
