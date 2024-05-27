<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ObatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [LoginController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::get('tampilPasien', [PasienController::class, 'tampilPasien'])->middleware(['auth:sanctum']);
Route::get('tampilObat', [ObatController::class, 'tampilObat']);
Route::get('tampilAturanPakai', [ObatController::class, 'tampilAturanPakai']);
Route::post('tambahObat', [ObatController::class, 'tambahObat'])->middleware(['auth:sanctum']);
Route::post('tambahObatRacikan', [ObatController::class, 'tambahObatRacikan'])->middleware(['auth:sanctum']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
