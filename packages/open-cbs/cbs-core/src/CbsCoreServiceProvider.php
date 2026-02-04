<?php

namespace OpenCbs\CbsCore;

use Illuminate\Support\ServiceProvider;

class CbsCoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register services for cbs-core
    }

    public function boot()
    {
        // Boot services for cbs-core
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
