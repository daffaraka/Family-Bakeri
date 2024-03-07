@extends('layout')
@section('title', 'Tambah Realisasi Produksi Roti - Family Bakery')
@section('content')

    <div class="container py-3" id="myModal" tabindex="-1">

        <form action="{{ route('realisasi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="produksi_id" id="produksi_id" class="form-control" readonly
                value="{{ $roti->id }}">
            <div class="form-group">
                <label for="">Nama Roti (Sesuai Stok Produksi Roti)</label>
                <input type="text" name="" class="form-control" readonly value="{{ $roti->nama_roti }}">
            </div>
            <div class="form-group">
                <label for="">Rencana Produksi</label>
                <input type="text" name="" class="form-control" readonly value="{{ $roti->rencana_produksi }}">
            </div>
            <div class="form-group">
                <label for="my-input">Jumlah Realisasi</label>
                <input class="form-control" type="number" name="jumlah_realisasi" id="jumlah_realisasi">
            </div>
            <div class="form-group">
                <label for="my-input">Diproduksi Oleh</label>
                <input class="form-control" type="text" name="diproduksi_oleh" id="diproduksi_oleh">
            </div>
            <div class="form-group">
                <label for="my-input">Waktu Mulai Produksi</label>
                <input class="form-control" type="time" name="waktu_dimulai" id="waktu_dimulai">
            </div>
            <div class="form-group">
                <label for="my-input">Waktu Selesai</label>
                <input class="form-control" type="time" name="waktu_selesai" id="waktu_selesai">
            </div>

            <button class="btn btn-primary">Tambah</button>
        </form>
    </div>

@endsection
