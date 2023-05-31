<?php

namespace Tecnomanu\UniLogin\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

// Injections
use Tecnomanu\UniLogin\Contracts\Repositories\UserRepositoryContract;
use Tecnomanu\UniLogin\Contracts\Services\UniLoginServiceContract;

// Exceptions 
use Tecnomanu\UniLogin\Exceptions\InvalidTokenException;
use Tecnomanu\UniLogin\Exceptions\ExpiredTokenException;


class MagicLinkController extends Controller
{
    protected $uniloginService;
    protected $userRepo;

    public function __construct(
        UniLoginServiceContract $uniloginService, 
        UserRepositoryContract $userRepository)
    {
        $this->uniloginService = $uniloginService;
        $this->userRepo = $userRepository;
    }

    public function send(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        try {
            $user = $this->userRepo->findByEmail($email);
        
            if (!$user)
                return response()->json(['invalid_credentials'], 404);

            return $this->uniloginService->sendMagicLink($user);
        } catch (\Exception $e) {
            return response()->json(["status" => "error" , "data" => $e->getMessage()], $e->getCode() > 0 ? $e->getCode() : 400);
        }
    }
}
