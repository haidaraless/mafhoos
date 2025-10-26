<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Inspections\ReportInspection;    
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

    Route::prefix('/inspections')->group(function () {
        Route::get('{inspection}', ReportInspection::class)->name('inspections.report');
    });
});
