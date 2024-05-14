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
        <div class="card mb-3 ">
            <div class="card-body border-1">
                <h4>Petunjuk</h4>

                <ul class="nav">
                    <li class="nav-item text-danger">- Untuk menambahkan data realisasi, <b>anda diharuskan untuk menambahkan
                            data katalog roti terlebih dahulu. </b> </li>
                    <li class="nav-item text-danger">- Data list nama roti untuk ditambahkan realisasi adalah data
                        berdasarkan <b>PERENCANAAN PRODUKSI Yang telah ditambahkan dan HANYA HARI INI SAJA </b> </li>
                    <li class="nav-item text-danger">- <b>Jumlah Realisasi </b> tidak boleh melebihi perencanaan produksi
                    </li>
                </ul>
            </div>
        </div>
        <h1>Edit data realisasi : {{ $realisasi->ProduksiRoti->nama_roti }} </h1>
        <div class="container py-3 px-0" id="myModal" tabindex="-1">
            <form action="{{ route('realisasi.update', $realisasi->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="">Nama Roti <b>(Sesuai Perencanaan) </b> </label>
                    <input type="text" class="form-control" value="{{ $realisasi->ProduksiRoti->nama_roti }}" readonly>

                </div>
                <div class="mb-3">
                    <label for="">Jumlah Perencanaan</label>
                    <input type="number" class="form-control" name="jumlah_realisasi"
                        value="{{ $realisasi->ProduksiRoti->rencana_produksi }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="">Jumlah Realisasi</label>
                    <input type="number" class="form-control" name="jumlah_realisasi"
                        value="{{ $realisasi->jumlah_realisasi }}">
                </div>
                <div class="mb-3">
                    <label for="">Waktu Mulai</label>
                    <input type="time" class="form-control" name="waktu_dimulai"value="{{ $realisasi->waktu_dimulai }}">
                </div>
                <div class="mb-3">
                    <label for="">Perkiraan Selesai</label>
                    <input type="time" class="form-control" name="waktu_selesai"value="{{ $realisasi->waktu_selesai }}">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    @include('vendor.sweetalert.alert')
@endsection

@include('partials.scripts')

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
    });
</script>
