@extends('components.main')

@section('container')

<body>
    <!-- Bootstrap 4 untuk modal -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <div class="container mt-5">
        <h2>Resep Racikan</h2>
        <form action="{{ route('tambah.obat.racikan') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="no_rawat">No Rawat</label>
                <input type="text" class="form-control" id="no_rawat" name="no_rawat" value="{{ $no_rawat }}" readonly>
            </div>

            <div class="form-group">
                <label for="pasien">Pasien</label>
                <input type="text" class="form-control" id="pasien" value="{{ $pasien->pasien->nm_pasien }}" readonly>
            </div>

            <div id="racikan-container">
                <button type="button" class="btn btn-primary add-racikan mb-2 mt-3">Tambah Racikan</button>

                <div class="racikan mb-4">
                    <h2>Racikan ke 1</h2>
                    <button type="button" class="btn btn-danger remove-racikan mb-2 mt-3">Hapus Racikan</button>

                    <div class="form-group">
                        <label for="nama_racik">Nama Racik</label>
                        <input type="text" class="form-control" name="nama_racik[]" required>
                    </div>

                    <div class="form-group">
                        <label for="kd_racik">Metode Racik</label>
                        <select class="form-control" name="kd_racik[]">
                            <option value="">Pilih Metode</option>
                            @foreach ($metode as $m)
                                <option value="{{ $m->kd_racik }}">{{ $m->nm_racik }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jml_dr">Jumlah</label>
                        <input type="number" class="form-control" name="jml_dr[]" required>
                    </div>

                    <div class="form-group">
                        <label for="aturan_pakai">Aturan Pakai</label>
                        <select class="form-control" name="aturan_pakai[]">
                            <option value="">Pilih Aturan Pakai</option>
                            @foreach ($aturan as $a)
                                <option value="{{ $a->aturan }}">{{ $a->aturan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan[]" required>
                    </div>

                    <input type="hidden" class="form-control jumlah-obat-racikan" name="jmlh_obat_racikan[]" value="1" readonly>

                    <button type="button" class="btn btn-secondary add-detail-racikan mt-3 mb-3">Tambah Obat</button>

                    <div class="detail-racikan-container">
                        <div class="detail-racikan">
                            <h2>Obat 1</h2>
                            <button type="button" class="btn btn-danger remove-detail-racikan mt-3 mb-3">Hapus Obat</button>

                            <div class="container mt-5">
                                <h2>Daftar Obat</h2>
                                <table id="tabelObat" class="display">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Obat</th>
                                            <th>Kandungan</th>
                                            <th>Stok</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($obat as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama_brng }}</td>
                                                <td>{{ $item->letak_barang }}</td>
                                                <td>{{ $item->barang->stok ?? 'N/A' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info pilih-obat-btn"
                                                        data-id="{{ $item->kode_brng }}"
                                                        data-nama="{{ $item->nama_brng }}">Pilih</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group">
                                <label for="kode_brng">Obat</label>
                                <input type="text" class="form-control" name="kode_brng[0][]" readonly required>
                            </div>

                            <input type="hidden" class="form-control" name="p1[0][]" value="1" required>
                            <input type="hidden" class="form-control" name="p2[0][]" value="1" required>

                            <div class="form-group">
                                <label for="kandungan">Kandungan (ML)</label>
                                <input type="text" class="form-control" name="kandungan[0][]" required>
                            </div>

                            <div class="form-group">
                                <label for="jml">Jumlah</label>
                                <input type="number" class="form-control" name="jml[0][]" required>
                            </div>
                        </div>
                        <hr class="border border-primary border-1 opacity-75">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-5">Simpan Racikan</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTable for the first table on page load
            initializeDataTable('#tabelObat');
    
            // Add Racikan
            $('.add-racikan').on('click', function() {
                let racikanCount = $('.racikan').length + 1;
                let racikanHtml = `
                    <div class="racikan mb-4">
                        <h2>Racikan ke ${racikanCount}</h2>
                        <button type="button" class="btn btn-danger remove-racikan mb-2 mt-3">Hapus Racikan</button>
    
                        <div class="form-group">
                            <label for="nama_racik">Nama Racik</label>
                            <input type="text" class="form-control" name="nama_racik[]" required>
                        </div>
    
                        <div class="form-group">
                            <label for="kd_racik">Metode Racik</label>
                            <select class="form-control" name="kd_racik[]">
                                <option value="">Pilih Metode</option>
                                @foreach ($metode as $m)
                                    <option value="{{ $m->kd_racik }}">{{ $m->nm_racik }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="form-group">
                            <label for="jml_dr">Jumlah</label>
                            <input type="number" class="form-control" name="jml_dr[]" required>
                        </div>
    
                        <div class="form-group">
                            <label for="aturan_pakai">Aturan Pakai</label>
                            <select class="form-control" name="aturan_pakai[]">
                                <option value="">Pilih Aturan Pakai</option>
                                @foreach ($aturan as $a)
                                    <option value="{{ $a->aturan }}">{{ $a->aturan }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan[]" required>
                        </div>
    
                        <input type="hidden" class="form-control jumlah-obat-racikan" name="jmlh_obat_racikan[]" value="1" readonly>
    
                        <button type="button" class="btn btn-secondary add-detail-racikan mt-3 mb-3">Tambah Obat</button>
    
                        <div class="detail-racikan-container">
                            <div class="detail-racikan">
                                <h2>Obat 1</h2>
                                <button type="button" class="btn btn-danger remove-detail-racikan mt-3 mb-3">Hapus Obat</button>
    
                                <div class="container mt-5">
                                    <h2>Daftar Obat</h2>
                                    <table class="display tabelObat">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Obat</th>
                                                <th>Kandungan</th>
                                                <th>Stok</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($obat as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->nama_brng }}</td>
                                                    <td>{{ $item->letak_barang }}</td>
                                                    <td>{{ $item->barang->stok ?? 'N/A' }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info pilih-obat-btn"
                                                            data-id="{{ $item->kode_brng }}"
                                                            data-nama="{{ $item->nama_brng }}">Pilih</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
    
                                <div class="form-group">
                                    <label for="kode_brng">Obat</label>
                                    <input type="text" class="form-control" name="kode_brng[${racikanCount - 1}][]" readonly required>
                                </div>
    
                                <input type="hidden" class="form-control" name="p1[${racikanCount - 1}][]" value="1" required>
                                <input type="hidden" class="form-control" name="p2[${racikanCount - 1}][]" value="1" required>
    
                                <div class="form-group">
                                    <label for="kandungan">Kandungan</label>
                                    <input type="text" class="form-control" name="kandungan[${racikanCount - 1}][]" required>
                                </div>
    
                                <div class="form-group">
                                    <label for="jml">Jumlah</label>
                                    <input type="number" class="form-control" name="jml[${racikanCount - 1}][]" required>
                                </div>
                            </div>
                            <hr class="border border-primary border-1 opacity-75">
                        </div>
                    </div>
                `;
                $('#racikan-container').append(racikanHtml);
                initializeDataTable('.tabelObat');
            });
    
            // Remove Racikan
            $(document).on('click', '.remove-racikan', function() {
                $(this).closest('.racikan').remove();
            });
    
            // Add Detail Racikan
            $(document).on('click', '.add-detail-racikan', function() {
                let detailRacikanContainer = $(this).siblings('.detail-racikan-container');
                let racikanIndex = $('.racikan').index($(this).closest('.racikan'));
                let detailRacikanCount = detailRacikanContainer.find('.detail-racikan').length + 1;
                let detailRacikanHtml = `
                    <div class="detail-racikan">
                        <h2>Obat ${detailRacikanCount}</h2>
                        <button type="button" class="btn btn-danger remove-detail-racikan mt-3 mb-3">Hapus Obat</button>
    
                        <div class="container mt-5">
                            <h2>Daftar Obat</h2>
                            <table class="display tabelObat">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Obat</th>
                                        <th>Kandungan</th>
                                        <th>Stok</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($obat as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_brng }}</td>
                                            <td>{{ $item->letak_barang }}</td>
                                            <td>{{ $item->barang->stok ?? 'N/A' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info pilih-obat-btn"
                                                    data-id="{{ $item->kode_brng }}"
                                                    data-nama="{{ $item->nama_brng }}">Pilih</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
                        <div class="form-group">
                            <label for="kode_brng">Obat</label>
                            <input type="text" class="form-control" name="kode_brng[${racikanIndex}][]" readonly required>
                        </div>
    
                        <input type="hidden" class="form-control" name="p1[${racikanIndex}][]" value="1" required>
                        <input type="hidden" class="form-control" name="p2[${racikanIndex}][]" value="1" required>
    
                        <div class="form-group">
                            <label for="kandungan">Kandungan</label>
                            <input type="text" class="form-control" name="kandungan[${racikanIndex}][]" required>
                        </div>
    
                        <div class="form-group">
                            <label for="jml">Jumlah</label>
                            <input type="number" class="form-control" name="jml[${racikanIndex}][]" required>
                        </div>
                    </div>
                    <hr class="border border-primary border-1 opacity-75">
                `;
                detailRacikanContainer.append(detailRacikanHtml);
                initializeDataTable('.tabelObat');
            });
    
            // Remove Detail Racikan
            $(document).on('click', '.remove-detail-racikan', function() {
                $(this).closest('.detail-racikan').remove();
            });
    
            // Pilih Obat
            $(document).on('click', '.pilih-obat-btn', function() {
                let kodeBrng = $(this).data('id');
                let namaBrng = $(this).data('nama');
                let closestDetailRacikan = $(this).closest('.detail-racikan');
    
                closestDetailRacikan.find('input[name^="kode_brng"]').val(kodeBrng);
                closestDetailRacikan.find('input[name^="nama_obat"]').val(namaBrng);
    
                $('#tabelObatModal').modal('hide');
            });
    
            // Function to initialize DataTable
            function initializeDataTable(selector) {
                $(selector).each(function() {
                    if (!$.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable({
                            "pageLength": 3
                        });
                    }
                });
            }
        });
    </script>
    
    
</body>
@endsection
