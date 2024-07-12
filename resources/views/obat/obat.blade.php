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
                <input type="hidden" class="form-control" id="no_rawat" name="no_rawat" value="{{ $no_rawat }}"
                    readonly>
            </div>

            <div id="formContainer">
                <div class="obat-form" id="obatForm1">
                    <h2>Obat ke 1</h2>
                    <label for="kode_brng1">Kode Obat</label>
                    <div class="input-group mb-3">
                        <input type="text" id="kode_brng1" name="kode_brng[]" class="form-control" readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalObat"
                                data-field="kode_brng1">Pilih Obat</button>
                        </div>
                    </div>

                    <label for="jml1">Jumlah Obat</label>
                    <input type="number" name="jml[]" class="form-control" required>

                    <label for="aturan_pakai1">Aturan Pakai:</label>
                    <select name="aturan_pakai[]" class="form-control" required>
                        <option value="">Pilih aturan</option>
                        @foreach ($aturan as $item)
                            <option value="{{ $item->aturan }}">{{ $item->aturan }}</option>
                        @endforeach
                    </select>

                    <button type="button" class="btn btn-danger mt-2 removeForm" data-id="1">Hapus Obat</button>
                </div>
            </div>

            <div class="form-group">
                <input type="hidden" id="jmlh_obat" name="jmlh_obat" class="form-control" value="1" required>
            </div>

            <button type="submit" class="btn btn-primary mb-3 mt-3">Simpan</button>

        </form>
    </div>

    <!-- Modal Pilih Obat -->
    <div class="modal fade" id="modalObat" tabindex="-1" role="dialog" aria-labelledby="modalObatLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalObatLabel">Pilih Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @isset($obat)
                        @if ($obat->isEmpty())
                            <p>Tidak ada data obat.</p>
                        @else
                            <table id="tabelObat" class="display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Obat</th>
                                        <th>Stok</th>
                                        <th>Kandungan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($obat as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_brng }}</td>
                                            <td>{{ $item->barang->stok ?? 'N/A' }}</td>
                                            <td>{{ $item->letak_barang }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info pilih-obat-btn"
                                                    data-id="{{ $item->kode_brng }}"
                                                    data-nama="{{ $item->nama_brng }}">Pilih</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    @endisset
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#tabelObat').DataTable({
                "pageLength": 5
            });

            let formCount = 1;

            // Tambah form baru saat tombol Tambah Form diklik
            $('#addForm').click(function() {
                formCount++;

                const newForm = `
                <div class="obat-form mt-5" id="obatForm${formCount}">
                    <h2>Obat ke ${formCount}</h2>
                    <label for="kode_brng${formCount}">Kode Obat</label>
                    <div class="input-group mb-3">
                        <input type="text" id="kode_brng${formCount}" name="kode_brng[]" class="form-control" readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalObat" data-field="kode_brng${formCount}">Pilih Obat</button>
                        </div>
                    </div>
                    
                    <label for="jml${formCount}">Jumlah:</label>
                    <input type="number" name="jml[]" class="form-control" required>
                    
                    <label for="aturan_pakai${formCount}">Aturan Pakai:</label>
                    <select name="aturan_pakai[]" class="form-control" required>
                        <option value="">Pilih aturan</option>
                        @foreach ($aturan as $item)
                        <option value="{{ $item->aturan }}">{{ $item->aturan }}</option>
                        @endforeach
                    </select>
                    
                    <button type="button" class="btn btn-danger mt-2 removeForm" data-id="${formCount}">Hapus Obat</button>
                </div>
            `;

                $('#formContainer').append(newForm);

                // Update jumlah jenis obat
                $('#jmlh_obat').val(formCount);
            });

            // Tampilkan modal obat saat tombol Pilih Obat diklik
            $(document).on('click', '[data-toggle="modal"][data-target="#modalObat"]', function() {
                const fieldId = $(this).data('field');
                $('#modalObat').data('field', fieldId);
            });

            // Pilih obat dari modal
            $(document).on('click', '.pilih-obat-btn', function() {
                const selectedObatKode = $(this).data('id'); // Ambil kode obat
                const fieldId = $('#modalObat').data('field');
                $(`#${fieldId}`).val(selectedObatKode); // Masukkan kode obat ke input yang relevan
                $('#modalObat').modal('hide');
            });

            // Hapus form obat saat tombol Hapus Obat diklik
            $(document).on('click', '.removeForm', function() {
                const formId = $(this).data('id');
                $(`#obatForm${formId}`).remove();
                formCount--;

                // Update jumlah jenis obat
                $('#jmlh_obat').val(formCount);

                // Reindex the forms to maintain correct numbering
                $('.obat-form').each(function(index) {
                    $(this).find('h2').text(`Obat ke ${index + 1}`);
                });
            });
        });
    </script>

@endsection
