<?php

namespace Tecnomanu\UniLogin\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Tecnomanu\UniLogin\Contracts\Services\MagicLinkServiceContract;
use Tecnomanu\UniLogin\Contracts\Services\SessionServiceContract;
use Tecnomanu\UniLogin\Contracts\Services\TokenServiceContract;
use Tecnomanu\UniLogin\Contracts\Services\UniLoginServiceContract;

use Tecnomanu\UniLogin\Enums\UniLoginTypes;
use Tecnomanu\UniLogin\Enums\UniLoginMagicLinkStatus;
use Tecnomanu\UniLogin\Enums\UniLoginSessionStatus;

use Tecnomanu\UniLogin\Exceptions\UniLoginForbiddenException;
use Tecnomanu\UniLogin\Exceptions\UniLoginUnauthorizedException;

use Tecnomanu\UniLogin\Notifications\MagicLinkNotification;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UniLoginService implements UniLoginServiceContract
{
    protected $magicLinkService;
    protected $sessionService;
    protected $tokenService;

    public function __construct(
        MagicLinkServiceContract $magicLinkService,
        SessionServiceContract $sessionService,
        TokenServiceContract $tokenService
    ) {
        $this->magicLinkService = $magicLinkService;
        $this->sessionService = $sessionService;
        $this->tokenService = $tokenService;
    }

    public function sendMagicLink(Authenticatable $user): JsonResponse
    {
        try {
            $userEmail = $user->email;
            $magicLink = $this->magicLinkService->createMagicLink($userEmail);

            if(!$magicLink['token'])
                throw new \Exception('An error ocurred.');
                
            $session = $this->sessionService->create($userEmail, $magicLink['token']);

            // Create Session Token
            $payload = ["sessionId" => $session['session_id'], "token" => $magicLink['token'], "email" => $userEmail ];
            $sessionToken = $this->tokenService->generateToken($payload, UniLoginTypes::POLLING);

            // Envía el enlace mágico por correo electrónico
            $user->notify( new MagicLinkNotification($magicLink['link']) );

            return response()->json([
                'status' => 'success',
                'data' => [
                    'session_token' => $sessionToken,
                    'message' => 'The magic link has been sent to your email address.',
                ]
            ], 200);
        } catch (\Exception $e) {
            throw new \Exception('An error occurred');
        }
    }

    public function handlePolling(string $sessionId, string $token, string $email): ?JsonResponse
    {
        $session = $this->sessionService->find($sessionId, $token);
        
        if(!$session)
            throw new UniLoginUnauthorizedException();
        if($session['status'] !== UniLoginSessionStatus::ACCEPTED)
            throw new UniLoginForbiddenException();

        $payload = ["email" => $email];
        $loggedToken = $this->tokenService->encode($payload, UniLoginTypes::SUCCESS, 60);

        return response()->json(['token' => $loggedToken]);
    }

    public function handleCallback(string $token, string $email): ?RedirectResponse {
        $magicLink = $this->findMagicLink($token);

        // Remove MagicLink
        if(!$magicLink)
            throw new UniLoginForbiddenException(); 

        $this->magicLinkService->updateStatus($token, UniLoginMagicLinkStatus::COMPLETED);
        $this->sessionService->updateStatus($token, UniLoginSessionStatus::ACCEPTED);

        $redirectUrl = config('unilogin.callback_url');

        if(!$redirectUrl)
            $redirectUrl = config('unilogin.api_base_path'). "unilogin/success";


        $payload = ["token" => $token, "email" => $email];
        $loggedToken = $this->tokenService->encode($payload, UniLoginTypes::ACCEPTED, 60);

        return redirect($redirectUrl.'?token=' . $loggedToken);
    }

    public function handleSuccessLogin($token): ?View {
        $magicLink = $this->findMagicLink($token);      
        $this->magicLinkService->remove($token);  
        return view('unilogin::success', ["expired" => !$magicLink]);
    }

    public function findMagicLink(string $token): ?array {
        $magicLink = $this->magicLinkService->find($token);
        if (!$magicLink)
            throw new UniLoginForbiddenException();  

        return $magicLink;
    }
}
