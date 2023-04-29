@extends('layout')
@section('title', 'Stok Bahan Baku - Family Bakery')
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

        <a href="{{ route('stok.create') }}" class="btn btn-sm btn-primary my-2 py-2 rounded"> <i class="fa fa-plus"
                aria-hidden="true"></i> Tambah Data Stok Bahan Baku</a>
        <table class="table table-hover table-light table-striped" id="dataTable">
            <thead class="table-dark" id="dataTable">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Bahan Baku</th>
                    <th scope="col">Status Jumlah Stok</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Terakhir Diedit oleh</th>
                    <th scope="col">Waktu Diupdate</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stok as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_bahan_baku }}</td>
                        <td>
                            <button class="btn btn-sm {{ $data->jumlah < $data->jumlah_minimal ? 'btn-danger' : 'btn-success' }}">
                                {{ $data->jumlah < $data->jumlah_minimal ? 'Stok kritis' : 'Stok Aman' }}
                            </button>
                        </td>
                        <td>
                            {{number_format($data->jumlah/1000,2,',','.')}}


                            <br>
                        </td>
                        <td>{{ $data->satuan }}</td>
                        <td>{{ $data->terakhir_diedit_by }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->updated_at)->locale('id')->translatedFormat('d F Y') }}</td>
                        <td>
                            <a href="{{ route('stok.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('stok.delete', $data->id) }}" class="btn btn-danger">Hapus</a>

                        </td>

                    </tr>
                @empty
                    <h3>Belum ada data</h3>
                @endforelse

            </tbody>
        </table>

        {{-- <iframe width="560" height="315" src="https://www.youtube.com/embed/gN0YAMKmAnQ" title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen></iframe> --}}
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
    });
</script>
