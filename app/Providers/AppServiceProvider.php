<?php

namespace App\Providers;

use App\Models\Siswa; // Tambahkan ini di atas
use App\Models\Pembayaran; // Tambahkan ini di atas
use App\Observers\SiswaObserver; // Tambahkan ini di atas
use App\Observers\PembayaranObserver; // Tambahkan ini di atas
use Illuminate\Support\ServiceProvider;


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
    // Aktifkan Observer
    Siswa::observe(SiswaObserver::class);
    Pembayaran::observe(PembayaranObserver::class);
}
}
