<?php

namespace App\Http\Controllers;

use App\Models\DetailpemberianObat;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Perawatan;
use App\Models\PeriksaLab;
use App\Models\PeriksaRadiologi;
use App\Models\RegPeriksa;
use App\Models\ResepDokter;
use App\Models\ResepObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function RiwayatPengobatan(Request $request)
    {
        $no_rkm_medis = $request->input('no_rkm_medis');

        $pasien = Pasien::with('ReqPeriksa')->find($no_rkm_medis);

        $no_rawats = $pasien->ReqPeriksa->pluck('no_rawat');

        $history = DetailpemberianObat::with('dataBarang')
            ->whereIn('no_rawat', $no_rawats)
            ->orderBy('tgl_perawatan', 'desc')
            ->get()
            ->groupBy('no_rawat');

        // dokter
        $dokter = RegPeriksa::with('dokter')
            ->whereIn('no_rawat', $no_rawats)
            ->get()
            ->groupBy('no_rawat');


        $aturan = ResepObat::with('resepDokter')
            ->whereIn('no_rawat', $no_rawats)
            ->get()
            ->groupBy('no_rawat');

        return view('riwayat.pengobatan', compact('history', 'no_rkm_medis', 'pasien', 'dokter', 'aturan'));
    }

    public function RiwayatPenunjang(Request $request)
    {
        $no_rkm_medis = $request->input('no_rkm_medis');

        // $no_rkm_medis ="162131";

        $pasien = Pasien::with('ReqPeriksa')->find($no_rkm_medis);

        $no_rawat = $pasien->ReqPeriksa->pluck('no_rawat');

        $history = PeriksaRadiologi::with('kdjenis')
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        $history1 = PeriksaLab::with('kdjenis')
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'tastes',
            'data' => $history,
            'daat1' => $history1
        ]);
    }
}
