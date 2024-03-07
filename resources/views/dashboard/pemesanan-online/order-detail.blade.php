@extends('layout')
@section('title', 'Index Pemesanan - Family Bakery')
@section('content')
    <div class="container-fluid py-4">

        <div class="row row-cols-2">
            <div class="col-4">
                <img class="img-fluid" src="{{asset('images/Resep Roti/'.$order->katalog->resepRoti->gambar_roti)}}" alt="">
            </div>

            <div class="col-8">
                <div class="form-group">
                    <label for="my-input">Nama Pemesan</label>
                    <input id="my-input" class="form-control" value="{{$order->nama_pemesan}}" readonly>
                </div>
                <div class="form-group">
                    <label for="my-input">Nama Pemesan</label>
                    <input id="my-input" class="form-control" value="{{$order->nama_pemesan}}" readonly>
                </div>

                <div class="form-group">
                    <label for="my-input">Nama Pemesan</label>
                    <input id="my-input" class="form-control" value="{{$order->nama_pemesan}}" readonly>
                </div>

                <div class="form-group">
                    <label for="my-input">Nama Pemesan</label>
                    <input id="my-input" class="form-control" value="{{$order->nama_pemesan}}" readonly>
                </div>

                <div class="form-group">
                    <label for="my-input">Nama Pemesan</label>
                    <input id="my-input" class="form-control" value="{{$order->nama_pemesan}}" readonly>
                </div>

            </div>
        </div>



    </div>

@endsection
