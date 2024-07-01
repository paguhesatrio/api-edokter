@extends('components.main')

@section('container')

<div class="container">
    <h1>Riwayat Pengobatan</h1>

    @if (isset($history) && !$history->isEmpty())
        @foreach ($history as $no_rawat => $items)
            <div>
                <h3>No Rawat: {{ $no_rawat }}</h3>
                <p><strong>Tanggal Perawatan:</strong> {{ $items->first()->tgl_perawatan }}</p>
                <p><strong>Jam:</strong> {{ $items->first()->jam }}</p>
                <p><strong>Status:</strong> {{ $items->first()->status }}</p>
                <p><strong>Kode Bangsal:</strong> {{ $items->first()->kd_bangsal }}</p>
                <p><strong>No. Batch:</strong> {{ $items->first()->no_batch }}</p>
                <p><strong>No. Faktur:</strong> {{ $items->first()->no_faktur }}</p>
                <h4>Data Barang:</h4>
                <ul>
                    @foreach ($items as $item)
                        <li>
                            <strong>Kode Barang:</strong> {{ $item->dataBarang->kode_brng }}<br>
                            <strong>Nama Barang:</strong> {{ $item->dataBarang->nama_brng }}<br>
                            <strong>Harga Beli:</strong> {{ $item->h_beli }}<br>
                            <strong>Biaya Obat:</strong> {{ $item->biaya_obat }}<br>
                            <strong>Jumlah:</strong> {{ $item->jml }}<br>
                            <strong>Total:</strong> {{ $item->total }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @else
        <p>Tidak ada riwayat pengobatan untuk nomor rekam medis ini.</p>
    @endif
</div>
@endsection
