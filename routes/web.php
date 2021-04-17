<?php

use App\Http\Controllers\BookController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [BookController::class, 'home'])->name('home');

Route::get('/search', [BookController::class, 'search'])->name('search');

Route::get('/form/{book}', [BookController::class, 'form'])->name('form');

Route::get('/{any?}', fn() => redirect()->route('home'))->where('any', '.+');
