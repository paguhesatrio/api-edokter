<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function tampilpasien(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date'
        ]);
    
        $tanggal = $request->input('tanggal');
    
        $pasien = DB::table('reg_periksa')
                    ->whereDate('tgl_registrasi', $tanggal)
                    ->get();
    
        return response()->json([
            'success' => true,
            'message' => 'Data pasien berhasil dimuat',
            'data' => $pasien
        ]);
    }
}
