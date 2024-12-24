<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DmController;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('deliveries', DeliveryController::class);
    Route::resource('items', ItemController::class);
    Route::resource('dms', DmController::class);
    Route::post('/items/{item}/buy', [ItemController::class, 'buy'])->name('items.buy');
});

Route::get('/account', function() {
    return view('account.account');
})->name('account')->middleware('auth');

require __DIR__.'/auth.php';
