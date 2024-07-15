@extends('front-end.layout-beranda')
@section('title', 'Selesaikan Pesanan Anda')
@section('content')


    <div class="container py-5">
        <div class="row row-cols-1 align-items-center">
            <div class="col">

                <h4 class="fw-bold">Pembayaran</h4>
                <div class="card mt-3 mb-4">
                    <div class="card-body shadow-sm">
                        <p class="card-text">Ini halaman terakhir dari proses belanjamu. Pastikan semua sudah benar</p>
                    </div>
                </div>


                {{-- Gambar Produk / Deskripsi / Form Bayar --}}
                <div class="row row-cols-3">
                    <div class="col mt-3">
                        <img class="img-fluid p-1 border border-1"
                            src="{{ asset('images/Resep Roti/' . $order->katalog->resepRoti->gambar_roti) }}"
                            alt="">
                    </div>

                    <div class="col mt-3">
                        <h5 class="card-title fw-bold">{{ $order->katalog->resepRoti->nama_resep_roti }}</h5>
                        <p class="card-text">{{ $order->katalog->deskripsi }}</p>
                    </div>

                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Formulir</h5>
                                <div class="form-group mb-3">
                                    <label for="my-input">Nama Pemesan</label>
                                    <input id="my-input" class="form-control" type="text"
                                        value="{{ $order->nama_pemesan }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="my-input">Jumlah Pesanan</label>
                                    <input id="my-input" class="form-control" type="text" value="{{ $order->qty }}"
                                        readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="my-input">Kontak Pemesan</label>
                                    <input id="my-input" class="form-control" type="text"
                                        value="{{ $order->nama_pemesan }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="my-input">Total Pesanan</label>
                                    <input id="my-input" class="form-control" type="text" value="Rp. {{ number_format($order->total) }}"
                                        readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="my-input">Status Pembayaran</label>

                                    <span class="d-grid">
                                        @switch($order->payment_status)
                                            @case('1')
                                                <button class="btn btn-warning" id="payment-action" disabled>Menunggu
                                                    Pembayaran</button>
                                                <hr>

                                                <div class="d-grid mt-5">
                                                    <a href="#" class="btn btn-success fw-bold py-2" id="pay-button">
                                                        Bayar</a>

                                                </div>
                                            @break

                                            @case('2')
                                                <button class="btn btn-success" id="payment-action" disabled>Sudah Dibayar</button>
                                            @break

                                            @case('3')
                                                <button class="btn btn-danger" id="payment-action" disabled>Kadaluarsa</button>
                                            @break

                                            @case('4')
                                                <button class="btn btn-secondary" id="payment-action" disabled>Batal</button>
                                            @break

                                            @default
                                                <button class="btn btn-dark" id="payment-action" disabled>Status Tidak
                                                    Dikenal</button>
                                        @endswitch
                                    </span>

                                </div>





                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="container py-5">
        <hr>
        <h4 class="fw-bold">Produk Terkait</h4>
        <div class="row row-cols-5">
            @foreach ($relatedProducts as $roti)
                <div class="col">
                    <div class="card shadow my-3">
                        <a href="{{ route('beranda.produk', $roti->id) }}" class="text-dark text-decoration-none">
                            <img class="card-img-top" style="height: 300px; object-fit:cover;"
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


    @include('partials.scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil!',
                        text: 'Terima kasih atas pembayaran Anda.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Redirect atau lakukan tindakan lain setelah pengguna menekan OK
                        if (result.isConfirmed) {
                            window.location.href =
                                '/daftar-transaksi'; // Ganti dengan URL halaman informasi lainnya
                        }
                    });;
                    console.log(result)
                },
                // Optional
                onPending: function(result) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Pembayaran Sedang Diproses',
                        text: 'Pembayaran Anda masih dalam proses. Harap tunggu konfirmasi lebih lanjut.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Redirect atau lakukan tindakan lain setelah pengguna menekan OK
                        if (result.isConfirmed) {
                            window.location.href =
                                '/daftar-transaksi'; // Ganti dengan URL halaman informasi lainnya
                        }
                    });
                    console.log(result)
                },
                // Optional
                onError: function(result) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Pembayaran Sedang Diproses',
                        text: 'Pembayaran Anda masih dalam proses. Harap tunggu konfirmasi lebih lanjut.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Redirect atau lakukan tindakan lain setelah pengguna menekan OK
                        if (result.isConfirmed) {
                            window.location.href =
                                '/daftar-transaksi'; // Ganti dengan URL halaman informasi lainnya
                        }
                    });
                    console.log(result)
                }
            });
        });
    </script>

@endsection
