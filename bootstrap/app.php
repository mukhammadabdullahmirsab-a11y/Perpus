<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 419 Page Expired (CSRF token mismatch)
        // Redirect back with a friendly message instead of showing error page
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            return redirect()
                ->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('status', 'Sesi Anda telah berakhir. Silakan coba lagi.');
        });
    })->create();
