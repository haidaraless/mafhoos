<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Inspections Routes
|--------------------------------------------------------------------------
|
| Here is where you can register inspections routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Inspections routes will be defined here
    // Example:
    // Route::get('inspections', [InspectionController::class, 'index'])->name('inspections.index');
    // Route::get('inspections/create', [InspectionController::class, 'create'])->name('inspections.create');
    // Route::post('inspections', [InspectionController::class, 'store'])->name('inspections.store');
    // Route::get('inspections/{inspection}', [InspectionController::class, 'show'])->name('inspections.show');
    // Route::get('inspections/{inspection}/edit', [InspectionController::class, 'edit'])->name('inspections.edit');
    // Route::put('inspections/{inspection}', [InspectionController::class, 'update'])->name('inspections.update');
    // Route::delete('inspections/{inspection}', [InspectionController::class, 'destroy'])->name('inspections.destroy');
});
