<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Appointments Routes
|--------------------------------------------------------------------------
|
| Here is where you can register appointments routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Appointments routes will be defined here
    // Example:
    // Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    // Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    // Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    // Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    // Route::get('appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    // Route::put('appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    // Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
});
