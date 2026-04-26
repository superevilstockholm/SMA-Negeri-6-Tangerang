<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyTurnstileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->input('cf-turnstile-response');

        if (!$token) {
            return back()->withErrors([
                'Captcha is required!',
            ]);
        }

        $response = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ]
        );

        if (!($response->json()['success'] ?? false)) {
            return back()->withErrors([
                'Captcha is invalid!',
            ]);
        }

        return $next($request);
    }
}
