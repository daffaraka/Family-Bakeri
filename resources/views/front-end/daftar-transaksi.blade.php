@extends('front-end.layout-beranda')
@section('title', 'Daftar Transaksi')
@section('content')


    <div class="container py-5">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered table-light align-middle">
                <thead>

                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Status Pembayaran</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($orders as $order)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->katalog->resepRoti->nama_resep_roti}}</td>
                            <td>
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
                            <td>
                                <a href="{{route('beranda.formBayar',$order->id)}}" class="btn btn-primary">Detail Pesanan</a>
                                <a href="{{route('beranda.formBayar',$order->id)}}" class="btn btn-success">Bayar</a>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>

    </div>

@endsection


{{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
</script>
<script>
    const payButton = document.querySelector('#pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();

        snap.pay('{{ $snapToken }}', {
            // Optional
            onSuccess: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)
            },
            // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)
            },
            // Optional
            onError: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)
            }
        });
    });
</script> --}}
