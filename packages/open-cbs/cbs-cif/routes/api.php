<?php

use Illuminate\Support\Facades\Route;
use OpenCbs\CbsCif\Http\Controllers\CustomerController;

Route::middleware(['api'])->prefix('api/cbs/cif')->group(function () {
    Route::post('customers', [CustomerController::class, 'store'])->name('cbs.cif.customers.store');
});
