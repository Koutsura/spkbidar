<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();

            // Ambil notifikasi user yang belum dibaca
            $notifications = Notification::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->get();

            $unreadCount = $notifications->where('is_read', false)->count();

            $view->with(compact('notifications', 'unreadCount'));
        } else {
            $view->with(['notifications' => collect(), 'unreadCount' => 0]);
        }
    });
        //
    }
}
