<?php

namespace Tecnomanu\UniLogin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tecnomanu\UniLogin\Enums\UniLoginTypes;

class SessionTokenMiddleware extends TokenMiddleware
{
    protected $expectedType = UniLoginTypes::SUCCESS;

    public function handle(Request $request, Closure $next)
    {
        try {
            // Here you're calling the parent's handle method which can throw exceptions
            parent::handle($request, $next);

            $credentials = $request->get('credentials');
            $request->merge(['email' => $credentials['email']]);
            
            return $next($request);
        } catch (\Exception $e) {
            return response()->json(["status" => "error" , "data" => "Access Unauthorized."], $e->getCode() > 0 ? $e->getCode() : 400);
        }
    }
}
