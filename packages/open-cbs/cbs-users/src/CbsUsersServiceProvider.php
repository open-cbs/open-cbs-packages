<?php

namespace OpenCbs\CbsUsers;

use Illuminate\Support\ServiceProvider;

class CbsUsersServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register services for cbs-users
    }

    public function boot()
    {
        // Boot services for cbs-users
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
