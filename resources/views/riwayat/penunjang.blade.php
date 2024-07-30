@extends('components.riwayat.mainRiwayat')

@section('container')
    <div class="container mt-5">
        <h2>Riwayat Penunjang</h2>

        <div class="card mt-5 mb-5">
            <div class="card-body">
                <h5 class="card-title">Data Pasien</h5>
                <p class="card-text"><strong>Nama:</strong> {{ $pasien->nm_pasien }}</p>
                <p class="card-text"><strong>No Rekam Medis:</strong> {{ $pasien->no_rkm_medis }}</p>
            </div>
        </div>

        @php
            $groupedData = [];

            foreach ($radiologi as $radiologiItem) {
                $groupedData[$radiologiItem->tgl_periksa][$radiologiItem->jam]['radiologi'][] = $radiologiItem;
            }

            foreach ($lab as $labItem) {
                $groupedData[$labItem->tgl_periksa][$labItem->jam]['lab'][] = $labItem;
            }

            krsort($groupedData);
        @endphp

        @foreach ($groupedData as $tglPeriksa => $jamItems)
            <h3 class="mt-5 mb-5">Tanggal Periksa: {{ $tglPeriksa }}</h3>

            @foreach ($jamItems as $jam => $items)
                @if (isset($items['radiologi']) && count($items['radiologi']) > 0)
                    <h4>Radiologi</h4>
                    @foreach ($items['radiologi'] as $radiologiItem)
                        <table class="table table-bordered mb-5">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Jenis Pemeriksaan</th>
                                    <th>Tanggal Periksa</th>
                                    <th>Jam</th>
                                    <th>Dokter Perujuk</th>
                                    <th>Biaya</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $radiologiItem->nip }}</td>
                                    <td>{{ optional($radiologiItem->kdjenis)->nm_perawatan }}</td>
                                    <td>{{ $radiologiItem->tgl_periksa }}</td>
                                    <td>{{ $radiologiItem->jam }}</td>
                                    <td>{{ optional($radiologiItem->dokter)->nm_dokter }}</td>
                                    <td>{{ number_format($radiologiItem->biaya, 0, ',', '.') }}</td>
                                    <td>{{ $radiologiItem->status }}</td>
                                </tr>
                                <tr>
                                    <th colspan="7">Gambar Radiologi:</th>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        @php
                                            $gambarDitemukan = false;
                                        @endphp
                                        @foreach ($gambarRadiologi as $gambar)
                                            @if ($gambar->tgl_periksa == $radiologiItem->tgl_periksa && $gambar->jam == $radiologiItem->jam)
                                                <img src="https://app.rsudpmk.online/webapps/radiologi/{{ $gambar->lokasi_gambar }}"
                                                    alt="Gambar Radiologi" class="img-fluid"><br>
                                                @php
                                                    $gambarDitemukan = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if (!$gambarDitemukan)
                                            <p>Tidak ada gambar radiologi.</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="7">Hasil Radiologi:</th>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <ul>
                                            @php
                                                $hasilRadiologiDitemukan = false;
                                            @endphp
                                            @foreach($hasilradiologi as $hasil)
                                                @if ($hasil->tgl_periksa == $radiologiItem->tgl_periksa && $hasil->jam == $radiologiItem->jam)
                                                    <li>{{ $hasil->hasil }}</li>
                                                    @php
                                                        $hasilRadiologiDitemukan = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if (!$hasilRadiologiDitemukan)
                                                <p>Tidak ada hasil radiologi untuk tanggal dan jam ini.</p>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                @endif

                @if (isset($items['lab']) && count($items['lab']) > 0)
                    <h4>Laboratorium</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Tanggal Periksa</th>
                                <th>Jam</th>
                                <th>Dokter Perujuk</th>
                                <th>Biaya</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items['lab'] as $labItem)
                                <tr>
                                    <td>{{ $labItem->nip }}</td>
                                    <td>{{ optional($labItem->kdjenis)->nm_perawatan }}</td>
                                    <td>{{ $labItem->tgl_periksa }}</td>
                                    <td>{{ $labItem->jam }}</td>
                                    <td>{{ optional($labItem->dokter)->nm_dokter }}</td>
                                    <td>{{ number_format($labItem->biaya, 0, ',', '.') }}</td>
                                    <td>{{ $labItem->status }}</td>
                                </tr>
                                <tr>
                                    <th colspan="7">Detail Pemeriksaan Lab:</th>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Pemeriksaan</th>
                                                    <th>Hasil</th>
                                                    <th>Nilai Rujukan</th>
                                                    <th>Biaya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $detailLabDitemukan = false;
                                                @endphp
                                                @foreach ($detailLab as $labDetail)
                                                    @if ($labDetail->tgl_periksa == $labItem->tgl_periksa)
                                                        <tr>
                                                            <td>{{ optional($labDetail->laboratorium)->Pemeriksaan }}</td>
                                                            <td>{{ $labDetail->nilai }} {{ $labDetail->satuan }}</td>
                                                            <td>{{ $labDetail->nilai_rujukan }}</td>
                                                            <td>{{ number_format($labDetail->biaya_item, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @php
                                                            $detailLabDitemukan = true;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if (!$detailLabDitemukan)
                                                    <tr>
                                                        <td colspan="4">Tidak ada detail pemeriksaan lab.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endforeach
        @endforeach
    </div>
@endsection
