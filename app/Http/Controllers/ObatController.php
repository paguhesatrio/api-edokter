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
            $obat = DB::table('gudangbarang')->get();
           
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
    
        // Mendapatkan tanggal saat iniw
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

    public function tambahObatRacikan(Request $request)
    { 
        $request->validate([
            'no_rawat' => 'required',
            'jmlh_obat_racikan' => 'required|array',
            'nama_racik' => 'required|array',
            'kd_racik' => 'required|array',
            'jml_dr' => 'required|array',
            'aturan_pakai' => 'required|array',
            'keterangan' => 'required|array',
            'kode_brng' => 'required|array',
            'p1' => 'required|array',
            'p2' => 'required|array',
            'kandungan' => 'required|array',
            'jml' => 'required|array',
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
            'jam_peresepan' => $jamSekarang,
            'status' => 'ralan',
            'tgl_penyerahan' => $tanggalSekarang,  
            'jam_penyerahan' =>  "00:00:00",    
        ];
        DB::table('resep_obat')->insert($resep_obat);
    
        // Memasukkan resep dokter racikan sebanyak jmlh_obat_racikan
        $resep_dokter_racikan = [];
        $resep_dokter_racikan_detail = [];
        $jmlh_obat_racikan = $request->input('jmlh_obat_racikan');
    
        foreach ($jmlh_obat_racikan as $index => $jml) {
            // Menghasilkan no_racik secara otomatis
            $no_racik = $index + 1;
    
            // Tambahkan data ke tabel resep_dokter_racikan
            $resep_dokter_racikan[] = [
                'no_resep' => $noResep,
                'no_racik' => $no_racik,
                'nama_racik' => $request->input('nama_racik')[$index],
                'kd_racik' => $request->input('kd_racik')[$index],
                'jml_dr' => $request->input('jml_dr')[$index],
                'aturan_pakai' => $request->input('aturan_pakai')[$index],
                'keterangan' => $request->input('keterangan')[$index],
            ];
    
            // Tambahkan detail racikan sebanyak jumlah yang sesuai
            for ($i = 0; $i < $jml; $i++) {
                $resep_dokter_racikan_detail[] = [
                    'no_resep' => $noResep,
                    'no_racik' => $no_racik,
                    'kode_brng' => $request->input('kode_brng')[$index][$i],
                    'p1' => $request->input('p1')[$index][$i],
                    'p2' => $request->input('p2')[$index][$i],
                    'kandungan' => $request->input('kandungan')[$index][$i],
                    'jml' => $request->input('jml')[$index][$i],
                ];
            }
        }
    
        DB::table('resep_dokter_racikan')->insert($resep_dokter_racikan);
        DB::table('resep_dokter_racikan_detail')->insert($resep_dokter_racikan_detail);
    
        return response()->json([
            'success' => true,
            'message' => 'Data aturan pakai berhasil dimuat',
            'data2' => $resep_obat,
            'data1' => $resep_dokter_racikan,
            'data' => $resep_dokter_racikan_detail,
        ]); 
    }
    
    
}
