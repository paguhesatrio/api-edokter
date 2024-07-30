<?php

namespace App\Http\Controllers;

use App\Models\JnsPerawatanLab;
use App\Models\RegPeriksa;
use App\Models\TemplateLaboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LabController extends Controller
{
    public function tampilLab(Request $request)
    {
        $no_rawat = $request->input('no_rawat');

        $pasien = RegPeriksa::with('pasien')->where('no_rawat', $no_rawat)->first();

        $jnsPerawatanLab = JnsPerawatanLab::get(['kd_jenis_prw','nm_perawatan']);

        $kd_jenis_prw = $request->input('kd_jenis_prw');

        $templateLaboratorium = TemplateLaboratorium::where('kd_jenis_prw', $kd_jenis_prw)->get();

        return view('permintaan.lab', compact('no_rawat', 'pasien', 'jnsPerawatanLab','templateLaboratorium'));

    }

    public function Lab(Request $request)
    {
        $request->validate([
            'no_rawat'           => 'required',
            'informasi_tambahan' => 'required',
            'diagnosa_klinis'    => 'required',
            'detail_permintaan'  => 'required|array',
            'detail_permintaan.*.kd_jenis_prw' => 'required',
            'detail_permintaan.*.id_template' => 'required',
        ]);

        // Mendapatkan NIK dokter dari user yang sedang login
        $kdDokter = Auth::user()->nik;

        $tanggalSekarang = date('Ymd');
        $jamSekarang = date('H:i:s');

        // Menghitung nomor antrian berdasarkan jumlah permintaan lab pada hari tersebut
        $jumlahLabHariIni = DB::table('permintaan_lab')
            ->whereDate('tgl_permintaan', '=', date('Y-m-d'))
            ->count();

        $noOrder = "PK" . $tanggalSekarang . str_pad($jumlahLabHariIni + 1, 4, '0', STR_PAD_LEFT);

        // Membuat array untuk disimpan ke database
        $lab = [
            'noorder'            => $noOrder,
            'no_rawat'           => $request->input('no_rawat'),
            'tgl_permintaan'     => $tanggalSekarang,
            'jam_permintaan'     => $jamSekarang,
            'tgl_sampel'         => '0000-00-00',
            'jam_sampel'         => '00:00:00',
            'tgl_hasil'          => '0000-00-00',
            'jam_hasil'          => '00:00:00',
            'dokter_perujuk'     => $kdDokter,
            'status'             => 'ralan',
            'informasi_tambahan' => $request->input('informasi_tambahan'),
            'diagnosa_klinis'    => $request->input('diagnosa_klinis')
        ];

        DB::table('permintaan_lab')->insert($lab);

        // Mengambil array detail permintaan dari request
        $detailPermintaan = $request->input('detail_permintaan');

        foreach ($detailPermintaan as $detail) {
            $permintaanLab = [
                'noorder'       => $noOrder,
                'kd_jenis_prw'  => $detail['kd_jenis_prw'],
                'id_template'   => $detail['id_template'],
                'stts_bayar'    => 'Belum'
            ];

            DB::table('permintaan_detail_permintaan_lab')->insert($permintaanLab);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan lab berhasil disimpan',
            'data' => $lab,
            'data1' => $detailPermintaan
        ]);
    }
}
