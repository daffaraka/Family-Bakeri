@extends('layout')
@section('title','Tambah Bahan Baku - Family Bakery')
@section('content')
    @include('flash')
    <div class="container py-3">
        <form action="{{route('stok.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Bahan Baku</label>
                <input type="text" class="form-control" name="nama_bahan_baku" >
            </div>
            <div class="mb-3">
                <label for="">Jumlah Bahan Baku</label>
                <input type="text" class="form-control" name="jumlah" >
            </div>

            <div class="mb-3">
                <label for="">Satuan</label>
                <select name="satuan" class="form-control text-dark" id="">
                    <option value="Kg">Kg</option>
                    <option value="Gram">G</option>
                    <option value="Pcs">Pcs</option>
                    <option value="Butir">Butir</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="">Jumlah Minimal Stok</label>
                <input type="text" class="form-control" name="jumlah_minimal" >
            </div>
            <button type="submit"  class="btn btn-primary">Simpan</button>
        </form>
    </div>
    @include('sweetalert::alert')
@endsection

@include('partials.scripts')
