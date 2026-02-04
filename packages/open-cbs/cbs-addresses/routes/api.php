<?php

use Illuminate\Support\Facades\Route;
use OpenCbs\CbsAddresses\Http\Controllers\AddressController;
use OpenCbs\CbsAddresses\Http\Controllers\LookupController;

Route::prefix('api/addresses')->group(function () {
    Route::post('/', [AddressController::class, 'store']);
    Route::get('/{id}', [AddressController::class, 'show']);
    Route::delete('/{id}', [AddressController::class, 'destroy']);

    Route::prefix('lookup')->group(function () {
        Route::get('divisions', [LookupController::class, 'divisions']);
        Route::get('districts/{divisionId}', [LookupController::class, 'districts']);
        Route::get('upazilas/{districtId}', [LookupController::class, 'upazilas']);
        Route::get('unions/{upazilaId}', [LookupController::class, 'unions']);
    });
});
