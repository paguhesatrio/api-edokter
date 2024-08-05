<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GambarRadiologi;
use App\Models\HasilRadiologi;
use App\Models\PermintaanRadiologi;
use App\Models\RegPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RadiologiController extends Controller
{
    public function FormRadiologi(Request $request)
    {
        // Mengambil input no_rawat dari request
        $no_rawat = $request->input('no_rawat');

        // Mengambil data pasien berdasarkan no_rawat
        $pasien = RegPeriksa::with('pasien')->where('no_rawat', $no_rawat)->first();

        // Mengecek apakah pasien ditemukan
        if (!$pasien) {
            return response()->json([
                'message' => 'Pasien tidak ditemukan',
            ], 404); // Mengembalikan respons 404 jika pasien tidak ditemukan
        }

        // Mengambil data jenis perawatan radiologi
        $pemeriksaan = DB::table('jns_perawatan_radiologi')->get();

        // Mengembalikan hasil dalam format JSON
        return response()->json([
            'pasien' => $pasien,
            'pemeriksaan' => $pemeriksaan
        ]);
    }

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

    public function hasilRadiologi(Request $request)
    {
        $request->validate([
            'tgl_periksa' => 'required|date',
        ]);
    
        // Ambil data dari request
        $tgl_periksa = $request->input('tgl_periksa');
    
        // Ambil data gambar radiologi dengan relasi regperiksa
        $gambarRadiologi = GambarRadiologi::with('regperiksa')
            ->whereDate('tgl_periksa', $tgl_periksa)
            ->get();
    
        if ($gambarRadiologi->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan untuk tanggal yang diberikan',
            ], 404);
        }
    
        // Ambil no_rawat dari data gambar radiologi yang didapat
        $no_rawat = $gambarRadiologi->pluck('no_rawat');
    
        // Ambil data pasien berdasarkan no_rawat dari RegPeriksa
        $pasien = RegPeriksa::with(['pasien','dokter'])
            ->whereIn('no_rawat', $no_rawat)
            ->get();
    
        // Ambil data hasil radiologi berdasarkan no_rawatS
        $hasilRadiologi = HasilRadiologi::whereIn('no_rawat', $no_rawat)
            ->get();
    
        // Ambil data permintaan radiologi beserta pemeriksaannya
        $permintaanRadiologi = PermintaanRadiologi::with(['periksaRadiologi.kdjenis'])
            ->whereIn('no_rawat', $no_rawat)
            ->get();
    
        // Gabungkan gambar radiologi dengan hasil radiologi, data pasien, dan permintaan radiologi
        foreach ($gambarRadiologi as $p) {
            // Inisialisasi properti hasil_radiologi dan pasien dengan nilai null
            $p->hasil_radiologi = null;
            $p->pasien = null;
    
            // Gabungkan hasil radiologi
            foreach ($hasilRadiologi as $hr) {
                if ($p->tgl_periksa == $hr->tgl_periksa && $p->jam == $hr->jam) {
                    $p->hasil_radiologi = $hr->hasil;
                    break;
                }
            }
    
            // Gabungkan data pasien
            foreach ($pasien as $ps) {
                if ($ps->no_rawat == $p->no_rawat) {
                    $p->pasien = $ps->pasien;
                    $p->dokter = $ps->dokter;
                    break;
                }
            }
    
            // Gabungkan data permintaan radiologi
            foreach ($permintaanRadiologi as $pr) {
                if ($p->no_rawat == $pr->no_rawat) {
                    $p->permintaan_radiologi = $pr;
                    break;
                }
            }
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Gambar dan Hasil Radiologi ditemukan',
            'data' => $gambarRadiologi,
        ]);
    }

    public function inputhasilRadiologi(Request $request)
    {
        // Validate the request
        $request->validate([
            'no_rawat' => 'required',
            'tgl_periksa' => 'required|date',
            'jam' => 'required|date_format:H:i:s',
            'hasil' => 'required',
        ]);

        // Prepare data for insertion or update
        $no_rawat = $request->input('no_rawat');
        $tgl_periksa = $request->input('tgl_periksa');
        $jam = $request->input('jam');
        $hasil = $request->input('hasil');

        try {
            // Query to check if the radiology result already exists
            $existingHasilRadiologi = DB::table('hasil_radiologi')
                ->where('no_rawat', $no_rawat)
                ->where('tgl_periksa', $tgl_periksa)
                ->where('jam', $jam)
                ->first();

            if ($existingHasilRadiologi) {
                // Update the existing radiology result
                DB::table('hasil_radiologi')
                    ->where('no_rawat', $no_rawat)
                    ->where('tgl_periksa', $tgl_periksa)
                    ->where('jam', $jam)
                    ->update(['hasil' => $hasil]);

                // Return success response for update
                return response()->json([
                    'success' => true,
                    'message' => 'Hasil radiologi berhasil diperbarui',
                    'data' => [
                        'radiologi' => array_merge((array) $existingHasilRadiologi, ['hasil' => $hasil])
                    ],
                ]);
            } else {
                // Insert new radiology result
                $hasilRadiologi = [
                    'no_rawat' => $no_rawat,
                    'tgl_periksa' => $tgl_periksa,
                    'jam' => $jam,
                    'hasil' => $hasil,
                ];

                DB::table('hasil_radiologi')->insert($hasilRadiologi);

                // Return success response for insertion
                return response()->json([
                    'success' => true,
                    'message' => 'Hasil radiologi berhasil ditambahkan',
                    'data' => [
                        'radiologi' => $hasilRadiologi
                    ],
                ], 201); // 201 Created
            }
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan atau memperbarui hasil radiologi',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }
    
}
