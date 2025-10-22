<?php

use App\Livewire\Appointments\ListProviderAppointments;
use App\Http\Controllers\PayFeesController;
use App\Livewire\Appointments\SelectInspectionCenter;
use App\Livewire\Appointments\SelectInspectionDate;
use App\Livewire\Appointments\SelectInspectionType;
use App\Livewire\Appointments\SelectVehicle;
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
        Route::get('/create', function() {
            $appointment = \App\Models\Appointment::create([
                'vehicle_id' => null,
                'status' => \App\Enums\AppointmentStatus::PENDING->value,
            ]);
            return redirect()->route('appointments.vehicle.select', $appointment);
        })->name('appointments.create');
        
        Route::get('{appointment}/select-vehicle', SelectVehicle::class)->name('appointments.vehicle.select');
        Route::get('{appointment}/inspection-center', SelectInspectionCenter::class)->name('appointments.inspection-center.select');
        Route::get('{appointment}/inspection-type', SelectInspectionType::class)->name('appointments.inspection-type.select');
        Route::get('{appointment}/inspection-date', SelectInspectionDate::class)->name('appointments.inspection-date.select');
        Route::get('{appointment}/fees', [PayFeesController::class, 'show'])->name('appointments.fees.pay');
        Route::get('fees/callback', [PayFeesController::class, 'callback'])->name('appointments.fees.callback.controller');
    });
});
