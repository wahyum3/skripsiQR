<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Middleware\Authenticate; 
use App\Http\Middleware\IsAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Menambahkan alias middleware
        $middleware->alias([
            'auth' => Authenticate::class, 
            'admin' => IsAdmin::class     
        ]);
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        // Konfigurasi exception jika diperlukan
    })
    ->create();

