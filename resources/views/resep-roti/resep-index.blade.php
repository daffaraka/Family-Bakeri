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

        {{-- <
             --}}
        @can('resep_roti-create')
            <a href="{{ route('resep.create') }}" class="btn btn-sm btn-primary my-2 py-2 rounded">
                <i class="fa fa-plus" aria-hidden="true"></i> Tambah Resep Roti</a>
        @endcan

        <table class="table table-hover table-light table-striped" id="dataTable">
            <thead class="table-dark" id="dataTable">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Roti</th>
                    <th scope="col">Jumlah Tersedia Sekarang</th>
                    <th scope="col">Laku</th>
                    <th scope="col">Resep</th>
                    <th scope="col">Harga</th>
                    <th scope="col">PPn</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($resep as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_resep_roti }}</td>
                        <td>{{ $data->stok_sekarang }}</td>
                        <td>{{ $data->laku }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('resep.show', $data->id) }}" id="button-resep"
                                data-toggle="modal" data-target="#resepModal" data-id="{{ $data->id }}">Lihat Resep</a>
                        </td>
                        <td>Rp. {{ number_format($data->harga) }}</td>
                        <td>Rp. {{ number_format($data->ppn) }} </td>


                        <td>
                            @can('resep_roti-edit')
                                <a href="{{ route('resep.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                            @endcan
                            @can('resep_roti-delete')
                                <a href="#" class="btn btn-danger delete-btn" data-id="{{$data->id}}">Hapus</a>
                            @endcan

                        </td>

                    </tr>
                @empty
                    <h3>Belum ada data</h3>
                @endforelse

            </tbody>
        </table>


        <div class="modal fade" id="resepModal">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-primary ">
                        <h4 class="modal-title text-white">Detail Resep</h4>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">&#x2716;</button>
                    </div>
                    <div class="modal-body">
                        <div class="w-100" id="detail-resep">

                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>




@endsection
@include('partials.scripts')
<script>
    // A function to find the intersection between two arrays
    function arrayIntersect(a, b) {
        var result = [];
        $.each(a, function(index, value) {
            if ($.inArray(value, b) !== -1) {
                result.push(value);
            }
        });
        return result;
    }




    $(document).ready(function() {

        $('#dataTable').DataTable({
            language: {
                paginate: {
                    previous: '<span class="fa fa-chevron-left"></span>',
                    next: '<span class="fa fa-chevron-right"></span>' // or '→'

                }
            }
        });

        $('#dataTable').on('click', '#button-resep', function() {
            var id = $(this).attr('data-id');

            if (id > 0) {

                // AJAX request
                var url = "{{ route('resep.show', [':id']) }}";
                url = url.replace(':id', id);

                // Empty modal data

                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function(response) {

                        // Add employee details
                        $('#detail-resep').html(response.html);

                        // Display Modal
                        $('#resepModal').modal('show');
                    }
                });
            }
        });

        $('#dataTable').on('click','.delete-btn',function(e) {
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
                    window.location = "{{ route('resep.delete', ':id') }}".replace(':id', id);
                }
            })
        });

    });
</script>
