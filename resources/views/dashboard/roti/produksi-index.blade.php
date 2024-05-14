@extends('layout')
@section('title', 'Produksi Roti - Family Bakery')
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
        <h1 class="text-center fw-bold">Perencanaan Produksi Roti</h1>
        @can(['produksi_roti-create', 'produksi_roti-edit'])
            <a href="{{ route('produksi.create') }}" class="btn btn-sm btn-primary my-2 py-2 rounded"> <i class="fa fa-plus"
                    aria-hidden="true"></i> Tambah Data Perencanaan Produksi Roti Baru</a>
        @endcan
        <div class="table-responsive">
            <table class="table table-hover table-light table-striped" id="dataTable">
                <thead class="table-dark" id="dataTable">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Roti</th>
                        <th scope="col">Kode Perencanaan Produksi</th>
                        <th scope="col">Rencana Produksi</th>
                        {{-- <th scope="col">Jumlah Tersedia Sekarang</th>
                        <th scope="col">Laku</th> --}}
                        <th scope="col">Diproduksi Oleh</th>
                        <th scope="col">Tanggal Diproduksi</th>
                        <th scope="col">Jumlah Rencana Realisasi</th>
                        <th scope="col">Realisasi Telah Dipenuhi</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produksi as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_roti }}</td>
                            <td>{{ $data->kode_produksi }}</td>
                            <td>{{ $data->rencana_produksi }}</td>
                            {{--  <td>{{ $data->stok_sekarang }}</td>
                            <td>{{ $data->laku }}</td> --}}
                            <td>{{ $data->diajukan_oleh }}</td>
                            <td> <b>{{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('d F Y') }}
                                </b> </td>
                            <td>
                                {{ count($data->RealisasiProduksi) }}
                            </td>
                            <td>
                                {{ $data->RealisasiProduksi->sum('jumlah_realisasi') . '/' }}{{ $data->rencana_produksi ?? 0 }}
                            </td>
                            <td>
                                {{-- <a href="{{ route('produksi.edit', $data->id) }}" class="btn btn-warning">Edit</a> --}}
                                <a href="{{ route('produksi.detail', $data->id) }}" data-id="{{ $data->id }}"
                                    class="btn btn-success">Detail</a>

                                @can('produksi_roti-delete')
                                    <a href="{{ route('produksi.delete', $data->id) }}" data-id="{{ $data->id }}"
                                        class="btn btn-danger" id="delete-btn">Hapus</a>
                                @endcan

                            </td>

                        </tr>
                    @empty
                        <h3>Belum ada data</h3>
                    @endforelse

                </tbody>
            </table>
        </div>


    </div>
    @include('vendor.sweetalert.alert')
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

        $('#dataTable').on('click', '#delete-btn', function(e) {
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
                    window.location = "{{ route('produksi.delete', ':id') }}".replace(':id',
                        id);
                }
            })
        });
    });
</script>
