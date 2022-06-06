<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\BuscaCEPController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('cep/{cep}', [BuscaCEPController::class, 'fetch']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\ContatoController::class, 'index'])->name('home');
Route::resource('contatos', ContatoController::class);