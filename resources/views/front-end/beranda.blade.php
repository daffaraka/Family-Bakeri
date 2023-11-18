@extends('front-end.layout-beranda')
@section('title', 'Beranda')
@section('content')
    <div class="container">
        <div class="row py-5">
            @foreach ($data as $roti)
                <div class="col-xxl-3 col-xl-3 col-md-2 col-sm-2">
                    <div class="card shadow">
                        <a href="{{route('beranda.buatPesanan',$roti->id)}}" class="text-dark text-decoration-none">
                            <img class="card-img-top p-3" style="height: 200px;"
                                src="{{ asset('images/Resep Roti/' . $roti->gambar_roti) }}" alt="">
                            <div class="card-body">
                                <h5 class="card-title">{{ $roti->nama_resep_roti }}</h5>
                                <p class="card-text">Rp. {{ number_format($roti->harga) }}</p>
                            </div>
                        </a>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
