<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Permintaan Lab</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Buat Permintaan Lab</h1>

        <form action="{{ route('lab.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="no_rawat">No Rawat</label>
                <input type="text" class="form-control" id="no_rawat" name="no_rawat" value="{{ $no_rawat }}" readonly>
            </div>

            <div class="form-group">
                <label for="informasi_tambahan">Informasi Tambahan</label>
                <input type="text" class="form-control" id="informasi_tambahan" name="informasi_tambahan" required>
            </div>

            <div class="form-group">
                <label for="diagnosa_klinis">Diagnosa Klinis</label>
                <input type="text" class="form-control" id="diagnosa_klinis" name="diagnosa_klinis" required>
            </div>

            <div class="form-group">
                <label for="kd_jenis_prw">Kode Jenis Pemeriksaan</label>
                <select class="form-control" id="kd_jenis_prw" name="kd_jenis_prw" required>
                    <option value="">Pilih Kode Jenis Pemeriksaan</option>
                    @foreach($jnsPerawatanLab as $jenis)
                        <option value="{{ $jenis->kd_jenis_prw }}">{{ $jenis->nm_perawatan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_template">ID Template</label>
                <select class="form-control" id="id_template" name="id_template" required>
                    <option value="">Pilih ID Template</option>
                </select>
            </div>

            <div class="form-group">
                <label for="detail_permintaan">Detail Permintaan</label>
                <div id="detail_permintaan_wrapper">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control kd_jenis_prw" name="detail_permintaan[0][kd_jenis_prw]" placeholder="Kode Jenis Pemeriksaan" required>
                        <input type="text" class="form-control id_template" name="detail_permintaan[0][id_template]" placeholder="ID Template" required>
                        <button type="button" class="btn btn-danger remove-detail">Hapus</button>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="add-detail">Tambah Detail</button>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    const templates = @json($templateLaboratorium);

    function updateTemplates(kd_jenis_prw) {
        const templateDropdown = $('#id_template');
        templateDropdown.empty();
        templateDropdown.append('<option value="">Pilih ID Template</option>');
        
        const selectedTemplates = templates.filter(template => template.kd_jenis_prw === kd_jenis_prw);
        selectedTemplates.forEach(template => {
            templateDropdown.append('<option value="' + template.id_template + '">' + template.nama_template + '</option>');
        });

        $('#detail_permintaan_wrapper .id_template').val('');
        $('#detail_permintaan_wrapper .kd_jenis_prw').val(kd_jenis_prw);
    }

    $(document).ready(function() {
        let detailIndex = 1;

        $('#kd_jenis_prw').change(function() {
            const selectedKdJenisPrw = $(this).val();
            updateTemplates(selectedKdJenisPrw);
        });

        $('#id_template').change(function() {
            const selectedTemplate = $(this).val();
            $('#detail_permintaan_wrapper .id_template').val(selectedTemplate);
        });

        $('#add-detail').click(function() {
            const detailWrapper = $('#detail_permintaan_wrapper');
            const newDetail = $(`
                <div class="input-group mb-2">
                    <input type="text" class="form-control kd_jenis_prw" name="detail_permintaan[${detailIndex}][kd_jenis_prw]" placeholder="Kode Jenis Pemeriksaan" required>
                    <input type="text" class="form-control id_template" name="detail_permintaan[${detailIndex}][id_template]" placeholder="ID Template" required>
                    <button type="button" class="btn btn-danger remove-detail">Hapus</button>
                </div>
            `);
            detailWrapper.append(newDetail);
            detailIndex++;

            newDetail.find('.remove-detail').click(function() {
                $(this).parent().remove();
            });
        });

        $('.remove-detail').click(function() {
            $(this).parent().remove();
        });
    });
    </script>
</body>
</html>
