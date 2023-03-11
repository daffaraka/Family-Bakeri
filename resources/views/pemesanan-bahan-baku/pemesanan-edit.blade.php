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
                    <option value="dipesan" {{$bb->status_pesanan == 'dipesan' ? 'selected' : ''}}>Dipesan</option>
                    <option value="selesai" {{$bb->status_pesanan == 'selesai' ? 'selected' : ''}}>Selesai</option>
                    <option value="batal" {{$bb->status_pesanan == 'batal' ? 'selected' : ''}}>Batal</option>

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
