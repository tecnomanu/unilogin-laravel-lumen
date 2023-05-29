<?php

namespace Tecnomanu\UniLogin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Tecnomanu\UniLogin\Support\UniloginTokenService;

class SessionTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            // No session token provided in the request.
            return response()->json(['error' => 'No session token provided.'], 401);
        }

        try {
            $tokenService = new UniloginTokenService;
            $credentials = $tokenService->decode($token);
        } catch(ExpiredException $e) {
            return response()->json(['error' => 'Provided token has expired.'], 400);
        } catch(\Exception $e) {
            return response()->json(['error' => 'An error while decoding session token.'], 400);
        }

        // Put the user's email in the request so it can be accessed in the controller.
        $request->merge(['session_id' => $credentials->sessionId, 'token' => $credentials->token]);

        return $next($request);
    }
}
