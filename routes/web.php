<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [BookController::class, 'home'])->name('home');

Route::get('/search', [BookController::class, 'search'])->name('search');

Route::get('/form', [BookController::class, 'form'])->name('form');

Route::post('/form', [BookController::class, 'register']);

Route::get('/{any?}', fn() => redirect()->route('home'))->where('any', '.+');
