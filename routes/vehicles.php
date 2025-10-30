<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Vehicles\CreateVehicle;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('/vehicles')->group(function () {

        Route::get('/create', CreateVehicle::class)->name('vehicles.create');
    });
});