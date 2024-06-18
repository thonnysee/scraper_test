<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [SitesController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/site/scrape', [SitesController::class, 'create'])->middleware(['auth', 'verified'])->name('scrape_site');
Route::get('/site/{site}', [SitesController::class, 'show'])->middleware(['auth', 'verified'])->name('show_site');
Route::delete('/site/{site}', [SitesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('delete_site');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
