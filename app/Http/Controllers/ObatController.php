<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function tampilObat(Request $request)
    {
        $hasViewedPasien = true; 

        if ($hasViewedPasien) {
            $obat = DB::table('resep_dokter')->get();
           
            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil dimuat',
                'data' => $obat
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus melihat data pasien terlebih dahulu',
                'data' => null
            ], 403); 
        }
    }

    public function tampilAturanPakai(Request $request)
    {

        $obat = DB::table('master_aturan_pakai')->get();
           
        return response()->json([
            'success' => true,
            'message' => 'Data aturan pakai berhasil dimuat',
            'data' => $obat
        ]);
    } 

    public function tambahObat(Request $request)
    { 
        $request->validate([
            'no_rawat' => 'required',
            'kode_brng' => 'required|array',
            'jml' => 'required|array',
            'aturan_pakai' => 'required|array',
            'jmlh_obat' => 'required',
        ]);
    
        // Mendapatkan tanggal saat ini
        $tanggalSekarang = date('Ymd');
        $jamSekarang = date('H:i:s');
    
        // Menghitung nomor antrian berdasarkan jumlah resep pada hari tersebut
        $jumlahResepHariIni = DB::table('resep_obat')
                                ->whereDate('tgl_perawatan', '=', date('Y-m-d'))
                                ->count();
    
        $noResep = $tanggalSekarang . str_pad($jumlahResepHariIni + 1, 4, '0', STR_PAD_LEFT);
    
        // Mengambil kode dokter dari token
        $kdDokter = Auth::user()->nik;

        $resep_obat = [
            'no_resep' => $noResep,
            'tgl_perawatan' => null,
            'jam' => "00:00:00",
            'no_rawat' => $request->input('no_rawat'),
            'kd_dokter' => $kdDokter,
            'tgl_peresepan' => $tanggalSekarang,
            'jam_peresepan' => $jamSekarang ,
            'status' => 'ralan',
            'tgl_penyerahan' => $tanggalSekarang,  
            'jam_penyerahan' =>  "00:00:00",    
        ];
    
        // Simpan resep obat
        DB::table('resep_obat')->insert($resep_obat);
    
        // Memasukkan resep dokter sebanyak jmlh_obat
        $resep_dokter_data = [];
        for ($i = 0; $i < $request->input('jmlh_obat'); $i++) {
            $resep_dokter_data[] = [
                'no_resep' => $noResep,
                'kode_brng' => $request->input('kode_brng')[$i],
                'jml'=> $request->input('jml')[$i],
                'aturan_pakai'=> $request->input('aturan_pakai')[$i],
            ];
        }
    
        // Simpan resep dokter
        DB::table('resep_dokter')->insert($resep_dokter_data);
    
        return response()->json([
            'success' => true,
            'message' => 'Data aturan pakai berhasil dimuat',
            'data1' => $resep_obat,
            'data' => $resep_dokter_data,
        ]);
    }
    
}
