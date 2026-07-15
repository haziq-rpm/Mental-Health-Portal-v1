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
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust Railway's proxy so HTTPS/scheme, host, and port are detected
        // correctly (fixes cookie/session issues behind Railway's edge proxy).
        $middleware->trustProxies(at: '*');

        // The app's /login route (routes/web.php) is unnamed, but Laravel's
        // auth middleware defaults to route('login') when redirecting guests,
        // which throws RouteNotFoundException. Point it at the literal path
        // instead so unauthenticated requests redirect cleanly to /login.
        $middleware->redirectGuestsTo('/login');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
