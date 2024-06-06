<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OperasiController extends Controller
{
    public function kodePaket(Request $request)
    {
        $paket = DB::table('paket_operasi')->get();
    
        return response()->json([
            'success' => true,
            'message' => 'Data paket operasi berhasil dimuat',
            'data' => $paket
        ]);
    } 

    public function kodeRuangan(Request $request)
    {
        $paket = DB::table('ruang_ok')->get();
    
        return response()->json([
            'success' => true,
            'message' => 'Data paket operasi berhasil dimuat',
            'data' => $paket
        ]);
    }

    public function Boking(Request $request)
    {
        $request->validate([
            'no_rawat' => 'required',
            'kode_paket' => 'required',
            'tanggal' => 'required', 
            'jam_mulai' => 'required', 
            'jam_selesai' => 'required', 
            'kd_dokter' => 'required', 
            'kd_ruang_ok' => 'required', 
        ]);
        
        $booking = [
            'no_rawat' => $request->input('no_rawat'),
            'kode_paket' => $request->input('kode_paket'),
            'tanggal' => $request->input('tanggal'),
            'jam_mulai' => $request->input('jam_mulai'),
            'jam_selesai' => $request->input('jam_selesai'),
            'status' => 'menunggu',
            'kd_dokter' => $request->input('kd_dokter'),
            'kd_ruang_ok' => $request->input('kd_ruang_ok'),
        ];

        DB::table('booking_operasi')->insert($booking);
    
        return response()->json([
            'success' => true,
            'message' => 'sudah masuk cokm ',
            'data' => $booking,
        ]); 
    }
}
