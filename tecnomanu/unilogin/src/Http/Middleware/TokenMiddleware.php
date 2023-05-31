<?php

namespace Tecnomanu\UniLogin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tecnomanu\UniLogin\Exceptions\UniLoginException;

use Tecnomanu\UniLogin\Contracts\Services\TokenServiceContract;

abstract class TokenMiddleware
{
    protected $expectedType;
    protected $tokenService;

    public function __construct(TokenServiceContract $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken() ?? $request->input('token');

        if (!$token) {
            // No session token provided in the request.
            throw new UniLoginException('No token provided.');
        }

        try {
            $credentials = $this->tokenService->decode($token);
        } catch(\Exception $e) {
            throw $e;
        }

        $credentials = collect($credentials)->toArray();
        
        // Validate token login type if is required
        if($this->expectedType && (!$credentials || $credentials['type'] !== $this->expectedType)) {
            throw new \Exception('Invalid token type.');
        }

        // Put the user's email in the request so it can be accessed in the controller.
        $request->merge(["credentials" => $credentials]);

        return $request;
    }
}