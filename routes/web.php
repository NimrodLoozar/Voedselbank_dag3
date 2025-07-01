<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KlantenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\VoedselpakketController;
use Illuminate\Support\Facades\DB;


Route::get('/', function () {
    $isMaintenanceMode = DB::table('settings')->where('key', 'maintenance_mode')->value('value') ?? false;
    return view('welcome', compact('isMaintenanceMode'));
})->name('/');

Route::get('/voedselpakketten', [VoedselpakketController::class, 'index'])->name('voedselpakketten.index');
Route::get('/voedselpakketten/show/{voedselpakket}', [VoedselpakketController::class, 'show'])->name('voedselpakketten.show');
Route::get('/voedselpakketten/{voedselpakket}/edit', [VoedselpakketController::class, 'edit'])->name('voedselpakketten.edit');
Route::post('/voedselpakketten', [VoedselpakketController::class, 'store'])->name('voedselpakketten.store');
Route::patch('/voedselpakketten/{voedselpakket}', [VoedselpakketController::class, 'update'])->name('voedselpakketten.update');

Route::get('/dashboard', function () {
    $isMaintenanceMode = DB::table('settings')->where('key', 'maintenance_mode')->value('value') ?? false;
    return view('dashboard', compact('isMaintenanceMode'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Klanten routes
    Route::get('/klanten', [KlantenController::class, 'index'])->name('klanten.index');
    Route::get('/klanten/{gezin}', [KlantenController::class, 'show'])->name('klanten.show');
    Route::get('/klanten/{gezin}/edit', [KlantenController::class, 'edit'])->name('klanten.edit');
    Route::put('/klanten/{gezin}', [KlantenController::class, 'update'])->name('klanten.update');
});
Route::post('/toggle-maintenance', [MaintenanceController::class, 'toggle'])->name('toggle.maintenance');

require __DIR__ . '/auth.php';
