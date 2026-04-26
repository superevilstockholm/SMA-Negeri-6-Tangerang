<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Middlewares
use App\Http\Middleware\Auth\RoleMiddleware;
use App\Http\Middleware\Auth\GuestMiddleware;
use App\Http\Middleware\VerifyTurnstileMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        // health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => route('login-view'));
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'guest' => GuestMiddleware::class,
            'turnstile' => VerifyTurnstileMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
