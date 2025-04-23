<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TokenAuth; // 👈 Add your middleware here

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Minimal middleware for token-based auth (stateless)
        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,

            // ✅ Register your custom auth middleware
            'auth.token' => TokenAuth::class,
        ]);

        // ❌ No Sanctum, no sessions, no CSRF
        // If you had those, they’d go here with $middleware->append(), but you don’t need them
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Add custom exception handling here if needed
    })
    ->create();
