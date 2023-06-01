<?php

namespace Tecnomanu\UniLogin\Contracts\Services;

use Tecnomanu\UniLogin\Models\MagicLink;

/**
 * MagicLinkContract
 * 
 * Defines the contract that the MagicLink repository must adhere to.
 */
interface MagicLinkServiceContract
{
    /**
     * Create a MagicLink.
     *
     * @param string $email
     * @return array
     */
    public function createMagicLink(string $email): array;

    /**
     * Find a MagicLink by its token.
     *
     * @param string $token
     * @return MagicLink|null
     */
    public function find(string $token): ?array;

    /**
     * Remove a MagicLink.
     *
     * @param string $token
     * @return void
     */
    public function  remove(string $token): void;

    /**
     * Update the status of a MagicLink.
     *
     * @param string $token
     * @param string $status
     * @return void
     */
    public function updateStatus(string $token, string $status);
}