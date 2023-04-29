@extends('layout')
@section('title', 'Tambah Bahan Baku - Family Bakery')
@section('content')
    <style>
       .select2-container .select2-selection--single {
            height: auto;
            line-height: inherit;
            padding: 0.5rem 1rem;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: unset;
        }
    </style>
    <div class="container py-3">
        <form action="{{ route('pemesanan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Bahan Baku</label>
                <select class="livesearch form-control" name="nama_bahan_baku">
                    @foreach ($stok as $item)
                        <option value="{{ $item->nama_bahan_baku }}">{{ $item->nama_bahan_baku }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="">Jumlah Pesanan</label>
                <input type="number" class="form-control" name="jumlah_pesanan">
            </div>
            <div class="mb-3">
                <label for="">Harga Satuan</label>
                <input type="number" class="form-control" name="harga_satuan">
            </div>
            <div class="mb-3">
                <label for="">Status Pesanan</label>
                <select name="status_pesanan" id="" class="form-control">
                    <option value="Sedang Diantar">Sedang Diantar</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Dibayar">Dibayar</option>

                </select>
            </div>
            <div class="mb-3">
                <label for="">DP</label>
                <input type="number" class="form-control" name="dp">
            </div>
            <div class="mb-3">
                <label for="">Deadline DP</label>
                <input type="date" class="form-control" name="deadline_dp">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
@include('partials.scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.livesearch').select2();
    });
</script>
