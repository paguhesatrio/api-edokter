@extends('components.main')

@section('container')

    <body>
        <div class="container mt-5">
            <h3>Data Pemeriksaan SOAP untuk {{ $pasien->pasien->nm_pasien }}</h3>

            <form action="{{ route('perawatan.soap') }}" method="GET" class="mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $tanggal ?? '' }}">
                    </div>
                    <input type="hidden" name="no_rawat" value="{{ $no_rawat }}">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>

            @if ($pemeriksaan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Copy</th>
                                <th>Delete</th>
                                <th>Tanggal</th>
                                <th>Pengisi</th>
                                <th>Objek</th>
                                <th>Subjek</th>
                                <th>Suhu Tubuh (°C)</th>
                                <th>Tensi (mmHg)</th>
                                <th>Tinggi (cm)</th>
                                <th>Berat (kg)</th>
                                <th>Nadi (/menit)</th>
                                <th>RR (/menit)</th>
                                <th>SpO2 (%)</th>
                                <th>GCS</th>
                                <th>Kesadaran</th>
                                <th>Lingkar Perut (cm)</th>
                                <th>Alergi</th>
                                <th>Asesmen</th>
                                <th>Plan</th>
                                <th>Instruksi</th>
                                <th>Evaluasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemeriksaan as $item)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-primary"
                                            onclick="copyToForm({{ json_encode($item) }})">Copy</button>
                                    </td>
                                    <td>
                                        <form
                                            action="{{ route('pemeriksaan.destroy', ['no_rawat' => $item->no_rawat, 'jam_rawat' => $item->jam_rawat]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                    <td>{{ $item->tgl_perawatan }}</td>
                                    <td>{{ $item->pegawai->nama }}</td>
                                    <td>{{ $item->pemeriksaan }}</td>
                                    <td>{{ $item->keluhan }}</td>
                                    <td>{{ $item->suhu_tubuh }}</td>
                                    <td>{{ $item->tensi }}</td>
                                    <td>{{ $item->tinggi }}</td>
                                    <td>{{ $item->berat }}</td>
                                    <td>{{ $item->nadi }}</td>
                                    <td>{{ $item->respirasi }}</td>
                                    <td>{{ $item->spo2 }}</td>
                                    <td>{{ $item->gcs }}</td>
                                    <td>{{ $item->kesadaran }}</td>
                                    <td>{{ $item->lingkar_perut }}</td>
                                    <td>{{ $item->alergi }}</td>
                                    <td>{{ $item->penilaian }}</td>
                                    <td class="text-truncate">{{ $item->rtl }}</td>
                                    <td>{{ $item->instruksi }}</td>
                                    <td>{{ $item->evaluasi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Tidak ada data pemeriksaan ralan untuk tanggal ini.</p>
            @endif
        </div>

        <div class="container mt-5">
            <h2 class="mt-3 mb-3">Soap Perawatan</h2>

            <form action="{{ route('perawatan.soap') }}" method="POST">
                @csrf

                <input type="hidden" name="no_rawat" value="{{ $no_rawat }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_rawat">No Rawat</label>
                            <input type="text" class="form-control" id="no_rawat" name="no_rawat"
                                value="{{ $no_rawat }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="pasien">Pasien</label>
                            <input type="text" class="form-control" id="pasien"
                                value="{{ $pasien->pasien->nm_pasien }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pemeriksaan">Objek</label>
                            <textarea class="form-control" id="pemeriksaan" name="pemeriksaan" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keluhan">Subjek</label>
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="suhu_tubuh">Suhu Tubuh (°C)</label>
                            <input type="number" class="form-control" id="suhu_tubuh" name="suhu_tubuh" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tensi">Tensi (mmHg)</label>
                            <input type="text" class="form-control" id="tensi" name="tensi" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tinggi">Tinggi (cm)</label>
                            <input type="number" class="form-control" id="tinggi" name="tinggi" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="berat">Berat (kg)</label>
                            <input type="number" class="form-control" id="berat" name="berat" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="nadi">Nadi (/menit)</label>
                            <input type="number" class="form-control" id="nadi" name="nadi" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="respirasi">RR (/menit)</label>
                            <input type="number" class="form-control" id="respirasi" name="respirasi" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="spo2">SpO2 (%)</label>
                            <input type="text" class="form-control" id="spo2" name="spo2" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="gcs">GCS</label>
                            <input type="text" class="form-control" id="gcs" name="gcs" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="kesadaran">Kesadaran</label>
                            <select class="form-control" id="kesadaran" name="kesadaran" required>
                                <option value="Compos Mentis">Compos Mentis</option>
                                <option value="Somnolence">Somnolence</option>
                                <option value="Sopor">Sopor</option>
                                <option value="Coma">Coma</option>
                                <option value="Apatis">Apatis</option>
                                <option value="Delirium">Delirium</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="lingkar_perut">Lingkar Perut (cm)</label>
                            <input type="text" class="form-control" id="lingkar_perut" name="lingkar_perut" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="alergi">Alergi</label>
                            <input type="text" class="form-control" id="alergi" name="alergi" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="penilaian">Asesmen</label>
                            <textarea class="form-control" id="penilaian" name="penilaian" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rtl">Plan</label>
                            <textarea class="form-control" id="rtl" name="rtl" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="instruksi">Instruksi</label>
                            <textarea class="form-control" id="instruksi" name="instruksi" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="evaluasi">Evaluasi</label>
                            <textarea class="form-control" id="evaluasi" name="evaluasi" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>


        <script>
            function copyToForm(item) {
                // Populate form fields with item data
                document.getElementById('no_rawat').value = item.no_rawat;
                document.getElementById('pemeriksaan').value = item.pemeriksaan;
                document.getElementById('keluhan').value = item.keluhan;
                document.getElementById('suhu_tubuh').value = item.suhu_tubuh;
                document.getElementById('tensi').value = item.tensi;
                document.getElementById('tinggi').value = item.tinggi;
                document.getElementById('berat').value = item.berat;
                document.getElementById('nadi').value = item.nadi;
                document.getElementById('respirasi').value = item.respirasi;
                document.getElementById('spo2').value = item.spo2;
                document.getElementById('gcs').value = item.gcs;
                document.getElementById('kesadaran').value = item.kesadaran;
                document.getElementById('lingkar_perut').value = item.lingkar_perut;
                document.getElementById('alergi').value = item.alergi;
                document.getElementById('penilaian').value = item.penilaian;
                document.getElementById('rtl').value = item.rtl;
                document.getElementById('instruksi').value = item.instruksi;
                document.getElementById('evaluasi').value = item.evaluasi;
            }
        </script>

    </body>
@endsection
