@extends('components.main')

@section('container')

<body>
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

                    <input type="hidden" class="form-control jumlah-obat-racikan" name="jmlh_obat_racikan[]" value="1"
                        readonly>

                    <button type="button" class="btn btn-secondary add-detail-racikan mt-3 mb-3">Tambah Obat</button>

                    <div class="detail-racikan-container">
                        <div class="detail-racikan">
                            <h2>obat 1</h2>
                            <button type="button" class="btn btn-danger remove-detail-racikan mt-3 mb-3">Hapus Obat</button>

                            <div class="form-group">
                                <label for="kode_brng">Obat</label>
                                <select class="form-control" name="kode_brng[0][]">
                                    <option value="">Pilih Obat</option>
                                    @foreach ($obat as $o)
                                        <option value="{{ $o->kode_brng }}">{{ $o->nama_brng }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" class="form-control" name="p1[0][]" value="1" required>

                            <input type="hidden" class="form-control" name="p2[0][]" value="1" required>

                            <div class="form-group">
                                <label for="kandungan">Kandungan</label>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to update the racikan headings
            function updateRacikanHeadings() {
                $('.racikan').each(function(index) {
                    $(this).find('h2').first().text(`Racikan ke ${index + 1}`);
                });
            }

            // Function to update the obat headings
            function updateObatHeadings(racikanElement) {
                racikanElement.find('.detail-racikan').each(function(index) {
                    $(this).find('h2').first().text(`obat ${index + 1}`);
                });
            }

            // Function to add a new racikan
            $('.add-racikan').on('click', function() {
                let racikanCount = $('.racikan').length;
                let newRacikan = $('.racikan:first').clone();
                newRacikan.find('input').val('');
                newRacikan.find('select').val('');
                newRacikan.find('.detail-racikan-container').html($('.detail-racikan:first').clone());
                newRacikan.find('.detail-racikan select').attr('name', `kode_brng[${racikanCount}][]`);
                newRacikan.find('.detail-racikan input[name^="p1"]').attr('name', `p1[${racikanCount}][]`);
                newRacikan.find('.detail-racikan input[name^="p2"]').attr('name', `p2[${racikanCount}][]`);
                newRacikan.find('.detail-racikan input[name^="kandungan"]').attr('name', `kandungan[${racikanCount}][]`);
                newRacikan.find('.detail-racikan input[name^="jml"]').attr('name', `jml[${racikanCount}][]`);
                newRacikan.find('.jumlah-obat-racikan').val('1');
                $('#racikan-container').append(newRacikan);
                $('#racikan-container').append('<hr class="border border-primary border-1 opacity-75">');
                updateRacikanHeadings();
                updateObatHeadings(newRacikan);
            });

            // Function to add a new detail racikan
            $(document).on('click', '.add-detail-racikan', function() {
                let racikanIndex = $(this).closest('.racikan').index();
                let newDetailRacikan = $(this).closest('.racikan').find('.detail-racikan:first').clone();
                newDetailRacikan.find('input').val('');
                newDetailRacikan.find('select').val('');
                newDetailRacikan.find('select').attr('name', `kode_brng[${racikanIndex}][]`);
                newDetailRacikan.find('input[name^="p1"]').attr('name', `p1[${racikanIndex}][]`);
                newDetailRacikan.find('input[name^="p2"]').attr('name', `p2[${racikanIndex}][]`);
                newDetailRacikan.find('input[name^="kandungan"]').attr('name', `kandungan[${racikanIndex}][]`);
                newDetailRacikan.find('input[name^="jml"]').attr('name', `jml[${racikanIndex}][]`);
                $(this).closest('.racikan').find('.detail-racikan-container').append(newDetailRacikan);

                // Increment the jumlah-obat-racikan value
                let jmlhObatRacikanInput = $(this).closest('.racikan').find('.jumlah-obat-racikan');
                let currentJmlh = parseInt(jmlhObatRacikanInput.val());
                jmlhObatRacikanInput.val(currentJmlh + 1);

                updateObatHeadings($(this).closest('.racikan'));
            });

            // Function to remove a racikan
            $(document).on('click', '.remove-racikan', function() {
                $(this).closest('.racikan').remove();
                updateRacikanHeadings();
            });

             // Function to remove a detail racikan
             $(document).on('click', '.remove-detail-racikan', function() {
                let detailRacikanContainer = $(this).closest('.detail-racikan-container');
                $(this).closest('.detail-racikan').remove();
                updateObatHeadings(detailRacikanContainer.closest('.racikan'));
            });

            
        });
    </script>
</body>
@endsection
