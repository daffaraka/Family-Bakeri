@extends('front-end.layout-beranda')
@section('title', 'Detail Produk')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="card">
                    <a href="{{ route('beranda.buatPesanan', $data->id) }}" class="text-dark text-decoration-none">
                        <img class="card-img-top p-3" style="height: auto; width:100%;"
                            src="{{ asset('images/Resep Roti/' . $data->resepRoti->gambar_roti) }}" alt="">
                        <div class="card-body">

                        </div>
                    </a>

                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="">
                    <h3 class="card-title mb-2">{{ $data->resepRoti->nama_resep_roti }}</h3>
                    <h6 class="fw-bold btn btn-dark">Stok : {{$data->stok}}</h6>
                    <h6 class="fw-normal">Terjual : {{$data->laku}}</h6>
                    <h3 class="card-text fw-bold">Rp. {{ number_format($data->resepRoti->harga) }}</h3>
                </div>

                <hr>
                <div class="">
                    <span class="text-secondary fw-bold mb-2">Deskripsi : </span>
                    <div class="card mt-3">
                        <div class="card-body p-2">
                            <p class="card-text">  {{$data->deskripsi}}</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="d-grid gap-4">
                    <a href="" class="btn btn-warning fw-bold shadow text-uppercase py-2">Tambah ke Keranjang</a>
                    <a href="{{route('beranda.buatPesanan',$data->id)}}" class="btn btn-success fw-bold shadow text-uppercase py-2">Pesan Roti Ini</a>
                </div>
            </div>
        </div>




    @endsection
