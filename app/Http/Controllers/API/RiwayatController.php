<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailpemberianObat;
use App\Models\DetailPeriksaLab;
use App\Models\HasilRadiologi;
use App\Models\Pasien;
use App\Models\PeriksaLab;
use App\Models\PeriksaRadiologi;
use App\Models\RegPeriksa;
use App\Models\ResepObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function RiwayatPengobatan(Request $request)
    {
        $no_rkm_medis = $request->input('no_rkm_medis');
    
        // Ambil data pasien
        $pasien = Pasien::with('regPeriksa')->findOrFail($no_rkm_medis);
    
        // Ambil nomor rawat dari data pasien
        $no_rawats = $pasien->regPeriksa->pluck('no_rawat');
    
        // Ambil DetailPemberianObat dan ResepObat berdasarkan nomor rawat
        $history = DetailPemberianObat::with(['dataBarang'])
            ->whereIn('no_rawat', $no_rawats)
            ->orderBy('tgl_perawatan', 'desc')
            ->get()
            ->groupBy('no_rawat');
    
        $aturan = ResepObat::with('resepDokter')
            ->whereIn('no_rawat', $no_rawats)
            ->get()
            ->groupBy('no_rawat');
    
        $dokter = RegPeriksa::with('dokter')
            ->whereIn('no_rawat', $no_rawats)
            ->get()
            ->groupBy('no_rawat');
    
        $data = [];
    
        foreach ($history as $no_rawat => $items) {
            $data[$no_rawat] = [
                'no_rawat' => $no_rawat,
                'tgl_perawatan' => $items->first()->tgl_perawatan,
                'jam' => $items->first()->jam,
                'status' => $items->first()->status,
                'dokter' => isset($dokter[$no_rawat]) ? $dokter[$no_rawat]->first()->dokter->nm_dokter : '-',
                'cara_bayar' => $pasien->kd_pj,
                'obat' => $items->map(function ($item) use ($aturan, $no_rawat) {
                    $aturanPakai = isset($aturan[$no_rawat]) 
                        ? $aturan[$no_rawat]->flatMap(function ($resep) use ($item) {
                            return $resep->resepDokter->filter(function ($itemAturan) use ($item) {
                                return $itemAturan->kode_brng == $item->dataBarang->kode_brng;
                            });
                        }) 
                        : collect();
                    
                    return [
                        'kode_obat' => $item->dataBarang->kode_brng,
                        'nama_obat' => $item->dataBarang->nama_brng,
                        'aturan_pakai' => $aturanPakai->map(fn($itemAturan) => $itemAturan->aturan_pakai)->join('<br>'),
                        'jumlah' => $item->jml,
                        'tipe' => $item->dataBarang->kode_sat,
                        'harga' => number_format($item->total, 0, ',', '.'),
                    ];
                })
            ];
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'pasien' => [
                'nama' => $pasien->nm_pasien,
                'no_rkm_medis' => $pasien->no_rkm_medis
            ],
            'history' => $data
        ]);
    }
    

    public function RiwayatPenunjang(Request $request)
    {
        $no_rkm_medis = $request->input('no_rkm_medis');

        $pasien = Pasien::with('RegPeriksa')->find($no_rkm_medis);

        if (!$pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Pasien tidak ditemukan'
            ], 404);
        }

        $no_rawat = $pasien->RegPeriksa->pluck('no_rawat');

        $radiologi = PeriksaRadiologi::with(['kdjenis', 'dokter'])
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        $hasilradiologi = HasilRadiologi::whereIn('no_rawat', $no_rawat)
            ->get();

        $gambarRadiologi = DB::table('gambar_radiologi')
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        $lab = PeriksaLab::with(['kdjenis', 'dokter'])
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        $detailLab = DetailPeriksaLab::with('laboratorium')
            ->whereIn('no_rawat', $no_rawat)
            ->get();

        // Mengelompokkan data berdasarkan tgl_periksa
        $groupedData = [];

        foreach ($radiologi as $radiologiItem) {
            $key = $radiologiItem->tgl_periksa;
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'tgl_periksa' => $radiologiItem->tgl_periksa,
                    'radiologi' => [],
                    'gambarRadiologi' => [],
                    'hasilRadiologi' => [],
                    'lab' => [],
                    'detailLab' => []
                ];
            }
            $groupedData[$key]['radiologi'][] = [
                'no_rawat' => $radiologiItem->no_rawat,
                'nip' => $radiologiItem->nip,
                'jenis_pemeriksaan' => optional($radiologiItem->kdjenis)->nm_perawatan,
                'dokter_perujuk' => optional($radiologiItem->dokter)->nm_dokter,
                'biaya' => number_format($radiologiItem->biaya, 0, ',', '.'),
                'status' => $radiologiItem->status
            ];
        }

        foreach ($gambarRadiologi as $gambar) {
            $key = $gambar->tgl_periksa;
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'tgl_periksa' => $gambar->tgl_periksa,
                    'radiologi' => [],
                    'gambarRadiologi' => [],
                    'hasilRadiologi' => [],
                    'lab' => [],
                    'detailLab' => []
                ];
            }
            $groupedData[$key]['gambarRadiologi'][] = [
                'no_rawat' => $gambar->no_rawat,
                'lokasi_gambar' => $gambar->lokasi_gambar
            ];
        }

        foreach ($hasilradiologi as $hasil) {
            $key = $hasil->tgl_periksa;
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'tgl_periksa' => $hasil->tgl_periksa,
                    'radiologi' => [],
                    'gambarRadiologi' => [],
                    'hasilRadiologi' => [],
                    'lab' => [],
                    'detailLab' => []
                ];
            }
            $groupedData[$key]['hasilRadiologi'][] = [
                'no_rawat' => $hasil->no_rawat,
                'hasil' => $hasil->hasil
            ];
        }

        foreach ($lab as $labItem) {
            $key = $labItem->tgl_periksa;
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'tgl_periksa' => $labItem->tgl_periksa,
                    'radiologi' => [],
                    'gambarRadiologi' => [],
                    'hasilRadiologi' => [],
                    'lab' => [],
                    'detailLab' => []
                ];
            }
            $groupedData[$key]['lab'][] = [
                'no_rawat' => $labItem->no_rawat,
                'nip' => $labItem->nip,
                'jenis_pemeriksaan' => optional($labItem->kdjenis)->nm_perawatan,
                'dokter_perujuk' => optional($labItem->dokter)->nm_dokter,
                'biaya' => number_format($labItem->biaya, 0, ',', '.'),
                'status' => $labItem->status,
            ];
        }

        foreach ($detailLab as $labDetail) {
            $key = $labDetail->tgl_periksa;
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'tgl_periksa' => $labDetail->tgl_periksa,
                    'radiologi' => [],
                    'gambarRadiologi' => [],
                    'hasilRadiologi' => [],
                    'lab' => [],
                    'detailLab' => []
                ];
            }
            $groupedData[$key]['detailLab'][] = [
                'no_rawat' => $labDetail->no_rawat,
                'pemeriksaan' => optional($labDetail->laboratorium)->Pemeriksaan,
                'hasil' => $labDetail->nilai . ' ' . $labDetail->satuan,
                'nilai_rujukan' => $labDetail->nilai_rujukan,
                'biaya' => number_format($labDetail->biaya_item, 0, ',', '.'),
            ];
        }

        // Mengurutkan data yang dikelompokkan berdasarkan tgl_periksa
        krsort($groupedData);

        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'pasien' => [
                'nama' => $pasien->nm_pasien,
                'no_rkm_medis' => $pasien->no_rkm_medis
            ],
            'groupedData' => $groupedData
        ]);
    }
}
