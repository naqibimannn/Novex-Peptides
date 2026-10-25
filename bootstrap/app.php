<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->redirectTo(
            guests: function (Request $request) {
                $secret = env('ADMIN_SECRET_KEY');
                return url("admin/{$secret}/login");
            },
            users: function (Request $request) {
                $secret = env('ADMIN_SECRET_KEY');
                return url("admin/{$secret}/dashboard");
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Pengendalian respons JSON API
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();