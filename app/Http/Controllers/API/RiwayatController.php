<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailpemberianObat;
use App\Models\DetailPeriksaLab;
use App\Models\Dokter;
use App\Models\HasilRadiologi;
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

        $pasien = Pasien::with('regPeriksa')->findOrFail($no_rkm_medis);

        $no_rawats = $pasien->regPeriksa->pluck('no_rawat');

        $history = DetailPemberianObat::with(['dataBarang'])
            ->whereIn('no_rawat', $no_rawats)
            ->orderBy('tgl_perawatan', 'desc')
            ->get()
            ->groupBy('no_rawat');

        $aturan = ResepObat::with('resepDokter')
            ->whereIn('no_rawat', $no_rawats)
            ->get()
            ->groupBy('no_rawat');

        $dokter = RegPeriksa::with('dokter')
            ->whereIn('no_rawat', $no_rawats)
            ->get()
            ->groupBy('no_rawat');

        return response()->json([
            'success' => true,
            'message' => 'tastes',
            'data' => $history,
            'daat1' => $dokter,
            'resepObat' => $aturan
        ]);
    }

    public function RiwayatPenunjang(Request $request)
    {
        $no_rkm_medis = $request->input('no_rkm_medis');

        $pasien = Pasien::with('RegPeriksa')->find($no_rkm_medis);

        $no_rawat = $pasien->RegPeriksa->pluck('no_rawat');

        $radiologi = PeriksaRadiologi::with(['kdjenis', 'nip'])
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        $hasilradiologi = HasilRadiologi::whereIn('no_rawat', $no_rawat)
            ->get()
            ->keyBy('no_rawat');

        $gambarRadiologi = DB::table('gambar_radiologi')
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        $lab = PeriksaLab::with('kdjenis')
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        $detailLab = DetailPeriksaLab::with('laboratorium')
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        $dokter = RegPeriksa::with('dokter')
            ->whereIn('no_rawat', $no_rawat)
            ->get()
            ->groupBy('no_rawat');

        return response()->json([
            'success' => true,
            'message' => 'tastes',
            'data' => [
                'radiologi' => $radiologi,
                'hasilradiologi' => $hasilradiologi,
                'gambarRadiologi' => $gambarRadiologi,
                'lab' => $lab,
                'detailLab' => $detailLab,
                'dokter' => $dokter
            ]
        ]);
    }
}
