<?php

use App\Livewire\Providers\ManageAvailableTimes;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Settings\SparepartCatalog;
use App\Livewire\Dashboard\VehicleInspectionCenter;
use App\Livewire\Dashboard\SparepartsSupplier;
use App\Livewire\Dashboard\AutoRepairWorkshop;
use App\Livewire\Dashboard\VehicleOwner;
use App\Livewire\Quotations\ViewQuotationRequest;
use App\Livewire\Quotations\BrowseQuotations;
use App\Livewire\Quotations\ProvideQuotation;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/vehicle-inspection-center', VehicleInspectionCenter::class)->name('dashboard.vehicle-inspection-center');
        Route::get('/spare-parts-supplier', SparepartsSupplier::class)->name('dashboard.spare-parts-supplier');
        Route::get('/auto-repair-workshop', AutoRepairWorkshop::class)->name('dashboard.auto-repair-workshop');
        Route::get('/vehicle-owner', VehicleOwner::class)->name('dashboard.vehicle-owner');
    });

    Route::prefix('/providers')->group(function () {
        Route::get('/available-times', ManageAvailableTimes::class)->name('providers.available-times.manage');
    });

    Route::get('/quotation-requests', BrowseQuotations::class)->name('quotation-requests.browse');
    Route::get('/quotation-requests/{quotationRequestId}', ViewQuotationRequest::class)->name('quotation-requests.view');
    Route::get('/quotation-requests/{quotationRequestId}/provide-quote', ProvideQuotation::class)->name('quotation-requests.provide-quote');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('settings/sparepart-catalog', SparepartCatalog::class)->name('settings.sparepart-catalog');

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

});

require __DIR__.'/auth.php';
require __DIR__.'/vehicles.php';
require __DIR__.'/inspections.php';
require __DIR__.'/appointments.php';
