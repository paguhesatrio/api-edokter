<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class LabController extends Controller
{
    public function Lab(Request $request)
    {
        $request->validate([
            'no_rawat'           => 'required',
            'tgl_permintaan'     => 'required',
            'jam_permintaan'     => 'required',
            'informasi_tambahan' => 'required',
            'diagnosa_klinis'    => 'required',
        ]);
    
        // Mendapatkan tanggal hari ini
        $today = Carbon::today()->format('Y-m-d');

        $tgl = $request->input('tgl_permintaan');
        
        // Menghitung jumlah antrian untuk hari ini
        $antrianHariIni = DB::table('permintaan_lab')
            ->whereDate('tgl_permintaan', $tgl )
            ->count();
    
        // Menambah 1 ke jumlah antrian untuk membuat nomor order berikutnya
        $nextAntrian = $antrianHariIni + 1;
        
        // Format nomor order
        $noOrder = 'PK' . str_replace('-', '', $tgl)  . sprintf('%04d', $nextAntrian);
    
        // Mendapatkan NIK dokter dari user yang sedang login
        $kdDokter = Auth::user()->nik;
    
        // Membuat array untuk disimpan ke database
        $lab = [
            'noorder'            => $noOrder,
            'no_rawat'           => $request->input('no_rawat'),
            'tgl_permintaan'     => $request->input('tgl_permintaan'),
            'jam_permintaan'     => $request->input('jam_permintaan'),
            'tgl_sampel'         => $today,
            'jam_sampel'         => '00:00:00',
            'tgl_hasil'          =>  $today,
            'jam_hasil'          => '00:00:00',
            'dokter_perujuk'     => $kdDokter,
            'status'             => 'ralan',
            'informasi_tambahan' => $request->input('informasi_tambahan'),
            'diagnosa_klinis'    => $request->input('diagnosa_klinis')
        ];


        //masih belum permintaan_detail_permintaan_lab karena bingung alurnya
    

        DB::table('permintaan_lab')->insert($lab);
    
        return response()->json([
            'success' => true,
            'message' => 'sudah masuk cokm',
            'data' => $lab,
        ]); 
    }
}
