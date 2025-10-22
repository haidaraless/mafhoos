<?php

use App\Livewire\Appointments\ListProviderAppointments;
use App\Http\Controllers\PayFeesController;
use App\Livewire\Appointments\SelectInspectionCenter;
use App\Livewire\Appointments\SelectInspectionDate;
use App\Livewire\Appointments\SelectInspectionType;
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
    Route::prefix('/appointments')->group(function () {
        Route::get('/', ListProviderAppointments::class)->name('appointments.index');
        Route::get('{appointment}/inspection-center', SelectInspectionCenter::class)->name('appointments.inspection-center.select');
        Route::get('{appointment}/inspection-type', SelectInspectionType::class)->name('appointments.inspection-type.select');
        Route::get('{appointment}/inspection-date', SelectInspectionDate::class)->name('appointments.inspection-date.select');
        Route::get('{appointment}/fees', [PayFeesController::class, 'show'])->name('appointments.fees.pay');
        Route::get('fees/callback', [PayFeesController::class, 'callback'])->name('appointments.fees.callback.controller');
    });
});
