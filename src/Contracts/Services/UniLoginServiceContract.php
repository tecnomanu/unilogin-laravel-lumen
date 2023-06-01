<?php

namespace Tecnomanu\UniLogin\Contracts\Services;

use Illuminate\Contracts\Auth\Authenticatable;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
/**
 * UniLoginServiceContract
 * 
 * Defines the contract that the unilogin services  must adhere to.
 */
interface UniLoginServiceContract
{
    /**
     * Create a magic link for the provided email.
     *
     * @param  string  $email
     * @return array
     */
    public function sendMagicLink(Authenticatable $user): ?JsonResponse;

    /**
     * Find a magic link using the token and email.
     *
     * @param  string  $token
     * @param  string  $email
     * @return array|null
     */
    public function handlePolling(string $sessionId, string $token, string $email): ?JsonResponse;


    /**
     * Find a magic link using the token and email.
     *
     * @param  string  $token
     * @param  string  $email
     * @return array|null
     */
    public function handleCallback(string $token, string $email): ?RedirectResponse;

        /**
     * Find a magic link using the token and email.
     *
     * @param  string  $token
     * @param  string  $email
     * @return array|null
     */
    public function handleSuccessLogin(string $token): ?View;

    
    /**
     * Find magicLink
     *
     * @param  string  $token
     * @param  string  $status
     * @return bool
     */
    public function findMagicLink(string $token): ?array;
}
