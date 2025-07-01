<?php

use App\Http\Controllers\ProfileController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;

Route::get('/', function () {
    $isMaintenanceMode = Setting::isMaintenanceMode();
    return view('welcome', compact('isMaintenanceMode'));
})->name('/');

Route::get('/dashboard', function () {
    $isMaintenanceMode = Setting::isMaintenanceMode();
    return view('dashboard', compact('isMaintenanceMode'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Inventory routes
    Route::get('/inventory/overview', [App\Http\Controllers\ProductController::class, 'inventoryOverview'])->name('inventory.overview');
    Route::post('/inventory/category', [App\Http\Controllers\ProductController::class, 'showCategoryInventory'])->name('inventory.category');
});
Route::post('/toggle-maintenance', [MaintenanceController::class, 'toggle'])->name('toggle.maintenance');

require __DIR__ . '/auth.php';
