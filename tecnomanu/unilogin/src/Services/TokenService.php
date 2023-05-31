<?php

namespace Tecnomanu\UniLogin\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Tecnomanu\UniLogin\Contracts\Services\TokenServiceContract;
use Tecnomanu\UniLogin\Enums\UniLoginTypes;

class TokenService implements TokenServiceContract
{
    private $jwtKey;
    private $algo;

    public function __construct()
    {
        $this->algo = 'HS256';
        $this->jwtKey = config('unilogin.secret');
    }

    public function encode(array $data, string $type = UniLoginTypes::LOGIN, int $lifetime = null): string
    {
        $issuedAt = time();

        $payload = [
            'type' => $type,
            'iat'  => $issuedAt, // Issued at: time when the token was generated
        ];

        if($lifetime)
            $payload['exp'] =$issuedAt + $lifetime; // Expire

        $payloadMerged = array_merge($data, $payload);

        return JWT::encode($payloadMerged, $this->jwtKey, $this->algo);
    }

    public function decode($token)
    {
        if(!$token)
            throw new Exception('Invalid token.');

        return JWT::decode($token, new Key($this->jwtKey, $this->algo));
    }

    public function generateToken($sessionId, $token, $type): string{
        // Generate JWT
        $lifetime = config('unilogin.token_lifetime');
        
        $payload = [
            'sessionId' => $sessionId, 
            'token' => $token,
        ];


        return $this->encode($payload, $type, $lifetime);
    }
}
