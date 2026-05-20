<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notifikasi;
use Carbon\Carbon;

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
    // ✅ Kirim data notifikasi ke semua view dashboard-apoteker
    view()->composer('dashboard-apoteker', function ($view) {
        $notifBaru = \App\Models\Notifikasi::where('is_read', 0)->count();
        $notifList = \App\Models\Notifikasi::orderBy('created_at', 'desc')->take(5)->get();
        $view->with(compact('notifBaru', 'notifList'));
    });
    }
}