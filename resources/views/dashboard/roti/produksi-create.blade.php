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

        .form-control[readonly] {
            background-color: #ffffff;
        }
    </style>
    <div class="container py-3" id="myModal" tabindex="-1">
        <div class="card mb-3 ">
            <div class="card-body border-1">
                <h4>Petunjuk</h4>

                <ul class="nav">
                    <li class="nav-item ">- Pilih terlebih dahulu Nama Roti sesuai resep yang dibuat</li>
                    <li class="nav-item ">- <b class="text-danger">Jumlah Bahan baku dan Satuan bahan </b>  akan mengikuti dengan Jumlah Rencana Produksi yang anda masukkan</li>
                    <li class="nav-item ">- Pastikan data yang anda masukkan <b  class="text-danger"> tidak melebihi</b>  data stok bahan baku</li>
                </ul>
            </div>
        </div>
        <form action="{{ route('produksi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Roti <b>(Sesuai Resep) </b> </label>
                <select name="resep_id" id="select_resep" class="livesearch form-control" required>
                    <option value="0">Pilih</option>
                    @foreach ($resep as $data)
                        <option value="{{ $data->id }}">{{ $data->nama_resep_roti }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="">Jumlah Rencana Produksi Hari Ini</label>
                <input type="number" class="form-control" name="rencana_produksi" id="jumlah_produksi" required value="0">
            </div>

            <div class="mb-3">
                <label for="">Perkiraan Penggunaan Resep</label>
                <div class="bg-white p-3 rounded-3 border border-1">
                    <label for="">Data Bahan Baku</label>
                    <div id="inputFormRow">
                        <div class="input-group mb-3">


                        </div>
                    </div>
                </div>


            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    @include('vendor.sweetalert.alert')
@endsection

@include('partials.scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $('.livesearch').select2();

        $('#select_resep').change(function(e) {
            var id = this.value;

            $.ajax({
                url: "{{ url('produksi-roti/getDataResep/') }}/" + id,
                type: "post",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#inputFormRow').empty();

                    // Function untuk melakukan perhitungan berdasarkan jumlah produksi
                    function hitungJumlahBahan(jumlahProduksi, jumlahBahan) {
                        return jumlahBahan * jumlahProduksi;
                    }

                    // Looping melalui setiap objek dalam resep_bahan_bakus
                    result.resep_bahan_bakus.forEach(function(bahan) {
                        // Membuat elemen input untuk menampilkan data bahan baku
                        var inputRow = '<div class="input-group mb-3">' +
                            '<input class="w-25 form-control" readonly value="' +
                            bahan.bahan_baku.nama_bahan_baku + '">' +
                            '<input type="number" readonly class="form-control w-25 text-dark" value="' +
                            bahan.jumlah_bahan_baku +
                            '" placeholder="Jumlah Bahan Baku" autocomplete="on">' +
                            '<input name="satuan[]" readonly class="form-control text-dark w-25" value="' +
                            bahan.satuan + '" placeholder="Satuan">' +
                            '</div>';

                        // Menambahkan elemen input ke dalam inputFormRow
                        $('#inputFormRow').append(inputRow);

                        // Event untuk menghitung jumlah bahan baku saat nilai jumlah produksi diubah
                        $('#jumlah_produksi').on('keyup', function() {
                            var jumlahProduksi = parseFloat($(this).val());
                            var hasilPerhitungan = hitungJumlahBahan(
                                jumlahProduksi, bahan.jumlah_bahan_baku);

                            // Mengambil input dengan nama yang sesuai dengan bahan baku
                            var inputJumlahBahan = $('input[value="' + bahan
                                    .bahan_baku.nama_bahan_baku + '"]')
                                .siblings('input[type="number"]');
                            inputJumlahBahan.val(hasilPerhitungan);
                        });
                    });
                }
            });
        });
    });
</script>
