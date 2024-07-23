<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameDirectoryController;

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

Route::get('/', [GameDirectoryController::class, 'home'])->name('home');
Route::get('/upload', [GameDirectoryController::class, 'upload'])->name('directories.upload');
Route::post('/scan', [GameDirectoryController::class, 'scanDirectory'])->name('directories.scan');
Route::get('/library', [GameDirectoryController::class, 'index'])->name('directories.index');
Route::get('/game/{id}', [GameDirectoryController::class, 'show'])->name('game.show');

Route::get('/check-api-key', function () {
    return env('RAWG_API_KEY', 'API key is missing');
});
