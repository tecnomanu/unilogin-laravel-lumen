<?php

namespace Tecnomanu\UniLogin\Contracts\Repositories;

/**
 * MagicLinkContract
 * 
 * Defines the contract that the MagicLink repository must adhere to.
 */
interface SessionRepositoryContract
{
    /**
     * Create a new MagicLink.
     *
     * @param array $data
     * @return MagicLink
     */
    public function create(array $data): array;

    /**
     * Find a MagicLink by its token.
     *
     * @param string $token
     * @return MagicLink|null
     */
    public function findByToken(string $sessionId, string $token): ?array;

    /**
     * Update the status of a MagicLink.
     *
     * @param string $token
     * @param string $status
     * @return void
     */
    public function updateStatus(string $token, string $status): void;
}
