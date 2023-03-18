@extends('layout')
@section('title', 'Resep Roti - Family Bakery')
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

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label><strong>Status :</strong></label>
                    <select id='status' class="form-control" style="width: 200px">
                        <option value="">--Select Status--</option>
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
            </div>
        </div>
        <a href="{{ route('resep.create') }}" class="btn btn-sm btn-primary my-2 py-2 rounded">
             <i class="fa fa-plus" aria-hidden="true"></i> Tambah Resep Roti</a>
        <table class="table table-hover table-light table-striped" id="dataTable">
            <thead class="table-dark" id="dataTable">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Roti</th>
                    <th scope="col">Resep</th>
                    <th scope="col">Jumlah Bahan Baku</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($resep as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_roti }}</td>
                        <td>{{ $data->nama_bahan_baku }}</td>
                        <td>{{ $data->jumlah_bahan_baku }}</td>
                        <td>
                            <a href="{{ route('pemesanan.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('pemesanan.delete', $data->id) }}" class="btn btn-danger">Hapus</a>

                        </td>

                    </tr>
                @empty
                    <h3>Belum ada data</h3>
                @endforelse

            </tbody>
        </table>
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
