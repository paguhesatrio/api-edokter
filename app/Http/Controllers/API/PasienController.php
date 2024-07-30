<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RegPeriksa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function tampilpasien(Request $request)
    {
        $dokter = Auth::user()->nik;
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        $pasien = RegPeriksa::with(['pasien', 'poliklinik'])
            ->where('kd_dokter', $dokter)
            ->whereDate('tgl_registrasi', $tanggal)
            ->where('status_lanjut', '!=', 'Ranap')
            ->get();
    
        return response()->json([
            'success' => true,
            'message' => 'Data pasien berhasil dimuat',
            'data' => $pasien
        ]);
    }
}
