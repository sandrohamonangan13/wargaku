<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Cluster;
use App\Hobi;

class FormWargaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('warga.form', function($view) {
            $view->with('list_cluster', Cluster::pluck('nama_cluster', 'id'));
            $view->with('list_hobi', Hobi::pluck('nama_hobi', 'id'));
        });

        view()->composer('warga.form_pencarian', function($view) {
             $view->with('list_cluster', Cluster::pluck('nama_cluster', 'id'));
        });
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
