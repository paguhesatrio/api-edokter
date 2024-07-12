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

        {{-- Initialize and populate groupedData --}}
        @php
            $groupedData = [];

            foreach ($radiologi as $item) {
                $groupedData[$item->no_rawat]['radiologi'][] = $item;
            }

            foreach ($lab as $item) {
                $groupedData[$item->no_rawat]['lab'][] = $item;
            }

            // Sort the grouped data by no_rawat in descending order
            krsort($groupedData);
        @endphp

        {{-- Loop through groupedData --}}
        @foreach ($groupedData as $noRawat => $items)
            <h3 class="mt-5 mb-5">No Rawat: {{ $noRawat }}</h3>

            {{-- Radiologi Table --}}
            @if (isset($items['radiologi']) && count($items['radiologi']) > 0)
                <h4>Radiologi</h4>
                <table class="table table-bordered mb-5">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>KD Jenis PRW</th>
                            <th>Tanggal Periksa</th>
                            <th>Jam</th>
                            <th>Dokter Perujuk</th>
                            <th>Biaya</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items['radiologi'] as $item)
                            <tr>
                                <td>{{ $item->nip }}</td>
                                <td>{{ optional($item->kdjenis)->nm_perawatan }}</td>
                                <td>{{ $item->tgl_periksa }}</td>
                                <td>{{ $item->jam }}</td>
                                <td>{{ optional($item->dokter)->nm_dokter }}</td>
                                <td>{{ number_format($item->biaya, 0, ',', '.') }}</td>
                                <td>{{ $item->status }}</td>
                            </tr>
                            <tr>
                                <th colspan="7">Gambar Radiologi:</th>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    @foreach ($gambarRadiologi as $gambar)
                                        @if ($gambar->no_rawat == $noRawat && $gambar->tgl_periksa == $item->tgl_periksa)
                                            <img src="http://172.16.17.253/webapps/radiologi/{{ $gambar->lokasi_gambar }}"
                                                alt="Gambar Radiologi"><br>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th colspan="7">Hasil Radiologi:</th>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    @foreach ($hasilradiologi as $hasil)
                                        @if ($hasil->no_rawat == $noRawat && $hasil->tgl_periksa == $item->tgl_periksa)
                                            {{ $hasil->hasil }}<br>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Tidak ada data Radiologi.</p>
            @endif

            {{-- Lab Table --}}
            @if (isset($items['lab']) && count($items['lab']) > 0)
                <h4>Lab</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>KD Jenis PRW</th>
                            <th>Tanggal Periksa</th>
                            <th>Jam</th>
                            <th>Dokter Perujuk</th>
                            <th>Biaya</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items['lab'] as $item)
                            <tr>
                                <td>{{ $item->nip }}</td>
                                <td>{{ optional($item->kdjenis)->nm_perawatan }}</td>
                                <td>{{ $item->tgl_periksa }}</td>
                                <td>{{ $item->jam }}</td>
                                <td>{{ optional($item->dokter)->nm_dokter }}</td>
                                <td>{{ number_format($item->biaya, 0, ',', '.') }}</td>
                                <td>{{ $item->status }}</td>
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
                                            @foreach ($detailLab as $lab)
                                                @if ($lab->no_rawat == $noRawat && $lab->tgl_periksa == $item->tgl_periksa)
                                                    <tr>
                                                        <td> {{ $lab->laboratorium->Pemeriksaan }}</td>
                                                        <td>{{ $lab->nilai }} {{ $lab->satuan }}</td>
                                                        <td>{{ $lab->nilai_rujukan }}</td>
                                                        <td>{{ number_format($lab->biaya_item, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Tidak ada data Laboratorium.</p>
            @endif
        @endforeach

    </div>
@endsection
