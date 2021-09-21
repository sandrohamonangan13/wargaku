<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WargaAppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $halaman = '';

        if (request()->segment(1) == 'warga') {
            $halaman = 'warga';
        }

        if (request()->segment(1) == 'about') {
            $halaman = 'about';
        }

        if (request()->segment(1) == 'cluster') {
            $halaman = 'cluster';
        }

        if (request()->segment(1) == 'hobi') {
            $halaman = 'hobi';
        }

        if (request()->segment(1) == 'user') {
            $halaman = 'user';
        }

        view()->share('halaman', $halaman);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
