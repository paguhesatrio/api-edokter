<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;
use App\Http\Controllers\PasienController;

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
    return view('index');
});

Route::get('/login', [Login::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [Login::class, 'authenticate']);
Route::post('/logout', [Login::class, 'logout'])->name('logout');

Route::get('/home', [PasienController::class, 'tampilpasien'])->middleware('auth')->name('home');

Route::get('/121', function () {
    return view('tes');
});