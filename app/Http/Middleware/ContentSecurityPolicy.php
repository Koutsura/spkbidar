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
            style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;
            img-src 'self' data: https://maps.gstatic.com https://maps.googleapis.com https://maps.google.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com;
            font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com;
            connect-src 'self' https://maps.googleapis.com;
            frame-src 'self' https://www.google.com https://maps.google.com https://www.google.com/maps;
            frame-ancestors 'none';
            base-uri 'self';
            form-action 'self';
        ";

        // Bersihkan spasi dan newline
        $csp = preg_replace('/\s+/', ' ', trim($csp));

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY'); // Kalau mau iframe Google Maps di halaman ini, bisa diubah jadi SAMEORIGIN atau dihapus jika iframe eksternal
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');

        return $response;
    }
}
