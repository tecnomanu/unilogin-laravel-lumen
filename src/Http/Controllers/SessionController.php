<?php

namespace Tecnomanu\UniLogin\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

use Tecnomanu\UniLogin\Contracts\Services\UniLoginServiceContract;
use Tecnomanu\UniLogin\Exceptions\UniLoginUnauthorizedException;

class SessionController extends Controller
{
    protected $uniloginService;

    public function __construct(UniLoginServiceContract $uniloginService)
    {
        $this->uniloginService = $uniloginService;
    }

    public function handlePolling(Request $request)
    {
        if(!$request->input('session_id') || !$request->input('token') || !$request->input('email'))
            return $this->isUnauthorized();

        try {
            $data = $request->only(['session_id','token','email']);
            return $this->uniloginService->handlePolling($data['session_id'],$data['token'],$data['email']);
        } catch (\Exception $e) {
            return response()->json(["status" => "error" , "data" => $e->getMessage()], $e->getCode() > 0 ? $e->getCode() : 400);
        }
    }

    private function isUnauthorized(){
        return response()->json(["status" => "error" , "data" => "Access Unauthorized."], 401);
    }
}
