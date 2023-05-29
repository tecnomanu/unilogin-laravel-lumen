<?php

namespace Tecnomanu\UniLogin\Support;

use Illuminate\Support\Str;
use Carbon\Carbon;

class PayloadGenerator
{
    /**
     * Generate a new unique token.
     *
     * @return array
     */
    public function generate(string $email, int $lifetime = null, string $callbackUrl = null): array
    {

        $callbackUrl = $callbackUrl ?? config('unilogin.callback_url');
        $lifetime = $lifetime ?? config('unilogin.token_lifetime');

        // Generate the unique token
        $token = Str::random(128);

        // Generate expiry timestamp
        $expiresAt = Carbon::now()->addMinutes($lifetime)->timestamp;

        // Create the payload
        $payload = [
            'token' => $token,
            'email' => $email,
            "iat" => Carbon::now()->timestamp,
            'exp' => $expiresAt,
            'callback_url' => $callbackUrl,
        ];

        return $payload;
    }
}
