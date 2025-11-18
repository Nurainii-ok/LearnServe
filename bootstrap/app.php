<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'prevent-back' => \App\Http\Middleware\PreventBackHistory::class,
        ]);
        
        // Replace default CSRF middleware with custom one
        $middleware->web(replace: [
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class => \App\Http\Middleware\VerifyCsrfToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle PostTooLargeException
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'File upload too large',
                    'message' => 'The uploaded file exceeds the maximum allowed size. Please upload a file smaller than 10MB.',
                    'max_size' => '10MB'
                ], 413);
            }
            
            return back()->withInput()->withErrors([
                'image' => 'The uploaded file is too large. Please upload a file smaller than 10MB.'
            ])->with('error', 'Upload failed: File size exceeds 10MB limit.');
        });
    })
    ->create();
