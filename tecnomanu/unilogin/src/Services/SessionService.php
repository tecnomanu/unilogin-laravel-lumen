<?php

namespace Tecnomanu\UniLogin\Services;

use Illuminate\Support\Str;
use Tecnomanu\UniLogin\Contracts\Repositories\SessionRepositoryContract;
use Tecnomanu\UniLogin\Contracts\Services\SessionServiceContract;
use Tecnomanu\UniLogin\Contracts\Services\TokenServiceContract;
use Tecnomanu\UniLogin\Enums\UniLoginSessionStatus;
use Tecnomanu\UniLogin\Models\Session;

/**
 * SessionService
 * 
 * Service to handle business logic related to Session.
 */
class SessionService implements SessionServiceContract
{
    protected $sessionRepo;
    protected $tokenService;

    public function __construct(SessionRepositoryContract $sessionRepo, TokenServiceContract $tokenService)
    {
        $this->sessionRepo = $sessionRepo;
        $this->tokenService = $tokenService;
    }

    public function find(string $sessionId, string $token): ?array {
        return $this->sessionRepo->findByToken($sessionId, $token);
    }

    public function updateStatus($token, $status): void{
        $this->sessionRepo->updateStatus($token, $status);
    }

    public function create($email, $token): array{
        $sessionId = (string) Str::uuid();
        $data = [
            'email' => $email, 
            'token' => $token, 
            'session_id' => $sessionId, 
            'status' =>  UniLoginSessionStatus::PENDING
        ];
        return $this->sessionRepo->create($data);
    }
}
