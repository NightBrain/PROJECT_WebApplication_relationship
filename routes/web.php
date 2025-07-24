<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RandomController;

// User Random Page
Route::get('/', [RandomController::class, 'index']);
Route::post('/random', [RandomController::class, 'random'])->name('random');

// Admin
Route::get('/admin', [AdminController::class, 'dash'])->middleware(['auth', 'verified'])->name('admin.dash');
Route::prefix('admin')->group(function () {
    Route::get('/seniors', [AdminController::class, 'seniors'])->name('admin.seniors');
    Route::post('/seniors', [AdminController::class, 'storeSenior'])->name('admin.seniors.store');
    Route::post('/seniors/update/{id}', [AdminController::class, 'updateSenior'])->name('admin.seniors.update');
    Route::delete('/seniors/{id}', [AdminController::class, 'deleteSenior'])->name('admin.seniors.delete');
    Route::post('/seniors/import', [AdminController::class, 'importSeniors'])->name('admin.seniors.import');

    Route::get('/juniors', [AdminController::class, 'juniors'])->name('admin.juniors');
    Route::post('/juniors', [AdminController::class, 'storeJunior'])->name('admin.juniors.store');
    Route::post('/juniors/update/{id}', [AdminController::class, 'updateJunior'])->name('admin.juniors.update');
    Route::delete('/juniors/{id}', [AdminController::class, 'deleteJunior'])->name('admin.juniors.delete');
    Route::post('/juniors/import', [AdminController::class, 'importJuniors'])->name('admin.juniors.import');

    Route::get('/export-results', [AdminController::class, 'exportResults'])->name('admin.export.results');
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
