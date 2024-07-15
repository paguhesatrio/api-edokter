@extends('components.main')

@section('container')
    <!--  Bootstrap 4 untuk modal -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <div class="container">
        <h2 class="mt-3">Resep Obat</h2>

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

        <button type="button" id="addForm" class="btn btn-success mt-3 mb-3">Tambah Obat</button>

        <form action="{{ route('tambahObat') }}" method="POST" id="formObat">
            @csrf
            <div class="form-group">
                <input type="hidden" class="form-control" id="no_rawat" name="no_rawat" value="{{ $no_rawat }}" readonly>
            </div>

            <div id="formContainer">
                <div class="obat-form" id="obatForm1">
                    <h2>Obat ke 1</h2>
                    <div class="container mt-5">
                        <h2>Daftar Obat</h2>
                        <table id="tabelObat1" class="display">
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
                                            <button type="button" class="btn btn-info pilih-obat-btn" data-id="{{ $item->kode_brng }}" data-nama="{{ $item->nama_brng }}">Pilih</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label for="kode_brng1">Kode Obat</label>
                        <input type="text" id="kode_brng1" name="kode_brng[]" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="jml1">Jumlah Obat</label>
                        <input type="number" id="jml1" name="jml[]" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="aturan_pakai1">Aturan Pakai:</label>
                        <select id="aturan_pakai1" name="aturan_pakai[]" class="form-control" required>
                            <option value="">Pilih aturan</option>
                            @foreach ($aturan as $item)
                                <option value="{{ $item->aturan }}">{{ $item->aturan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" class="btn btn-danger mt-2 removeForm" data-id="1">Hapus Obat</button>
                </div>
            </div>

            <div class="form-group">
                <input type="hidden" id="jmlh_obat" name="jmlh_obat" class="form-control" value="1" required>
            </div>

            <button type="submit" class="btn btn-primary mb-3 mt-3">Simpan</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#tabelObat1').DataTable({
                "pageLength": 5
            });

            // Handle the selection of medicine
            $(document).on('click', '.pilih-obat-btn', function() {
                var id = $(this).data('id');
                // Find the closest .obat-form and get the id to update the correct input field
                var formId = $(this).closest('.obat-form').attr('id').match(/\d+/)[0];
                $('#kode_brng' + formId).val(id);
            });

            // Handle the addition of new medicine forms
            $('#addForm').click(function() {
                var formCount = $('.obat-form').length + 1;
                var formHtml = `
                    <div class="obat-form" id="obatForm${formCount}">
                        <h2>Obat ke ${formCount}</h2>
                        <div class="container mt-5">
                            <h2>Daftar Obat</h2>
                            <table id="tabelObat${formCount}" class="display">
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
                                                <button type="button" class="btn btn-info pilih-obat-btn" data-id="{{ $item->kode_brng }}" data-nama="{{ $item->nama_brng }}">Pilih</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label for="kode_brng${formCount}">Kode Obat</label>
                            <input type="text" id="kode_brng${formCount}" name="kode_brng[]" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label for="jml${formCount}">Jumlah Obat</label>
                            <input type="number" id="jml${formCount}" name="jml[]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="aturan_pakai${formCount}">Aturan Pakai:</label>
                            <select id="aturan_pakai${formCount}" name="aturan_pakai[]" class="form-control" required>
                                <option value="">Pilih aturan</option>
                                @foreach ($aturan as $item)
                                    <option value="{{ $item->aturan }}">{{ $item->aturan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="btn btn-danger mt-2 removeForm" data-id="${formCount}">Hapus Obat</button>
                    </div>
                `;
                $('#formContainer').append(formHtml);

                // Re-initialize DataTables for new table
                $(`#tabelObat${formCount}`).DataTable({
                    "pageLength": 5
                });

                // Update the number of forms
                $('#jmlh_obat').val(formCount);
            });

            // Handle the removal of medicine forms
            $('#formContainer').on('click', '.removeForm', function() {
                var id = $(this).data('id');
                $('#obatForm' + id).remove();

                // Update the number of forms
                var formCount = $('.obat-form').length;
                $('#jmlh_obat').val(formCount);
            });
        });
    </script>
@endsection
