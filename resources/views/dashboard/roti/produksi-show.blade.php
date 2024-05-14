@extends('layout')
@section('title', 'Tambah Produksi Roti - Family Bakery')
@section('content')
    @include('flash')
    <style>
        .select2-container .select2-selection--single {
            height: auto;
            line-height: inherit;
            padding: 0.5rem 1rem;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: unset;
        }
    </style>
    <div class="container py-3" id="myModal" tabindex="-1">
        <form action="{{ route('produksi.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for=""> <b>Kode Produksi </b> </label>
                <input type="text" name="" id="" class="form-control bg-secondary" readonly
                    value="{{ $roti->kode_produksi }}">
            </div>
            <div class="form-group">
                <label for="">Nama Roti (Sesuai Stok Produksi Roti)</label>
                <input type="text" name="" id="" class="form-control" readonly
                    value="{{ $roti->nama_roti }}">
            </div>
            <div class="form-group">
                <label for="">Perencanaan Produksi</label>
                <input type="text" name="" id="" class="form-control" readonly
                    value="{{ $roti->rencana_produksi }}">
            </div>
            <div class="form-group">
                <label for="">Diproduksi Oleh</label>
                <input type="text" name="" id="" class="form-control" readonly
                    value="{{ $roti->diajukan_oleh }}">
            </div>




        </form>

        <hr>
    </div>


    <div class="container">
        <h2 class="text-center ">Data realisasi produksi roti {{ $roti->nama_roti }}</h2>
        <a href="{{ route('produksi.createRealisasi', $roti->id) }}" class="btn btn-primary btn-sm"> <i class="fa fa-plus"
                aria-hidden="true" id="tambah-realisasi"> </i> Tambah Data Realisasi</a>

        <div class="my-3">
            <table class="table table-hover table-light table-striped" id="dataTable">
                <thead class="table-dark" id="dataTable">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jumlah Realisasi</th>
                        <th scope="col">Penggunaan Bahan</th>
                        <th scope="col">Diproduksi Oleh</th>
                        <th scope="col">Waktu Mulai</th>
                        <th scope="col">Waktu Selesai</th>
                        <th scope="col">Diproduksi Oleh</th>

                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roti->RealisasiProduksi as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->jumlah_realisasi }}</td>
                            <td>
                                <ul class="list-group">
                                    @foreach ($roti->ResepRoti->resepBahanBakus as $item)
                                        <li class="list-group-item py-1">
                                            {{ $item->bahanBaku->nama_bahan_baku . ' - ' . $item->jumlah_bahan_baku * $data->jumlah_realisasi . ' ' . $item->satuan }}
                                            {{-- <button class="btn btn-sm btn-danger d-inline">
                                                {{ $item->jumlah_bahan_baku }}</button> --}}
                                        </li>
                                    @endforeach
                                </ul>


                            </td>

                            <td>{{ $data->diproduksi_oleh }}</td>
                            <td>{{ $data->waktu_dimulai }}</td>
                            <td>{{ $data->waktu_selesai }}</td>

                            <td> <b>{{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('d F Y') }}
                                </b>
                            </td>
                            <td>
                                {{-- <a href="{{ route('produksi.edit', $data->id) }}" class="btn btn-warning">Edit</a> --}}
                                {{-- <a href="{{ route('produksi.detail', $data->id) }}" data-id="{{ $data->id }}"
                                    class="btn btn-outline-warning">Detail</a> --}}

                                @can('produksi_roti-delete')
                                    <a href="{{ route('realisasi.delete', $data->id) }}" data-id="{{ $data->id }}"
                                        class="btn btn-danger" id="delete-btn">Hapus</a>
                                @endcan

                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>
    {{-- <div class="modal fade" id="realisasiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close p-3" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa fa-close" aria-hidden="true"></i> </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input class="form-control" type="hidden" name="produksi_id" id="produksi_id"
                            value="{{ $roti->id }}">
                        <div class="form-group">
                            <label for="my-input">Jumlah Realisasi</label>
                            <input class="form-control" type="number" name="jumlah_realisasi" id="jumlah_realisasi">
                        </div>
                        <div class="form-group">
                            <label for="my-input">Diproduksi Oleh</label>
                            <input class="form-control" type="text" name="diproduksi_oleh" id="diproduksi_oleh">
                        </div>
                        <div class="form-group">
                            <label for="my-input">Waktu Mulai Produksi</label>
                            <input class="form-control" type="time" name="waktu_dimulai" id="waktu_dimulai">
                        </div>
                        <div class="form-group">
                            <label for="my-input">Waktu Selesai</label>
                            <input class="form-control" type="time" name="waktu_selesai" id="waktu_selesai">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-tambah">Tambah</button>
                </div>
            </div>
        </div>
    </div> --}}


    @include('vendor.sweetalert.alert')



