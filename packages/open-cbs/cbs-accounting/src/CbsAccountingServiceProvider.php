<?php

namespace OpenCbs\CbsAccounting;

use Illuminate\Support\ServiceProvider;

class CbsAccountingServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register services for cbs-accounting
    }

    public function boot()
    {
        // Boot services for cbs-accounting
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
