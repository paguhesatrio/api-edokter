<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Perawatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RegPeriksa;
use Carbon\Carbon;

class PerawatanController extends Controller
{

    public function FormSoap(Request $request)
    {
        $no_rawat = $request->input('no_rawat');
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        $pasien = RegPeriksa::with('pasien')->where('no_rawat', $no_rawat)->first();
        $nip = DB::table('pemeriksaan_ralan')->where('no_rawat', $no_rawat)->pluck('nip')->first();

        $pemeriksaan = Perawatan::with('pegawai')
            ->where('no_rawat', $no_rawat)
            ->whereDate('tgl_perawatan', $tanggal)
            ->get();

        return view('perawatan.soap', compact('no_rawat', 'pasien', 'tanggal', 'pemeriksaan'));
    }


    public function Soap(Request $request)
    {
        $request->validate([
            'no_rawat' => 'required',
            'suhu_tubuh' => 'required',
            'tensi' => 'required',
            'nadi' => 'required',
            'respirasi' => 'required',
            'tinggi' => 'required',
            'berat' => 'required',
            'spo2' => 'required',
            'gcs' => 'required',
            'kesadaran' => 'required',
            'keluhan' => 'required',
            'pemeriksaan' => 'required',
            'alergi' => 'required',
            'lingkar_perut' => 'required',
            'rtl' => 'required',
            'penilaian' => 'required',
            'instruksi' => 'required',
            'evaluasi' => 'required',
        ]);

        $tanggalSekarang = date('Ymd');
        $jamSekarang = date('H:i:s');
        $kdDokter = Auth::user()->nik;

        $soap = [
            'no_rawat' => $request->input('no_rawat'),
            'tgl_perawatan' => $tanggalSekarang,
            'jam_rawat' => $jamSekarang,
            'suhu_tubuh' => $request->input('suhu_tubuh'),
            'tensi' => $request->input('tensi'),
            'nadi' => $request->input('nadi'),
            'respirasi' => $request->input('respirasi'),
            'tinggi' => $request->input('tinggi'),
            'berat' => $request->input('berat'),
            'spo2' => $request->input('spo2'),
            'gcs' => $request->input('gcs'),
            'kesadaran' => $request->input('kesadaran'),
            'keluhan' => $request->input('keluhan'),
            'pemeriksaan' => $request->input('pemeriksaan'),
            'alergi' => $request->input('alergi'),
            'lingkar_perut' => $request->input('lingkar_perut'),
            'rtl' => $request->input('rtl'),
            'penilaian' => $request->input('penilaian'),
            'instruksi' => $request->input('instruksi'),
            'evaluasi' => $request->input('evaluasi'),
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

    public function Hapus(Request $request)
    {
        $no_rawat = $request->input('no_rawat');
        $jam_rawat = $request->input('jam_rawat');

        // Find the record to delete
        $perawatan = DB::table('pemeriksaan_ralan')
            ->where('no_rawat', $no_rawat)
            ->where('jam_rawat', $jam_rawat)
            ->first();

        // Check if the record exists before deleting
        if ($perawatan) {
            // Delete the record
            DB::table('pemeriksaan_ralan')
                ->where('no_rawat', $no_rawat)
                ->where('jam_rawat', $jam_rawat)
                ->delete();

            return redirect()->back()->with('success', 'Data has been deleted successfully.');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Record not found or already deleted.',
            ]);
        }
    }
}
