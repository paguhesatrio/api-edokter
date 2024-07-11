@extends('components.riwayat.mainRiwayat')
@section('container')

<div class="container">
    <h1>Riwayat Pengobatan</h1>
    <p>{{ $pasien->nm_pasien }}</p>

    @if (isset($history) && !$history->isEmpty())
        @foreach ($history as $no_rawat => $items)
            <div class="table-responsive mb-4">
                <h3>No Rawat : {{ $no_rawat }}</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Dokter</th>
                            <th>Cara Bayar</th>
                            <th>Tanggal Perawatan</th>
                            <th>Jam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @if (isset($dokter[$no_rawat]) && !$dokter[$no_rawat]->isEmpty())
                                <td>{{ $dokter[$no_rawat]->first()->dokter->nm_dokter }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>{{ $pasien->kd_pj }}</td>
                            <td>{{ $items->first()->tgl_perawatan }}</td>
                            <td>{{ $items->first()->jam }}</td>
                            <td>{{ $items->first()->status }}</td>
                        </tr>
                    </tbody>
                </table>

                <h4>Data Obat dan Aturan Pakai:</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Aturan Pakai</th>
                            <th>Jumlah</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->dataBarang->kode_brng }}</td>
                                <td>{{ $item->dataBarang->nama_brng }}</td>
                                <td>
                                    @if (isset($aturan[$no_rawat]))
                                        @php
                                            $aturanPakai = $aturan[$no_rawat]->flatMap(function($resep) use ($item) {
                                                return $resep->resepDokter->filter(function($itemAturan) use ($item) {
                                                    return $itemAturan->kode_brng == $item->dataBarang->kode_brng;
                                                });
                                            });
                                        @endphp
                                        @foreach ($aturanPakai as $itemAturan)
                                            {{ $itemAturan->aturan_pakai }}<br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $item->jml }}</td>
                                <td>{{ $item->dataBarang->kode_sat }}</td>
                                <td>{{ number_format($item->total, 0, ',', '.') }}</td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @else
        <p>Tidak ada riwayat pengobatan untuk nomor rekam medis ini.</p>
    @endif
</div>
@endsection
