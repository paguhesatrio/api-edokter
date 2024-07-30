<?php

use App\Http\Controllers\LabController;
use App\Http\Controllers\RadiologiController;
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

// soap
Route::get('/perawatan', [PerawatanController::class, 'FormSoap'])->name('perawatan.FormSoap');
Route::post('/perawatan', [PerawatanController::class, 'Soap'])->name('perawatan.soap');
Route::delete('/perawatan', [PerawatanController::class, 'Hapus'])->name('pemeriksaan.destroy');

// radiologi 
Route::get('/radiologi', [RadiologiController::class, 'FormRadiologi'])->name('permintaan.FormRadiologi');
Route::post('/radiologi', [RadiologiController::class, 'permintaanRadiologi'])->name('radiologi.store');

// Lab
Route::get('/lab', [LabController::class, 'tampilLab'])->name('lab.tampil');
Route::post('/lab/store', [LabController::class, 'Lab'])->name('lab.store');
Route::get('/lab/templates', [LabController::class, 'getTemplates'])->name('lab.templates');


// riwayat obat dan penunjnag
Route::get('/riwayatPengobatan', [RiwayatController::class, 'RiwayatPengobatan'])->name('riwayat.pengobatan');
Route::get('/riwayatPenunjang', [RiwayatController::class, 'RiwayatPenunjang'])->name('riwayat.penunjang');