@endsection

@include('partials.scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.livesearch').select2();

        $('#nama_roti').on('change', function() {
            var nama_resep_roti = this.value;

            $.ajax({
                url: "{{ url('get-data-roti') }}/" + nama_resep_roti,
                type: "post",
                data: {
                    nama_resep_roti: nama_resep_roti,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#harga').val(result.roti.harga);
                    $('#stok_masuk').val(result.roti.produksi_roti[0].stok_sekarang);

                    $('#laku').on('keyup', function() {
                        var laku = parseInt($(this).val());
                        var stok_masuk = parseInt($('#stok_masuk').val());
                        var sisa = stok_masuk - laku;

                        // Set nilai sisa ke input field dengan id "sisa"
                        $('#sisa').val(sisa);

                        if (laku > stok_masuk) {
                            $('#btn-submit').prop('disabled', true);
                            // Tampilkan pesan error atau lakukan tindakan yang sesuai
                            Swal.fire({
                                text: 'Jumlah laku melebihi stok',
                                target: '#target-sisa',
                                customClass: {
                                    container: 'position-absolute',
                                },
                                toast: true,
                                position: 'auto'
                            });

                            // Atau bisa juga mengosongkan input field "laku" atau menetapkan nilai maksimum yang diizinkan
                            // $(this).val(stok_masuk);
                        } else {
                            $('#btn-submit').prop('disabled', false);
                        }
                    });
                }
            });
        });


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
                    window.location = "{{ route('realisasi.delete', ':id') }}".replace(':id',
                        id);
                }
            })
        });

        $('#btn-tambah').click(function(e) {
            e.preventDefault();

            //define variable
            let jumlah_realisasi = $('#jumlah_realisasi').val();
            let diproduksi_oleh = $('#diproduksi_oleh').val();
            let waktu_dimulai = $('#waktu_dimulai').val();
            let waktu_selesai = $('#waktu_selesai').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `/realisasi-produksi/store`,
                type: "POST",
                cache: false,
                data: {
                    "jumlah_realisasi": jumlah_realisasi,
                    "diproduksi_oleh": diproduksi_oleh,
                    "waktu_dimulai": waktu_dimulai,
                    "waktu_selesai": waktu_selesai,
                    "produksi_id": produksi_id,
                    "_token": token
                },
                success: function(response) {

                    //show success message
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    //data post

                    //append to table
                    //close modal
                    $('#realisasiModal').modal('hide');


                }
                // error: function(error) {

                //     if (error.responseJSON.title[0]) {

                //         //show alert
                //         $('#alert-title').removeClass('d-none');
                //         $('#alert-title').addClass('d-block');

                //         //add message to alert
                //         $('#alert-title').html(error.responseJSON.title[0]);
                //     }

                //     if (error.responseJSON.content[0]) {

                //         //show alert
                //         $('#alert-content').removeClass('d-none');
                //         $('#alert-content').addClass('d-block');

                //         //add message to alert
                //         $('#alert-content').html(error.responseJSON.content[0]);
                //     }

                // }

            });

        });
    });
</script>
