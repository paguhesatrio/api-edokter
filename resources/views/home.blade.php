@extends('componets.main')
@section('container')



<body>
    <div class="container">

        <form action="{{ route('home') }}" method="GET">
            @csrf
            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $tanggal ?? '') }}" required>
            <button type="submit">Tampil Pasien</button>
        </form>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @isset($pasien)
            <h2>Data Pasien untuk Tanggal: {{ $tanggal }}</h2>
            @if ($pasien->isEmpty())
                <p>Tidak ada data pasien untuk tanggal ini.</p>
            @else
                <table>
                    <tr>
                        <th>#</th>
                        <th>No RM</th>
                        <th>Nama</th>
                        <th>Action</th>
                        
                        <!-- Tambahkan kolom lain sesuai dengan data yang ada di tabel reg_periksa -->
                    </tr>
                    @foreach($pasien as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->no_rkm_medis }}</td>
                        <td>{{ $p->pasien->nm_pasien }}</td>
                        <td>
                        <a href="/form-obat" class="badge bg-info">tes</a>
                        </td>
                        
                    </tr>
                    @endforeach
                </table>
            @endif
        @endisset

    </div>

@endsection

