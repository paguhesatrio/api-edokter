<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function tampilPasien(Request $request)
    {
        $pasien = DB::table('reg_periksa')->get();
       
        return response()->json([
            'success' => true,
            'message' => 'Data pasien berhasil dimuat',
            'data' => $pasien
        ]);
    }
}
