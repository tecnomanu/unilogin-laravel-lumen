<?php

namespace Tecnomanu\UniLogin\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

use Tecnomanu\UniLogin\Contracts\Services\UniLoginServiceContract;
use Tecnomanu\UniLogin\Exceptions\InvalidTokenException;
use Tecnomanu\UniLogin\Exceptions\ExpiredTokenException;
use Tecnomanu\UniLogin\Exceptions\UniLoginForbiddenException;
use Tecnomanu\UniLogin\Exceptions\UniLoginUnauthorizedException;

class CallbackController extends Controller
{
    protected $uniloginService;

    public function __construct(UniLoginServiceContract $uniloginService)
    {
        $this->uniloginService = $uniloginService;
    }

    public function handleCallback(Request $request)
    {
        $token = $request->get('token');
        $email = $request->get('email');

        if (!$token || !$email) 
            return view('unilogin::success', ["expired" => true]);

        try {
            return $this->uniloginService->handleCallback($token, $email);
        } catch (\Exception $e) {
            return response()->json(["status" => "error" , "data" => $e->getMessage()], $e->getCode() > 0 ? $e->getCode() : 400);
        }
    }

    public function successLogin(Request $request){
        try {
            $token = $request->input('token');
            return $this->uniloginService->handleSuccessLogin($token);
        } catch (\Exception $e) {
            return view('unilogin::success', ["expired" => true]);
        }
    }

    public function errorLogin(){
        return view('unilogin::error');
    }

    public function invalidSession(){
        return view('unilogin::invalid-session');
    }
}
