<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerawatanController extends Controller
{
    public function Soap(Request $request)
    { 
        $request->validate([
            'no_rawat' => 'required',
            'suhu_tubuh' => '',
            'tensi' => '',
            'nadi' => '',
            'respirasi' => '',
            'tinggi' => '',
            'berat' => '',
            'spo2' => '',
            'gcs' => '',
            'kesadaran' => '',
            'keluhan' => '',
            'pemeriksaan' => '',
            'alergi' => '',
            'lingkar_perut' => '',
            'rtl' => '',
            'penilaian' => '',
            'instruksi' => '',
            'evaluasi' => '',
        ]);
        
        $tanggalSekarang = date('Ymd');
        $jamSekarang = date('H:i:s');
        $kdDokter = Auth::user()->nik;
        
        $soap = [
            'no_rawat' => $request->input('no_rawat'),
            'tgl_perawatan' => $tanggalSekarang,
            'jam_rawat' => $jamSekarang,
            'suhu_tubuh' => $request->input('suhu_tubuh')?? '', 
            'tensi' => $request->input('tensi')?? '', 
            'nadi' => $request->input('nadi')?? '', 
            'respirasi' => $request->input('respirasi')?? '', 
            'tinggi' => $request->input('tinggi')?? '', 
            'berat' => $request->input('berat')?? '', 
            'spo2' => $request->input('spo2')?? '', 
            'gcs' => $request->input('gcs')?? '', 
            'kesadaran' => $request->input('kesadaran')?? '', 
            'keluhan' => $request->input('keluhan')?? '', 
            'pemeriksaan' => $request->input('pemeriksaan')?? '', 
            'alergi' => $request->input('alergi')?? '', 
            'lingkar_perut' => $request->input('lingkar_perut')?? '', 
            'rtl' => $request->input('rtl')?? '', 
            'penilaian' => $request->input('penilaian')?? '', 
            'instruksi' => $request->input('instruksi') ?? '', 
            'evaluasi' => $request->input('evaluasi') ?? '', 
            'nip' => $kdDokter,
        ];
    
        // Simpan resep obat
        DB::table('pemeriksaan_ralan')->insert($soap);
    
        return response()->json([
            'success' => true,
            'message' => 'sudah masuk cokm ',
            'data' => $soap,
        ]); 
    }
}
