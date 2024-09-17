<?php

use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\AdminGuestMiddleware;
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
        // Add your middleware here
        $middleware->alias([
            'admin_auth' => AdminAuthMiddleware::class,
            'admin_guest' => AdminGuestMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
