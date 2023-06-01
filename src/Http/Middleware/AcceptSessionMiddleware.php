<?php

namespace Tecnomanu\UniLogin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tecnomanu\UniLogin\Enums\UniLoginTypes;

class AcceptSessionMiddleware extends TokenMiddleware
{
    protected $expectedType = UniLoginTypes::ACCEPTED;

    public function handle(Request $request, Closure $next)
    {
        try {
            parent::handle($request, $next);
            
            $credentials = $request->get('credentials');
            
            $request->merge(['token' => $credentials['token']]);
            
            return $next($request);
        } catch (\Exception $e) {
            return response()->json(["status" => "error" , "data" => $e->getMessage()], $e->getCode() > 0 ? $e->getCode() : 400);
        }
    }
}
