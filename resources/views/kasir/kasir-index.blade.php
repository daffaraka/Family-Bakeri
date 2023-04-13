@extends('layout')

@section('title', 'Kasir')

@section('content')
    @include('kasir.kasir-create')


    <div class="container py-4 px-5">

        <div class="row input-daterange d-flex justify-content-between">
            <div class="col-md-6 d-flex">
                <input type="date" name="from_date" id="from_date" class="form-control mx-1" placeholder="From Date" />
            </div>

            <div class="col-md-6 d-block">
                <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
            </div>
        </div>
        <table class="table table-bordered table-hover table-light table-striped" id="dataTable">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2">SKU</th>
                    <th rowspan="2">Nama Roti</th>
                    <th rowspan="2">Tanggal Dibuat</th>
                    <th rowspan="2">Harga</th>
                    <th rowspan="2">Stok Masuk</th>
                    <th rowspan="2">Jumlah</th>
                    <th rowspan="2">Laku</th>
                    <th rowspan="2">Sisa</th>
                    {{-- <th rowspan="2">Total</th>
                <th rowspan="2">Roti Off</th> --}}
                    <th scope="col">Pesanan 1</th>
                    <th scope="col">Pesanan 2</th>
                    <th scope="col">Pesanan 3</th>
                    <th rowspan="2">Total Rizky</th>
                    <th rowspan="2">Total Palem</th>
                    <th rowspan="2">Total Moro Jaya</th>


                </tr>
                <tr>
                    <th scope="col">Rizky </th>
                    <th scope="col">Palem </th>
                    <th scope="col">Moro Jaya</th>
                </tr>
            </thead>
            <tfoot>

                <tr>
                    <th class="text-right" colspan="3">Total Penjualan Roti</th>
                    <th colspan="9"></th>
                    <th id="total_penjualan"></th>
                </tr>
                <tr>
                    <th class="text-right" colspan="3">Total Pemotongan</th>
                    <th colspan="9"></th>
                    <th id="total_pesanan"></th>
                </tr>
                <tr>
                    <th class="text-right" colspan="3">PPn</th>
                    <th colspan="9"></th>
                    <th id="pemotongan"></th>
                </tr>
                <tr>
                    <th class="text-right" colspan="3">Total </th>
                    <th colspan="9"></th>
                    <th id="sub_total"></th>
                </tr>
                <tr>
                    <th class="text-right" colspan="3">Total (Tanpa PPn) </th>
                    <th colspan="9"></th>
                    <th ></th>
                </tr>

            </tfoot>
        </table>
    </div>

    @include('vendor.sweetalert.alert')
@endsection
@include('partials.scripts')

<script>
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
                    $('#stok_masuk').val(result.roti.produksi_roti[0].jumlah_produksi);

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


        $('#pesanan').on('change', function() {
            var pilihan = $(this).val(); // Mendapatkan nilai pilihan yang dipilih

            // Menjalankan kode berdasarkan pilihan yang dipilih
            if (pilihan == 'Ya') {
                $('#pemesan').prop('disabled', false); // Mengaktifkan  input #pemesan
            } else if (pilihan == 'Tidak') {
                $('#pemesan').prop('disabled', true); // Menonaktifkan input #pemesan
            } else {
                $('#pemesan').prop('disabled', true);
            }
        });


        $('#filter').on('click', function() {
            $('#from_date').val(); // Mengambil nilai dari input "from_date"

            // Menggunakan DataTables untuk mengirim request Ajax dengan parameter filter tanggal
            $('#dataTable').DataTable().ajax.reload();
        });

        // Menambahkan event listener untuk tombol "Refresh"
        $('#refresh').on('click', function() {
            $('#from_date').val('');
            $('#dataTable').DataTable().ajax.reload();
        });

        $('#dataTable').DataTable({
            language: {
                paginate: {
                    previous: '<span class="fa fa-chevron-left"></span>',
                    next: '<span class="fa fa-chevron-right"></span>' // or '→'
                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: '/kasir',
                type: 'GET',
                data: function(d) {
                    d.from_date = $('#from_date')
                        .val();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama_roti',
                    name: 'nama_roti'
                },
                {
                    data: 'tanggal_diproduksi',
                    name: 'tanggal_diproduksi'
                },
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'stok_masuk',
                    name: 'stok_masuk'
                },
                {
                    data: 'jumlah',
                    name: 'jumlah'
                },
                {
                    data: 'laku',
                    name: 'laku'
                },
                {
                    data: 'sisa_total',
                    name: 'sisa_total'
                },
                {
                    data: 'rizky',
                    name: 'rizky'
                },
                {
                    data: 'palem',
                    name: 'palem'
                },
                {
                    data: 'moro_jaya',
                    name: 'moro_jaya'
                },
                {
                    data: 'total_rizky',
                    name: 'total_rizky'
                },
                {
                    data: 'total_palem',
                    name: 'total_palem'
                },
                {
                    data: 'total_moro_jaya',
                    name: 'total_moro_jaya'
                },


            ],
            footerCallback: function(row, data, start, end, display, response) {
                var totalPenjualan = 0; // Inisialisasi total penjualan dengan nilai 0
                var total_pesanan = 0; // Inisialisasi total penjualan dengan nilai 0
                var pemotongan = 0; // Inisialisasi total penjualan dengan nilai 0
                var sub_total = 0; // Inisialisasi total penjualan dengan nilai 0

                data.forEach(function(rowData) {
                    // Mengakses nilai total_penjualan dari setiap data baris (rowData) pada table
                    totalPenjualan = parseFloat(rowData.total_penjualan);
                    total_pesanan = parseFloat(rowData.total_pesanan);
                    pemotongan = parseFloat(rowData.pemotongan);
                    sub_total = parseFloat(rowData.sub_total);
                });

                $('#total_penjualan').html('Rp. '+totalPenjualan);
                $('#total_pesanan').html('Rp. '+total_pesanan);
                $('#pemotongan').html('Rp. '+pemotongan);
                $('#sub_total').html('Rp. '+sub_total);
            }
        });
    });
</script>
</body>

</html>
