@extends('components.main')

@section('container')
    <div class="container mt-5 ">
        <h2>Permintaan Radiologi</h2>

        @if ($pasien)
            <div class="card mt-5 mb-5">
                <div class="card-body">
                    <h5 class="card-title">Data Pasien</h5>
                    <p class="card-text"><strong>Nama:</strong> {{ $pasien->pasien->nm_pasien }}</p>
                    <p class="card-text"><strong>No Rekam Medis:</strong> {{ $pasien->no_rkm_medis }}</p>
                    <p class="card-text"><strong>No Rawat:</strong> {{ $no_rawat }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('radiologi.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="hidden" class="form-control" id="no_rawat" name="no_rawat" value="{{ $no_rawat }}"
                    readonly>
            </div>
            <div class="form-group">
                <label for="informasi_tambahan">Informasi Tambahan Permintaan Foto</label>
                <textarea class="form-control" id="informasi_tambahan" name="informasi_tambahan" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="diagnosa_klinis">Indikasi Pemeriksaan / Diagnosa Klinis</label>
                <textarea class="form-control" id="diagnosa_klinis" name="diagnosa_klinis" rows="3" required></textarea>
            </div>

            <div class="form-group mt-3">
                <label for="kd_jenis_prw">Kode Jenis Pemeriksaan</label>
                <table id="pemeriksaanTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>Kode</th>
                            <th>Nama Pemeriksaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemeriksaan as $item)
                            <tr>
                                <td><input type="checkbox" name="kd_jenis_prw[]" value="{{ $item->kd_jenis_prw }}"></td>
                                <td>{{ $item->kd_jenis_prw }}</td>
                                <td>{{ $item->nm_perawatan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
        </form>
    </div>

    <!-- Include jQuery and DataTables JS/CSS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#pemeriksaanTable').DataTable();
        });
    </script>
@endsection
