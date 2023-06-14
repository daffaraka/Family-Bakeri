@extends('layout')
@section('title', 'Keuangan - Family Bakery')
@section('content')

    <div class="container">
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase ls-1 mb-1">Rekap</h6>
                                <h5 class="h3 mb-0">Keuangan Bulanan</h5>
                            </div>
                            <div class="col">
                                <a href="{{ route('keuangan-harian.create') }}" class="btn btn-warning">Tambah data Keuangan</a>
                            </div>
                            <div class="col">
                                <ul class="nav nav-pills justify-content-end">
                                    {{-- <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales-dark"
                                        data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 15, 40, 20, 60, 60]}]}}'
                                        data-prefix="$" data-suffix="k">
                                        <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                            <span class="d-none d-md-block">Month</span>
                                            <span class="d-md-none">M</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" data-toggle="chart" data-target="#chart-sales-dark"
                                        data-update='{"data":{"datasets":[{"data":[0, 20, 5, 25, 10, 30, 15, 40, 40]}]}}'
                                        data-prefix="$" data-suffix="k">
                                        <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                                            <span class="d-none d-md-block">Week</span>
                                            <span class="d-md-none">W</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <th>No</th>
                                <th>Toko</th>
                                <th>Tanggal</th>
                                <th>Type</th>
                                <th>Uraian</th>
                                <th>Kode Akun</th>
                                <th>Nominal</th>
                                <th>Aksi</th>

                            </thead>
                            <tbody>
                                @foreach ($keuangan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->toko }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>
                                            <button
                                                class="btn btn-{{ $item->type == 'Pemasukan' ? 'success' : 'danger' }} btn-sm">
                                                {{ $item->type }}
                                        </td></button>

                                        <td>{{ $item->uraian }}</td>
                                        <td>{{ $item->kode_akun }}</td>
                                        <td>{{ $item->nominal }}</td>
                                        <td>
                                            <a href="{{ route('keuangan-harian.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger" data-id="{{$item->id}}" id="delete-btn">Hapus</a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
            },
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
                    window.location = "{{ route('keuangan-harian.destroy', ':id') }}".replace(':id',
                        id);
                }
            })
        });

    });
</script>
