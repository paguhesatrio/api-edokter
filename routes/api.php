<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PerawatanController;
use App\Http\Controllers\OperasiController;
use App\Http\Controllers\LabController;

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
// login
Route::post('register', [LoginController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

// obat
Route::get('tampilPasien', [PasienController::class, 'tampilPasien'])->middleware(['auth:sanctum']);
Route::get('tampilObat', [ObatController::class, 'tampilObat']);
Route::get('tampilAturanPakai', [ObatController::class, 'tampilAturanPakai']);
Route::post('tambahObat', [ObatController::class, 'tambahObat'])->middleware(['auth:sanctum']);
Route::post('tambahObatRacikan', [ObatController::class, 'tambahObatRacikan'])->middleware(['auth:sanctum']);

// soap
Route::post('Soap', [PerawatanController::class, 'Soap'])->middleware(['auth:sanctum']);

// permintaan Operasi
Route::get('kodePaket', [OperasiController::class, 'kodePaket']);
Route::get('kodeRuangan', [OperasiController::class, 'kodeRuangan']);
Route::post('boking', [OperasiController::class, 'boking']);

// lab
Route::post('Lab', [LabController::class, 'Lab'])->middleware(['auth:sanctum']);;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
