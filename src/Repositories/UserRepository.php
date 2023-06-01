<?php

namespace Tecnomanu\UniLogin\Repositories;

use Tecnomanu\UniLogin\Contracts\Repositories\UserRepositoryContract;
use Tecnomanu\UniLogin\Support\UserResolver;

class UserRepository implements UserRepositoryContract
{
    protected $model;

    public function __construct()
    {
        $user = new UserResolver();
        $this->model = $user->resolve();
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
