<?php

namespace Tecnomanu\UniLogin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Tecnomanu\UniLogin\Enums\UniLoginTypes;

class CallbackTokenMiddleware extends TokenMiddleware
{
    protected $expectedType = UniLoginTypes::CALLBACK;

    public function handle(Request $request, Closure $next)
    {
 
        try {
            $errorViewUrl = config('unilogin.api_base_path').'unilogin/error';
            $invalidSessionViewUrl = config('unilogin.api_base_path').'unilogin/invalid-session';

            // Here you're calling the parent's handle method which can throw exceptions
            parent::handle($request, $next);

            $credentials = $request->get('credentials');
            $request->merge(['email' => $credentials['email'], 'token' => $credentials['token']]);

            return $next($request);
        } catch(ExpiredException $e) {
            // return response()->json(['error' => 'Provided token has expired.'], 400);
            return redirect($invalidSessionViewUrl);
        } catch(\Exception $e) {
            // return response()->json(['error' => 'An error while decoding session token.'], 400);
            return redirect($errorViewUrl);
        }
    }
}
