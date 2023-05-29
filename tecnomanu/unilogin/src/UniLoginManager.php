<?php

namespace Tecnomanu\UniLogin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Tecnomanu\UniLogin\Support\PayloadGenerator;
use Tecnomanu\UniLogin\Support\UniloginTokenService as TokenService;

class UniLoginManager
{
    public function findMagicLink($payload){
        if(!$payload || !isset($payload['token'])) 
            return null;

        return DB::table('unilogin_magic_links')
            ->where('token', hash('sha256', $payload['token']))
            ->first();
    }

    public function updateSession($token){
        DB::table('unilogin_sessions')
            ->where('token', hash('sha256', $token))
            ->update(['status' => 'completed']);
    }

    public function createMagicLink($email)
    {
        // Genera el payload
        $payload = $this->createToken($email);

        // Hash del token
        $hashedToken = hash('sha256', $payload['token']);

        // Guarda el payload en la base de datos
        DB::table('unilogin_magic_links')->insert([
            'email' => $email,
            'token' => $hashedToken,
            'expires_at' => $payload['exp']
        ]);
        
        // Genera el enlace mágico
        $magicLink = $payload['callback_url'] . '?token=' . $payload['jwt'];

        return ["link" => $magicLink, "token" => $payload['token']];
    }

    public function createToken($email)
    {
        // Genera el payload
        $payloadGenerator = new PayloadGenerator;
        $payload = $payloadGenerator->generate($email);

        // Genera el JWT
        $tokenService = new TokenService;
        $payload['jwt'] = $tokenService->generate($payload);

        // Devuelve el token del payload
        return $payload;
    }

    public function createSessionToken($email, $token){
        $sessionId = (string) Str::uuid();

        DB::table('unilogin_sessions')->insert([
            'session_id' => $sessionId,
            'token' => hash('sha256', $token),
            'status' => 'pending',
            'email' => $email
        ]);

        // Genera el JWT
        $lifetime = $lifetime ?? config('unilogin.token_lifetime');
        $expiresAt = Carbon::now()->addMinutes($lifetime)->timestamp;
        $payload = [
            'sessionId' => $sessionId, 
            'token' => $token,
            "iat" => Carbon::now()->timestamp,
            'exp' => $expiresAt,
        ];

        $tokenService = new TokenService;
        return $tokenService->generate($payload);
    }
}
