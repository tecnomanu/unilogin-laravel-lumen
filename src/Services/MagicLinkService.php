<?php

namespace Tecnomanu\UniLogin\Services;

use Tecnomanu\UniLogin\Contracts\Repositories\MagicLinkRepositoryContract as MagicLinkRepository;
use Tecnomanu\UniLogin\Contracts\Services\MagicLinkServiceContract;
use Tecnomanu\UniLogin\Contracts\Services\TokenServiceContract;
use Tecnomanu\UniLogin\Enums\UniLoginTypes;
use Tecnomanu\UniLogin\Models\MagicLink;
use Illuminate\Support\Str;
/**
 * MagicLinkService
 * 
 * Service to handle business logic related to MagicLink.
 */
class MagicLinkService implements MagicLinkServiceContract
{
    protected $magicLinkRepo;
    protected $tokenService;

    public function __construct(MagicLinkRepository $magicLinkRepo, TokenServiceContract $tokenService)
    {
        $this->magicLinkRepo = $magicLinkRepo;
        $this->tokenService = $tokenService;
    }

    public function find($token): ?array {
        return $this->magicLinkRepo->findByToken($token);
    }

    public function updateStatus($token, $status): void{
        $this->magicLinkRepo->updateStatus($token, $status);
    }

    public function remove(string $token): void{
        $this->magicLinkRepo->remove($token);
    }

    public function createMagicLink(string $email): array
    {
        // Generate payload
        $lifetime = config('unilogin.token_lifetime');
        $payload = $this->createPayload($email, $lifetime);

        // Hash del token
        $this->magicLinkRepo->create($payload);

        // Generate JWT        
        $jwt = $this->tokenService->encode($payload, UniLoginTypes::CALLBACK, $lifetime);

        // Generate magic link
        $payload['link'] = config('unilogin.api_base_path'). 'unilogin/callback?token=' . $jwt;

        return $payload;
    }

    private function createPayload($email, $lifetime): array
    {
        $callbackUrl = $callbackUrl ?? config('unilogin.callback_url');

        // Generate the unique token
        $token = Str::random(128);

        // Create the payload
        $payload = [
            'token' => $token,
            'email' => $email,
            'expireAt' => time() + $lifetime
        ];

        // Return token from payload
        return $payload;
    }
}
