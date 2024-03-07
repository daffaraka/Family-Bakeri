@extends('front-end.layout-beranda')
@section('title', 'Beranda')
@section('content')


    <div class="container-fluid" style="background-color:#fcf3f3;">
        <div id="greeting" class="container">
            <div class="row row-cols-2 py-5">
                <div class="col">
                    <h3 class="fw-bold">Family Bakery</h3>
                    <p class="text-justify">Selamat datang di Family Bakery, di mana kelezatan bertemu kenyamanan online! Nikmati kemudahan
                        memesan produk bakery favorit Anda langsung dari kenyamanan rumah Anda. Dengan koleksi beragam roti,
                        kue, pastry, dan dessert kami, cukup kunjungi website kami dan temukan sentuhan keluarga dalam
                        setiap pesanan. Dari kenyamanan jari Anda, rasakan kehangatan dan kelezatan produk kami yang
                        dihasilkan dengan cinta dan keahlian keluarga. Segera pesan online dan hadirkan kebahagiaan keluarga
                        kami ke meja Anda. Selamat menikmati pengalaman berbelanja yang praktis dan memikat di Family
                        Bakery! </p>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-center">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6YSuX55RmaQWt8wLcXlcB6LUSEdfHL7kDD4oTddK08A&s"  class="w-50" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row py-5">
            @foreach ($data as $roti)
                <div class="col-xxl-3 col-xl-3 col-md-2 col-sm-2">
                    <div class="card shadow">
                        <a href="{{ route('beranda.produk', $roti->id) }}" class="text-dark text-decoration-none">
                            <img class="card-img-top p-3" style="height: 200px;"
                                src="{{ asset('images/Resep Roti/' . $roti->resepRoti->gambar_roti) }}" alt="">
                            <div class="card-body">
                                <h5 class="card-title">{{ $roti->resepRoti->nama_resep_roti }}</h5>
                                <p class="card-text">Rp. {{ number_format($roti->resepRoti->harga) }}</p>
                            </div>
                        </a>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
