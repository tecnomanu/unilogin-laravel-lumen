<?php

namespace Tecnomanu\UniLogin\Contracts\Services;

use Tecnomanu\UniLogin\Models\Session;

/**
 * SessionContract
 * 
 * Defines the contract that the Session repository must adhere to.
 */
interface SessionServiceContract
{
    /**
     * Create a new Session.
     *
     * @param array $data
     * @return Session
     */
    public function create(string $email, string $token): array;


    /**
     * Update the status of a Session.
     *
     * @param string $token
     * @param string $status
     * @return void
     */
    public function updateStatus(string $token, string $status): void;

    /**
     * Find a Session by its token.
     *
     * @param string $token
     * @return Session|null
     */
    public function find(string $sessionId, string $toke): ?array;
}
