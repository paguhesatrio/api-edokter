<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PerawatanController;
use App\Http\Controllers\RiwayatController;

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


// tambahobat
Route::get('/resepobat', [ObatController::class, 'resepObat'])->name('form-obat');
Route::post('/tambah-obat', [ObatController::class, 'tambahObat'])->name('tambahObat');

// tambahobat
Route::get('/resepracikan', [ObatController::class, 'resepRacikan'])->name('resep.racikan');
Route::post('/tambah-obat-racikan', [ObatController::class, 'tambahObatRacikan'])->name('tambah.obat.racikan');

Route::get('/perawatan', [PerawatanController::class, 'FormSoap'])->name('perawatan.FormSoap');
Route::post('/perawatan', [PerawatanController::class, 'Soap'])->name('perawatan.soap');
Route::delete('/perawatan', [PerawatanController::class, 'Hapus'])->name('pemeriksaan.destroy');

// riwayat obat dan penunjnag
Route::get('/riwayatPengobatan', [RiwayatController::class, 'RiwayatPengobatan'])->name('riwayat.pengobatan');


