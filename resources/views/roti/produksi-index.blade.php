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
    <div class="container py-4">

        <a href="{{ route('produksi.create') }}" class="btn btn-sm btn-primary my-2 py-2 rounded"> <i class="fa fa-plus"
                aria-hidden="true"></i> Tambah Data Produksi Roti Baru</a>
        <a href="{{ route('produksi.edit') }}" class="btn btn-sm btn-warning my-2 py-2 rounded"> <i class="fa fa-plus"
                aria-hidden="true"></i> Perbarui Data Roti Tersedia</a>
        <table class="table table-hover table-light table-striped" id="dataTable">
            <thead class="table-dark" id="dataTable">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Roti</th>
                    <th scope="col">Jumlah Produksi</th>
                    <th scope="col">Jumlah Tersedia Sekarang</th>
                    <th scope="col">Laku</th>
                    <th scope="col">Diproduksi Oleh</th>
                    <th scope="col">Tanggal Diproduksi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produksi as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_roti }}</td>
                        <td>{{ $data->stok_masuk }}</td>
                        <td>{{ $data->stok_sekarang }}</td>
                        <td>{{ $data->laku }}</td>
                        <td>{{ $data->diproduksi_oleh }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                        <td>
                            {{-- <a href="{{ route('produksi.edit', $data->id) }}" class="btn btn-warning">Edit</a> --}}
                            <a href="{{ route('produksi.delete', $data->id) }}" class="btn btn-danger">Hapus</a>

                        </td>

                    </tr>
                @empty
                    <h3>Belum ada data</h3>
                @endforelse

            </tbody>
        </table>
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
    });
</script>
