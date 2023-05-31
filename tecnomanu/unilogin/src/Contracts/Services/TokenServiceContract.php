<?php

namespace Tecnomanu\UniLogin\Contracts\Services;

/**
 * TokenServiceContract
 * 
 * Defines the contract that the token services  must adhere to.
 */
interface TokenServiceContract
{
    /**
     * Encodes data into a JWT.
     *
     * @param array $data
     * @param string $type
     * @param int|null $expiry
     * @return string
     */
    public function encode(array $data, 
    string $type, 
    ?int $expiry = null): string;

    /**
     * Decodes a JWT back into data.
     *
     * @param string $token
     * @return object
     * @throws \Exception If the token is invalid.
     */
    public function decode(string $token);

    /**
     * Generate Login Token a JWT back into data.
     *
     * @param string $token
     * @return object
     * @throws \Exception If the token is invalid.
     */
    public function generateToken(string $sessionId, string $token, string $type): string;
}

