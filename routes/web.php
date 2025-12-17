<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/podcasts/{podcast}', [HomeController::class, 'show'])->name('podcasts.show');
Route::post('/podcasts/{podcast}/access', [HomeController::class, 'verifyAccessCode'])->name('podcasts.access');

use App\Http\Controllers\AudioController;
Route::get('/stream/audio/{episode}', [AudioController::class, 'stream'])->name('audio.stream');
Route::get('/episodes/{episode}/url', [AudioController::class, 'getUrl'])->name('audio.url');