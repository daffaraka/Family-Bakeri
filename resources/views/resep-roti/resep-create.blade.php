@extends('layout')
@section('title', 'Buat Resep Roti - Family Bakery')
@section('content')
    <div class="container py-3">
        <form action="{{ route('resep.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Resep</label>
                <input type="text" class="form-control" name="nama_bahan_baku">
            </div>

            <div class="mb-3">
                <label for="">Nama Bahan Baku</label>
                <input type="text" class="form-control" name="nama_bahan_baku">
            </div>
            <div class="mb-3">
                <label for="">Jumlah Bahan Baku </label>
                <input type="text" class="form-control" name="jumlah_bahan_baku">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

@endsection
