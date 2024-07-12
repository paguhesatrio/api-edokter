<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RadiologiController extends Controller
{
    public function permintaanRadiologi(Request $request)
    {
        $request->validate([
            'no_rawat' => 'required',
            'informasi_tambahan' => 'required',
            'diagnosa_klinis' => 'required',
            'kd_jenis_prw' => 'required|array',
        ]);
    
        // Mengambil kode dokter dari token
        $kdDokter = Auth::user()->nik;
    
        // Mendapatkan tanggal saat ini
        $tanggalSekarang = date('Ymd');
        $jamSekarang = date('H:i:s');
    
        // Menghitung nomor antrian berdasarkan jumlah permintaan radiologi pada hari tersebut
        $jumlahRadiologiHariIni = DB::table('permintaan_radiologi')
            ->whereDate('tgl_permintaan', '=', date('Y-m-d'))
            ->count();
    
        $noOrder = "PR" . $tanggalSekarang . str_pad($jumlahRadiologiHariIni + 1, 4, '0', STR_PAD_LEFT);
    
        $radiologi = [
            'noorder' => $noOrder,
            'no_rawat' => $request->input('no_rawat'),
            'tgl_permintaan' =>  $tanggalSekarang,
            'jam_permintaan' => $jamSekarang,
            'tgl_sampel' => '0000-00-00',
            'jam_sampel' => '00:00:00',
            'tgl_hasil' => '0000-00-00',
            'jam_hasil' => '00:00:00',
            'dokter_perujuk' =>  $kdDokter,
            'status' => 'ralan',
            'informasi_tambahan' => $request->input('informasi_tambahan'),
            'diagnosa_klinis' => $request->input('diagnosa_klinis'),
        ];
    
        DB::table('permintaan_radiologi')->insert($radiologi);
    
        $kdJenisPrwList = $request->input('kd_jenis_prw');
    
        foreach ($kdJenisPrwList as $kdJenisPrw) {
            $detailRadiologi = [
                'noorder' => $noOrder,
                'kd_jenis_prw' => $kdJenisPrw,
                'stts_bayar' => 'Belum',
            ];
    
            DB::table('permintaan_pemeriksaan_radiologi')->insert($detailRadiologi);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Permintaan radiologi berhasil ditambahkan',
            'data' => [
                'radiologi' => $radiologi, 
                'detailRadiologi' => $kdJenisPrwList,
            ],
        ]);
    }
    
}
