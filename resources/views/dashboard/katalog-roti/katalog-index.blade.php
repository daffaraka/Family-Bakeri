@extends('layout')
@section('title', 'Index Katalog - Family Bakery')
@section('content')

    <div class="container-fluid py-4">
        @can('katalog-create')
        <a href="{{ route('katalog.create') }}" class="btn btn-sm btn-primary my-2 py-2 rounded">
            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Katalog Roti</a>
        @endcan

        <table class="table table-hover table-light table-striped" id="dataTable">
            <thead class="table-dark" id="dataTable">
                <tr>
                    <th>#</th>
                    <th>Gambar Roti</th>
                    <th>Nama Roti</th>
                    <th>Stok</th>
                    <th>Laku</th>
                    <th>Harga</th>
                    <th>PPn</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $katalog)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ asset('images/Resep Roti/' . $katalog->resepRoti->gambar_roti) }}"
                                class="img-thumbnail" width="200px" alt=""> </td>
                        <td>{{ $katalog->resepRoti->nama_resep_roti }}</td>
                        <td>{{ $katalog->stok }}</td>
                        <td>{{ $katalog->laku }}</td>
                        <td>Rp.{{ number_format($katalog->resepRoti->harga) }}</td>
                        <td>{{ number_format($katalog->resepRoti->ppn) }}</td>
                        <td>
                            @can('resep_roti-edit')
                                <a href="{{ route('katalog.edit', $katalog->id) }}" class="btn btn-warning">Edit</a>
                            @endcan
                            @can('resep_roti-delete')
                                <a href="#" class="btn btn-danger delete-btn" data-id="{{ $katalog->id }}">Hapus</a>
                            @endcan

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

        $('#dataTable').on('click', '.delete-btn', function(e) {
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
                    window.location = "{{ route('katalog.delete', ':id') }}".replace(':id',
                        id);
                }
            })
        });
    });
</script>
