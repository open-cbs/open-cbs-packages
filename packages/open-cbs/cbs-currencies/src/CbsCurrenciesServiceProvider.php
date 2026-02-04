<?php

namespace OpenCbs\CbsCurrencies;

use Illuminate\Support\ServiceProvider;

class CbsCurrenciesServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register services for cbs-currencies
    }

    public function boot()
    {
        // Boot services for cbs-currencies
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
