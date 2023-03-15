@extends('layout')
@section('title','Tambah Bahan Baku - Family Bakery')
@section('content')
    <div class="container py-3">
        <form action="{{route('pemesanan.update',$bb->id)}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Bahan Baku</label>
                <input type="text" class="form-control" name="nama_bahan_baku" value="{{$bb->nama_bahan_baku}}" >
            </div>
            <div class="mb-3">
                <label for="">Jumlah Pesanan</label>
                <input type="number" class="form-control" name="jumlah_pesanan" value="{{$bb->jumlah_pesanan}}">
            </div>
            <div class="mb-3">
                <label for="">Status Pesanan</label>
                <select name="status_pesanan" id="" class="form-control">
                    <option value="Sedang Diantar" {{$bb->status_pesanan == 'Sedang Diantar' ? 'selected' : ''}}>Sedang Diantar</option>
                    <option value="Diterima" {{$bb->status_pesanan == 'Diterima' ? 'selected' : ''}}>Diterima</option>
                    <option value="Dibayar" {{$bb->status_pesanan == 'Dibayar' ? 'selected' : ''}}>Dibayar</option>

                </select>
            </div>
            <div class="mb-3">
                <label for="">Harga Satuan</label>
                <input type="number" class="form-control" name="harga_satuan" value="{{$bb->harga_satuan}}">
            </div>

            <button type="submit"  class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
