<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    protected function handle($request, Closure $next, ...$guards)
{
    // 1. Coba auto-login via remember cookie
    if (!$this->alreadyAuthenticated($request) &&
        $this->hasRememberCookie($request) &&
        $this->attemptRememberLogin($request)) {
        return $next($request);
    }

    // 2. Normal authentication check
    if ($this->alreadyAuthenticated($request)) {
        return $next($request);
    }

    return redirect()->guest(route('login'));
}

    protected function shouldAllowAccess(Request $request): bool
    {
        // Jika sudah login, izinkan akses
        if (Auth::check()) {
            return true;
        }

        // Coba auto-login via remember token
        return $this->attemptRememberLogin($request);
    }

    protected function attemptRememberLogin($request)
{
    try {
        $cookie = $request->cookie(Auth::getRecallerName());
        [$id, $token, $passwordHash] = explode('|', decrypt($cookie), 3);

        $user = User::find($id);

        if ($user &&
            hash_equals($user->getRememberToken(), hash('sha256', $token)) &&
            hash_equals($user->getAuthPassword(), $passwordHash)) {

            Auth::login($user, true);
            $request->session()->regenerate();
            return true;
        }
    } catch (\Exception $e) {
        report($e);
    }

    return false;
}

protected function hasRememberCookie($request)
{
    return $request->hasCookie(Auth::getRecallerName());
}

protected function alreadyAuthenticated($request)
{
    return Auth::check();
}

    protected function redirectTo(Request $request): string
    {
        return $request->expectsJson() ? route('login') : route('dashboard');
    }
}
