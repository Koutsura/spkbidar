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

        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class); // Gunakan middleware bawaan Laravel

        // ✅ Middleware route alias
        $middleware->alias([
            'superadmin' => \App\Http\Middleware\superadmin::class,
            'mahasiswa' => \App\Http\Middleware\mahasiswa::class,
            'alqarib' => \App\Http\Middleware\alqarib::class,
            'BDCA' => \App\Http\Middleware\BDCA::class,
            'BDCU' => \App\Http\Middleware\BDCU::class,
            'BDPRO' => \App\Http\Middleware\BDPRO::class,
            'BDSC' => \App\Http\Middleware\BDSC::class,
            'BGK' => \App\Http\Middleware\BGK::class,
            'BRadio' => \App\Http\Middleware\BRadio::class,
            'KMHDI' => \App\Http\Middleware\KMHDI::class,
            'MABIDAR' => \App\Http\Middleware\MABIDAR::class,
            'Olahraga' => \App\Http\Middleware\Olahraga::class,
            'PMKK' => \App\Http\Middleware\PMKK::class,
            'Pramuka' => \App\Http\Middleware\Pramuka::class,
            'SSEC' => \App\Http\Middleware\SSEC::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tambahkan handler jika diperlukan
    })
    ->create();
