<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\PasienController;
use App\Http\Controllers\API\ObatController;
use App\Http\Controllers\API\PerawatanController;
use App\Http\Controllers\API\OperasiController;
use App\Http\Controllers\API\LabController;
use App\Http\Controllers\API\RadiologiController;
use App\Http\Controllers\API\RiwayatController;


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
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);


Route::get('tampilPasien', [PasienController::class, 'tampilPasien'])->middleware(['auth:sanctum']);

// obat
Route::get('resepObat', [ObatController::class, 'resepObat']);
Route::post('tambahObat', [ObatController::class, 'tambahObat'])->middleware(['auth:sanctum']);
//obat
Route::get('resepRacikan', [ObatController::class, 'resepRacikan']);
Route::post('tambahObatRacikan', [ObatController::class, 'tambahObatRacikan'])->middleware(['auth:sanctum']);

// soap
Route::post('soap', [PerawatanController::class, 'Soap'])->middleware(['auth:sanctum']);

// permintaan Operasi
Route::get('kodePaket', [OperasiController::class, 'kodePaket']);
Route::get('kodeRuangan', [OperasiController::class, 'kodeRuangan']);
Route::post('operasi', [OperasiController::class, 'boking'])->middleware(['auth:sanctum']);

// lab
Route::get('/tampilLab', [LabController::class, 'tampilLab'])->name('lab.form')->middleware(['auth:sanctum']);
Route::post('/lab/store', [LabController::class, 'Lab'])->name('lab.store');


//radiologi
Route::get('FormRadiologi', [RadiologiController::class, 'FormRadiologi']);
Route::post('radiologi', [RadiologiController::class, 'permintaanRadiologi'])->middleware(['auth:sanctum']);

//riwayat
Route::get('riwayatObat', [RiwayatController::class, 'RiwayatPengobatan']);

Route::get('riwayatPenunjang', [RiwayatController::class, 'RiwayatPenunjang']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
