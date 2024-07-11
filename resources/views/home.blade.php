<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <title>E-Dokter - RSUD PMK</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white sticky-top navbar-light p-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand" style="color: #9c5518;"><i class="bi bi-hospital"></i> {{ auth()->user()->pegawai->nama }}
            </a>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="nav-link mx-3">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <form action="{{ route('home') }}" method="GET" class="mb-4 d-flex">
            @csrf
            <div class="row align-items-end">
                <div class="col-auto">
                    <label for="tanggal" class="form-label">Tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $tanggal ?? '') }}"
                        class="form-control" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary ms-2">Tampil Pasien</button>
                </div>
            </div>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @isset($pasien)
            <h2 class="mt-3 mb-3">Data Pasien untuk Tanggal: {{ $tanggal }}</h2>
            @if ($pasien->isEmpty())
                <p>Tidak ada data pasien untuk tanggal ini.</p>
            @else
                <table class="table table-bordered">
                    <thead class="table">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">No RM</th>
                            <th scope="col">No Rawat</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Poli</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pasien as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->no_rkm_medis }}</td>
                                <td>{{ $p->no_rawat }}</td>
                                <td>{{ $p->pasien->nm_pasien }}</td>
                                <td>{{ $p->kd_poli }}</td>
                                <td>
                                    <a href="{{ url('/perawatan?no_rawat=' . $p->no_rawat) }}"
                                        class="badge bg-info text-decoration-none">Eksekusi</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endisset
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="/js/main.js"></script>
    <!-- MDB JavaScript files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.12.0/mdb.min.js"></script>
</body>

</html>
