<?php

use App\Http\Controllers\ProfileController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\VoedselpakketController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LeverancierController;


Route::get('/', function () {
    $isMaintenanceMode = Setting::isMaintenanceMode();
    return view('welcome', compact('isMaintenanceMode'));
})->name('/');



// Inventory routes
Route::get('/inventory/overview', [App\Http\Controllers\ProductController::class, 'inventoryOverview'])->name('inventory.overview');
Route::get('/inventory/details/{product}', [App\Http\Controllers\ProductController::class, 'showInventoryDetails'])->name('inventory.details');
Route::get('/inventory/edit/{product}', [App\Http\Controllers\ProductController::class, 'editInventory'])->name('inventory.edit');
Route::put('/inventory/update/{product}', [App\Http\Controllers\ProductController::class, 'updateInventory'])->name('inventory.update');

Route::get('/dashboard', function () {
    $isMaintenanceMode = Setting::isMaintenanceMode();
    return view('dashboard', compact('isMaintenanceMode'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/voedselpakketten', [VoedselpakketController::class, 'index'])->name('voedselpakketten.index');
    Route::get('/voedselpakketten/show/{voedselpakket}', [VoedselpakketController::class, 'show'])->name('voedselpakketten.show');
    Route::get('/voedselpakketten/{voedselpakket}/edit', [VoedselpakketController::class, 'edit'])->name('voedselpakketten.edit');
    Route::post('/voedselpakketten', [VoedselpakketController::class, 'store'])->name('voedselpakketten.store');
    Route::patch('/voedselpakketten/{voedselpakket}', [VoedselpakketController::class, 'update'])->name('voedselpakketten.update');


    Route::resource('leveranciers', LeverancierController::class);

});

Route::post('/toggle-maintenance', [MaintenanceController::class, 'toggle'])->name('toggle.maintenance');

require __DIR__ . '/auth.php';
