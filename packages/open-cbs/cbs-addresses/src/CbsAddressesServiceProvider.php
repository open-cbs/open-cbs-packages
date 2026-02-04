<?php

namespace OpenCbs\CbsAddresses;

use Illuminate\Support\ServiceProvider;

class CbsAddressesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \OpenCbs\CbsAddresses\Repositories\AddressRepositoryInterface::class,
            \OpenCbs\CbsAddresses\Repositories\AddressRepository::class
        );
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
