<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RegPeriksa;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function tampilAssesment(Request $request)
    {
        $no_rawat = $request->input('no_rawat');

        $pasien = RegPeriksa::with(['pasien','dokter','penilaianawalIgd.masalah.mastermasalah'])
            ->where('no_rawat', $no_rawat)
            ->get();


        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $pasien,
        ]);
    }
}
