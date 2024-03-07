@extends('layout')
@section('title', 'Index Pemesanan - Family Bakery')
@section('content')
    <style>
        td {
            font-size: 1rem !important;
        }

        .dataTables_length,
        .dataTables_length select {
            font-size: 1em;
            margin: 10px 0;
            padding: 0;
            width: 50px !important;
        }
    </style>
    <div class="container-fluid py-4">


        <div class="table-responsive">
            <table class="table table-hover table-light table-striped" id="dataTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Pemesan</th>
                        <th style="width:200px;">Produk yang dipesan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($data as $order)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ $order->katalog->resepRoti->nama_resep_roti }}</td>
                            <td>Rp.{{ number_format($order->total) }}</td>

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
                            </td>
                            <td>
                                <a href="{{route('pemesanan-online.show',$order->id)}}" class="btn btn-primary">Detail</a>
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
@include('partials.scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                paginate: {
                    previous: '<span class="fa fa-chevron-left"></span>',
                    next: '<span class="fa fa-chevron-right"></span>' // or '→'

                }
            }
        });

        $('.delete-btn').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            Swal.fire({
                title: 'Anda yakin?',
                text: "Anda tidak dapat mengembalikan tindakan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lanjutkan dengan tindakan hapus
                    window.location = "{{ route('stok.delete', ':id') }}".replace(':id', id);
                }
            })
        });
    });
</script>
