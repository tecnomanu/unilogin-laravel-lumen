<?php

namespace Tecnomanu\UniLogin\Contracts\Repositories;

use Tecnomanu\UniLogin\Models\MagicLink;

/**
 * MagicLinkContract
 * 
 * Defines the contract that the MagicLink repository must adhere to.
 */
interface MagicLinkRepositoryContract
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
    public function findByToken(string $token): ?array;

    /**
     * Update the status of a MagicLink.
     *
     * @param string $token
     * @param string $status
     * @return void
     */
    public function updateStatus(string $token, string $status): void;

    /**
     * Remove a MagicLink.
     *
     * @param string $token
     * @param string $status
     * @return void
     */
    public function  remove(string $token): void;
}

