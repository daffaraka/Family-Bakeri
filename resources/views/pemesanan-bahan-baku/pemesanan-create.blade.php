@extends('layout')
@section('title','Tambah Bahan Baku - Family Bakery')
@section('content')
    <div class="container py-3">
        <form action="{{route('pemesanan.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Bahan Baku</label>
                <input type="text" class="form-control" name="nama_bahan_baku" >
            </div>
            <div class="mb-3">
                <label for="">Jumlah Pesanan</label>
                <input type="number" class="form-control" name="jumlah_pesanan" >
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
                <label for="">Harga Satuan</label>
                <input type="number" class="form-control" name="harga_satuan" >
            </div>

            <button type="submit"  class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
