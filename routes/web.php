<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\BuscaCEPController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('cep/{cep}', [BuscaCEPController::class, 'fetch']);

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\ContatoController::class, 'index'])->name('home');
    Route::get('/', [App\Http\Controllers\ContatoController::class, 'index'])->name('/');
    Route::resource('contatos', ContatoController::class);
});
