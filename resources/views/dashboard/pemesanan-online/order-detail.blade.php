@extends('layout')
@section('title', 'Index Pemesanan - Family Bakery')
@section('content')
    <div class="container-fluid py-4">

        <div class="row row-cols-2">
            <div class="col-4">
                <h3>Gambar Roti</h3>
                <img class="img-fluid img-thumbnail shadow shadow-sm"
                    src="{{ asset('images/Resep Roti/' . $order->katalog->resepRoti->gambar_roti) }}" alt="">
            </div>

            <div class="col-8">
                <div class="form-group">
                    <label for="my-input" class="font-weight-bold">Nama Pemesan</label>
                    <input id="my-input" class="form-control" value="{{ $order->nama_pemesan }}" readonly>
                </div>
                <div class="form-group">

                    <label for="my-input" class="font-weight-bold">Status Pemesan</label>
                    <div class="">
                        @if ($order->payment_status == '1')
                            <button class="btn btn-warning">Menunggu Pembayaran</button>
                        @elseif($order->payment_status == '2')
                            <button class="btn btn-success">Sudah Dibayar</button>
                        @elseif($order->payment_status == '3')
                            <button class="btn btn-secondary">Kadaluarsa</button>
                        @elseif($order->payment_status == '4')
                            <button class="btn btn-danger">Batal</button>
                        @else
                            <button class="btn btn-info">Status Tidak Valid</button>
                        @endif
                    </div>

                </div>
                <div class="form-group">
                    <label for="my-input" class="font-weight-bold">Deskripsi Pesanan</label>
                    <input id="my-input" class="form-control" value="{{ $order->deskripsi_pesanan }}" readonly>
                </div>

                <div class="form-group">
                    <label for="my-input" class="font-weight-bold">Kontak Pemesan</label>
                    <input id="my-input" class="form-control" value="{{ $order->kontak_pemesan }}" readonly>
                </div>

                <div class="form-group">
                    <label for="my-input" class="font-weight-bold">Tanggal akan diambil</label>
                    <input id="my-input" class="form-control" value="{{ $order->tanggal_diambil }}" readonly>
                </div>

                <div class="form-group">
                    <label for="my-input" class="font-weight-bold">Jumlah pesan</label>
                    <input id="my-input" class="form-control" value="{{ $order->qty }}" readonly>
                </div>



                <div class="">
                    <a href="{{ route('pemesanan-online.index') }}" class="btn btn-dark">Kembali</a>
                </div>

            </div>
        </div>



    </div>

@endsection
