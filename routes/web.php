<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransfersController;

Route::get('/', function () {

    $response = Http::withHeader('X-Api-Key', 'x2NwBUDx3qbob1SNHMqYZA==xqzRDmXcXY1CzN2B')
        ->get('https://api.api-ninjas.com/v1/quotes');

    return view('welcome')->with([
        'quote' => $response->collect()->first(),
    ]);
});

Route::get('/transfers/{hash}', [TransfersController::class, 'download'])
    ->name('download');
Route::post('/transfers', [TransfersController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
