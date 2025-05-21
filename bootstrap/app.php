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
        // ✅ Middleware global (aktif di semua request)
        $middleware->append(\App\Http\Middleware\ContentSecurityPolicy::class);
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class); // Gunakan middleware bawaan Laravel

        // ✅ Middleware route alias
        $middleware->alias([
            'superadmin' => \App\Http\Middleware\superadmin::class,
            'mahasiswa' => \App\Http\Middleware\mahasiswa::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tambahkan handler jika diperlukan
    })
    ->create();
