<?php

namespace Tecnomanu\UniLogin\Support;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Exception;

class UniloginTokenService
{
    private $key;

    public function __construct()
    {
        // Puedes usar una clave de configuración, asegúrate de que sea segura
        $this->key = config('unilogin.secret');
    }

    public function generate(array $payload): string
    {
        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function decode(string $token): Object
    {
        try {
            return JWT::decode($token, new Key($this->key, 'HS256'));       
        } catch(SignatureInvalidException $e) {
            throw new Exception('Token signature is invalid.');
        } catch(Exception $e) {
            throw new Exception('Invalid token.');
        }
    }

    public function validate(string $token): Object
    {
        try {
            return $this->decode($token);
        } catch(ExpiredException $e) {
            throw new Exception('Token expired.');
        } catch(SignatureInvalidException $e) {
            throw new Exception('Token signature is invalid.');
        } catch(Exception $e) {
            throw new Exception('Invalid token.');
        }
    }
}
