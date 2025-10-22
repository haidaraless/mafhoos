<?php

use App\Livewire\Appointments\SelectInspectionCenter;
use App\Livewire\CreateVehicle;
use App\Livewire\Providers\ManageAvailableTimes;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Vehicles\ListVehicles;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');


    Route::get('vehicles', ListVehicles::class)->name('vehicles.index');
    Route::get('vehicles/create', CreateVehicle::class)->name('vehicles.create');
    Route::get('providers/{provider}/available-times', ManageAvailableTimes::class)->name('providers.available-times.manage');
});

require __DIR__.'/auth.php';
require __DIR__.'/appointments.php';
require __DIR__.'/inspections.php';
