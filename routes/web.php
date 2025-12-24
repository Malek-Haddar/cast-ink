<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/podcasts/{podcast}', [HomeController::class, 'show'])->name('podcasts.show');
    Route::post('/podcasts/{podcast}/access', [HomeController::class, 'verifyAccessCode'])->name('podcasts.access');

    Route::get('/stream/audio/{episode}', [AudioController::class, 'stream'])->name('audio.stream');
    Route::get('/episodes/{episode}/url', [AudioController::class, 'getUrl'])->name('audio.url');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');