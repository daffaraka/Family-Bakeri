@extends('layout')
@section('title', 'Kasir Customer')
@section('content')





    <div class="container py-4">
        <div >
            <h1>Kasir Customer</h1>

        </div>
        @can('kasir-create')
            @include('dashboard.kasir.kasir-create-customer')
        @endcan
        <div class="row input-daterange d-flex justify-content-between">
            <div class="col-md-6 d-flex">
                <input type="date" name="from_date" id="from_date" class="form-control mx-1" placeholder="From Date" />
            </div>

            <div class="col-md-6 d-block mb-5">
                <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-light table-striped" id="dataTable">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="2">SKU</th>
                        <th rowspan="2">Nama Roti</th>
                        <th rowspan="2">Tanggal Dibuat</th>
                        <th rowspan="2">Harga</th>
                        <th rowspan="2">Stok Masuk</th>
                        <th rowspan="2">Jumlah <br> Awal</th>
                        <th rowspan="2">Laku</th>
                        <th rowspan="2">Sisa</th>
                        <th rowspan="2">Roti Off</th>
                        <th scope="col">Pesanan 1</th>
                        <th scope="col">Pesanan 2</th>
                        <th scope="col">Pesanan 3</th>
                        <th rowspan="2">Total Rizky</th>
                        <th rowspan="2">Total Palem</th>
                        <th rowspan="2">Total Moro Jaya</th>
                        <th rowspan="1">Total Penjualan Data Ini</th>
                    </tr>
                    <tr>
                        <th scope="col">Rizky </th>
                        <th scope="col">Palem </th>
                        <th scope="col">Moro Jaya</th>
                        <th scope="col">(Laku * Harga)</th>
                    </tr>
                </thead>
                <tfoot>

                    <tr>
                        <th class="text-right" colspan="3">Total Penjualan Keseluruhan</th>
                        <th colspan="9"></th>
                        <th id="total_penjualan"></th>
                    </tr>
                    <tr>
                        <th class="text-right" colspan="3">Total Pesanan</th>
                        <th colspan="9"></th>
                        <th id="total_pesanan"></th>
                    </tr>
                    <tr>
                        <th class="text-right" colspan="3">Total Ppn</th>
                        <th colspan="9"></th>
                        <th id="total_ppn"></th>
                    </tr>
                    <tr>
                        <th class="text-right" colspan="3">Total Toko </th>
                        <th colspan="9"></th>
                        <th id="total_toko"></th>
                    </tr>
                    <tr>
                        <th class="text-right" colspan="3">Total After Ppn </th>
                        <th colspan="9"></th>
                        <th id="total_after_ppn"></th>
                    </tr>

                </tfoot>
            </table>
        </div>

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
                    if (result.roti.katalog_roti.stok > 0 ) {
                        $('#stok_sekarang').val(result.roti.katalog_roti.stok);
                    } else {
                        $('#stok_sekarang').val('Belum ada produksi roti');
                    }

                    $('#laku').on('keyup', function() {
                        var laku = parseInt($(this).val());
                        var stok_sekarang = parseInt($('#stok_sekarang').val());

                        var sisa = stok_sekarang - laku;

                        // Set nilai sisa ke input field dengan id "sisa"
                        $('#sisa').val(sisa);
                        if (laku > stok_sekarang) {
                            // $('#btn-submit').prop('disabled', true);
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

            $('#roti_off').keyup(function(e) {
                var roti_off = parseInt($(this).val());
                var stok_sekarang = parseInt($('#stok_sekarang').val());
                if (roti_off > stok_sekarang) {

                    Swal.fire({
                        text: 'Roti Off tidak bisa melebihi stok',
                        target: '#target-sisa',
                        customClass: {
                            container: 'position-absolute',
                        },
                        toast: true,
                        position: 'auto'
                    });
                }
            });
        });

        $('#sisa').on('keyup', function() {
            var sisa = parseInt($(this).val());
            var stok_sekarang = parseInt($('#stok_sekarang').val());
            var laku = stok_sekarang - sisa;

            $('#laku').val(laku);
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
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'stok_masuk',
                    name: 'stok_masuk'
                },
                {
                    data: 'stok_sekarang',
                    name: 'stok_sekarang'
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
                    data: 'roti_off',
                    name: 'roti_off'
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
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'total_palem',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'total_moro_jaya',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'total_penjualan_ini',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },


            ],
            footerCallback: function(row, data, start, end, display, response) {


                var totalPenjualan = 0; // Inisialisasi total penjualan dengan nilai 0
                var totalPemesanan = 0; // Inisialisasi total penjualan dengan nilai 0
                var totalToko = 0; // Inisialisasi total penjualan dengan nilai 0
                var totalPPn = 0; // Inisialisasi total penjualan dengan nilai 0
                var totalAfterPpn = 0;

                // Menampilkan total_pemesanan dalam footer menggunakan jQuery
                // $('#total_pesanan').html('Total Pemesanan: ' + total_pemesanan);


                data.forEach(function(rowData) {
                    // Mengakses nilai total_penjualan dari setiap data baris (rowData) pada table
                    totalPenjualan += parseFloat(rowData.total_penjualan_ini);
                    totalPemesanan += parseFloat(rowData.total_rizky + rowData.total_palem +
                        rowData.total_moro_jaya);
                    totalToko = parseFloat(totalPenjualan - totalPemesanan);
                    totalPPn += parseFloat(rowData.total_ppn);
                    totalAfterPpn = parseFloat(totalToko - totalPPn);

                });


                $('#total_penjualan').html('Rp. ' + totalPenjualan.toLocaleString());
                $('#total_pesanan').html('Rp. ' + totalPemesanan.toLocaleString());
                $('#total_toko').html('Rp. ' + totalToko.toLocaleString());
                $('#total_ppn').html('Rp. ' + totalPPn.toLocaleString());
                $('#total_after_ppn').html('Rp. ' + totalAfterPpn.toLocaleString());
            }


        });
    });
</script>
</body>

</html>
