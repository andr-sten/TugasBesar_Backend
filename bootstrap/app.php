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
    ->withMiddleware(function (Middleware $middleware) {
        // MENGECUALIKAN ROUTE DARI CSRF TOKEN (PENCEGAHAN ERROR 419 DI VERCEL SERVERLESS)
        // Vercel serverless = stateless, CSRF token tidak reliable
        $middleware->validateCsrfTokens(except: [
            'api/*',
            'login',
            'register',
            'logout',
            '*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
