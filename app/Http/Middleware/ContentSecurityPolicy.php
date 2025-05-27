<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $csp = "
            default-src 'self' https: data:;
            script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://maps.googleapis.com https://maps.gstatic.com;
            style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;
            img-src 'self' data: https://maps.gstatic.com https://maps.googleapis.com https://maps.google.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://ui-avatars.com;
            font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net https://cdnjs.cloudflare.com;
            connect-src 'self' https://maps.googleapis.com https://ukmbidar.decadev.tech/;
            frame-src 'self' https://www.google.com https://maps.google.com https://www.google.com/maps;
            frame-ancestors 'none';
            base-uri 'self';
            form-action 'self' https://ukmbidar.decadev.tech/;
        ";

        // Bersihkan spasi dan newline menjadi satu spasi
        $csp = preg_replace('/\s+/', ' ', trim($csp));

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY'); // Ubah kalau perlu iframe eksternal
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');

        return $response;
    }
}
