<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataTriaseIgd;
use App\Models\RegPeriksa;
use Database\Seeders\ReqPeriksaSeeder;
use Illuminate\Http\Request;

class TriaseController extends Controller
{
    public function tampilTriase(Request $request)
    {
        $no_rawat = $request->input('no_rawat');

        $pasien = RegPeriksa::with(['pasien','dokter','dataTriase.kasus','dataTriase.igdpremier.petugas','dataTriase.igdsekunder.petugas'])
            ->where('no_rawat', $no_rawat)
            ->get();


        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $pasien,
        ]);
    }
}
