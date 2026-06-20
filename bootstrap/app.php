<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Hapus CSRF sepenuhnya dari API middleware group
        // Flutter mobile & web menggunakan Bearer token, bukan session/cookie
        // Web routes (/login, /dashboard) TETAP terlindungi CSRF seperti biasa
        $middleware->removeFromApi([
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
