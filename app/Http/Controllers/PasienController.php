<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function tampilPasien(Request $request)
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
            'kode_brng' => 'required',
            'jml' => 'required',
            'aturan_pakai' => 'required',
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
    
        // Menyusun data obat baru
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
    
        // Menyimpan data ke tabel resep_obat
        DB::table('resep_obat')->insert($resep_obat);
        

       // tabel resep dokter
        $resep_dokter = [
            'no_resep' => $noResep,
            'kode_brng' =>	$request->input('kode_brng'),
            'jml'=>	$request->input('jml'),
            'aturan_pakai'=>$request->input('aturan_pakai'),
        ];
        DB::table('resep_dokter')->insert($resep_dokter);

        return response()->json([
            'success' => true,
            'message' => 'Data aturan pakai berhasil dimuat',
            'data1' => $resep_obat,
            'data' => $resep_dokter,
        ]);

    }    
}
