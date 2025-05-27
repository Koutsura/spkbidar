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
    default-src https: 'self' data:;
            script-src https: 'unsafe-inline' 'unsafe-eval';
            style-src https: 'unsafe-inline';
            img-src https: data:;
            font-src https:;
            connect-src https:;
            frame-src https:;
            frame-ancestors 'none';
            base-uri 'self';
            form-action https:;
";


        // Bersihkan spasi dan newline menjadi satu spasi
        $csp = preg_replace('/\s+/', ' ', trim($csp));

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY'); // Kalau butuh iframe eksternal bisa diubah
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');

        return $response;
    }
}
