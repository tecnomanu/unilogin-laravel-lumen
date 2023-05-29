<?php

namespace Tecnomanu\UniLogin\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Tecnomanu\UniLogin\Support\UniLogin;
use Tecnomanu\UniLogin\Notifications\MagicLink;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tecnomanu\UniLogin\Support\UniloginTokenService as TokenService;
use Tecnomanu\UniLogin\Support\UserResolver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UniLoginController extends Controller
{
    protected $user;

    public function __construct()
    {
        $user = new UserResolver();
        $this->user = $user->resolve();
    }


    public function sendMagicLink(Request $request)
    {
        try {
            // Valida el correo electrónico
            $this->validate($request, [
                'email' => 'required|email'
            ]);
            $user = new UserResolver();

            $user = $this->user->where('email', $request->email)->firstOrFail();

            $magicLink = UniLogin::createMagicLink($user->email);

            $sessionToken = UniLogin::createSessionToken($user->email, $magicLink['token'] );

            // Envía el enlace mágico por correo electrónico
            $user->notify( new MagicLink($magicLink['link']) );

            // Respond with a success message
            return response()->json([
                'status' => 'success',
                'data' => [
                    'session_token' => $sessionToken,
                    'message' => 'The magic link has been sent to your email address.',
                ]
            ], 200);

        } catch (NotFoundHttpException $e) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        } catch (Exception $e) {
            if ($exception instanceof NotFoundHttpException)
                return response()->json('NotFoundHttpException');
        }
    }

    public function handleCallback(Request $request)
    {
        try {
            $token = $request->get('token');
            $tokenService = new TokenService;
            
            if (!$token || !$tokenService->validate($token)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The magic link is invalid or has expired.',
                ], 400);
            }

            $magicLink = UniLogin::findMagicLink($token);
            if (!$magicLink) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Not session available.',
                ], 404);
            }

            UniLogin::updateSession($token, 'completed');

            $redirectUrl = config('unilogin.callback_url');
            return redirect($redirectUrl);
        }catch(Exception $e){

        }
    }

    public function handlePolling(Request $request){
        try {
            if(!$request->input('session_id'))
                return $this->isUnauthorized();
                
            $session = DB::table('unilogin_sessions')
                ->where('session_id', $request->input('session_id'))
                ->where('token', hash('sha256', $request->input('token')))
                ->first();

            if(!$session || $session['status'] !== 'completed')
                return $this->isUnauthorized();

            $user = User::where('email', $session['email'])->first();

            if (!$user)
                return $this->isUnauthorized();
            
            if (!$token = Auth::fromUser($user))
                return $this->isUnauthorized();
            
            return response()->json(['token' => $token]);
        }catch(Exception $e){
            return $this->isUnauthorized();
        }
    }

    protected function isUnauthorized()
    {
        return response()->json('Access Unauthorized.', 401);
    }
}
