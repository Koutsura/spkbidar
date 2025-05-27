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
            script-src 'self' https: 'unsafe-inline' 'unsafe-eval';
            style-src 'self' https: 'unsafe-inline';
            img-src 'self' https: data: blob:;
            font-src 'self' https:;
            connect-src 'self' https:;
            frame-src 'self' https: blob:;
            frame-ancestors 'none';
            base-uri 'self';
            form-action 'self' https:;
        ";

        // Bersihkan spasi dan newline menjadi satu spasi
        $csp = preg_replace('/\s+/', ' ', trim($csp));

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY'); // Bisa ubah jadi SAMEORIGIN jika butuh iframe internal
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');

        return $response;
    }
}
