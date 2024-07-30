<?php

namespace App\Http\Controllers;

use App\Models\DetailpemberianObat;
use App\Models\DetailPeriksaLab;
use App\Models\HasilRadiologi;
use App\Models\Pasien;
use App\Models\PeriksaLab;
use App\Models\PeriksaRadiologi;
use App\Models\RegPeriksa;
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

        return view('riwayat.pengobatan', compact('history', 'no_rkm_medis', 'pasien', 'dokter', 'aturan'));
    }

    public function RiwayatPenunjang(Request $request)
    {
        $no_rkm_medis = $request->input('no_rkm_medis');
    
        $pasien = Pasien::with('RegPeriksa')->find($no_rkm_medis);
    
        $no_rawat = $pasien->RegPeriksa->pluck('no_rawat');
    
        $radiologi = PeriksaRadiologi::with(['kdjenis', 'dokter'])
            ->whereIn('no_rawat', $no_rawat)
            ->get();
    
        $hasilradiologi = HasilRadiologi::whereIn('no_rawat', $no_rawat)->get();
    
        $gambarRadiologi = DB::table('gambar_radiologi')
            ->whereIn('no_rawat', $no_rawat)
            ->get();
    
        $lab = PeriksaLab::with('kdjenis')
            ->whereIn('no_rawat', $no_rawat)
            ->get();
    
        $detailLab = DetailPeriksaLab::with('laboratorium')
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        return view('riwayat.penunjang', compact('radiologi', 'lab', 'pasien', 'hasilradiologi', 'gambarRadiologi', 'detailLab'));
    }
    
}
