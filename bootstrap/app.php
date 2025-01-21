<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            // \Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks::class,
            // \Illuminate\Http\Middleware\TrustHosts::class,
            // \Illuminate\Http\Middleware\TrustProxies::class,
            // App\Http\Middleware\CorsMiddleware::class,
            // \App\Http\Middleware\CustomAuthMiddleware::class,
            // \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            // \Illuminate\Http\Middleware\ValidatePostSize::class,
            // \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            // \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);
        $middleware->alias([
            // 'cors' => \Fruitcake\Cors\HandleCors::class,
            // 'customCors' => \App\Http\Middleware\CorsMiddleware::class,
            'custom-auth' => \App\Http\Middleware\CustomAuthMiddleware::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            '*'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
