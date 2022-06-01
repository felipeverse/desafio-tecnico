<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContatoController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\ContatoController::class, 'index'])->name('home');
Route::get('contato/create', [App\Http\Controllers\ContatoController::class, 'create']);
Route::post('contato', [App\Http\Controllers\ContatoController::class, 'store']);
Route::get('contato/{contato}/edit', [App\Http\Controllers\ContatoController::class, 'edit']);
Route::get('contato/{contato}', [App\Http\Controllers\ContatoController::class, 'show']);
Route::put('contato/{contato}', [App\Http\Controllers\ContatoController::class, 'update']);
Route::delete('contato/{contato}', [App\Http\Controllers\ContatoController::class, 'destroy']);
