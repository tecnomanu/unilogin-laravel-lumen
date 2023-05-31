<?php

namespace Tecnomanu\UniLogin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tecnomanu\UniLogin\Enums\UniLoginTypes;

class PollingTokenMiddleware extends TokenMiddleware
{
    protected $expectedType = UniLoginTypes::POLLING;

    public function handle(Request $request, Closure $next)
    {
        try {
            // Here you're calling the parent's handle method which can throw exceptions
            parent::handle($request, $next);

            $credentials = $request->get('credentials');
            $request->merge(['session_id' => $credentials['sessionId'], 'token' => $credentials['token']]);
            
            return $next($request);
        } catch (\Exception $e) {
            return response()->json(["status" => "error" , "data" => $e->getMessage()], $e->getCode() > 0 ? $e->getCode() : 400);
        }
    }
}
