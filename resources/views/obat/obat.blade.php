@extends('components.main')

@section('container')

<body>
    <div class="container">

        <h2 class="mt-3">Resep Obat</h2>

        <button type="button" id="addForm" class="btn btn-success mt-3 mb-3">Tambah Obat</button>

        <form action="{{ route('tambahObat') }}" method="POST" id="formObat">
            @csrf
            <div class="form-group">
                <label for="no_rawat">No Rawat</label>
                <input type="text" class="form-control" id="no_rawat" name="no_rawat" value="{{ $no_rawat }}" readonly>
            </div>

            <div class="form-group">
                <label for="pasien">Pasien</label>
                <input type="text" class="form-control" id="pasien" value="{{ $pasien->pasien->nm_pasien }}" readonly>
            </div>

            <div id="formContainer">
                <div class="form-group">
                    <h2>Obat ke 1</h2>
                    <label for="kode_brng">Nama Obat</label>
                    <select name="kode_brng[]" class="form-control" required>
                        <option value="">Pilih Obat</option>
                        @foreach ($obat as $item)
                            <option value="{{ $item->kode_brng }}">{{ $item->nama_brng }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jml">Jumlah Obat</label>
                    <input type="number" name="jml[]" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="aturan_pakai">Aturan Pakai:</label>
                    <select name="aturan_pakai[]" class="form-control" required>
                        <option value="">Pilih aturan</option>
                        @foreach ($aturan as $item)
                            <option value="{{ $item->aturan }}">{{ $item->aturan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <input type="hidden" id="jmlh_obat" name="jmlh_obat" class="form-control" value="1" required>
            </div>

            <button type="submit" class="btn btn-primary mb-3 mt-3">Simpan</button>

        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let formCount = 1;

            // Tambah form baru saat tombol Tambah Form diklik
            $('#addForm').click(function() {
                formCount++;

                const newForm = `
                <div class="obat-form" id="obatForm${formCount}">
                    <h2>Obat ke ${formCount}</h2>
                    <label for="kode_brng${formCount}">Nama Obat</label>
                    <select name="kode_brng[]" class="form-control" required>
                        <option value="">Pilih Obat</option>
                        @foreach ($obat as $item)
                            <option value="{{ $item->kode_brng }}">{{ $item->nama_brng }}</option>
                        @endforeach
                    </select>
                    
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
</body>
@endsection
