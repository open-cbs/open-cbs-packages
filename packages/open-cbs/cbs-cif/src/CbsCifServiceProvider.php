<?php

namespace OpenCbs\CbsCif;

use Illuminate\Support\ServiceProvider;

class CbsCifServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register services for cbs-cif
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
