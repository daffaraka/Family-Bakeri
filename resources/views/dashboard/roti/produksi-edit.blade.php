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
                <label for="">Nama Roti (Sesuai Stok Produksi Roti)</label>
                <select name="nama_roti" id="nama_roti" class="livesearch form-control text-dark">
                    <option value="">Pilih Roti</option>
                    @foreach ($roti as $data)
                        <option class="text-dark" value="{{ $data->nama_roti }}">{{ $data->nama_roti }}</option>
                    @endforeach

                </select>
            </div>
            {{-- <div class="form-group">
                <label for="">Jumlah Stok Terakhir</label>
                <input type="number" readonly id="stok_masuk" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Tambahkan Jumlah Produksi </label>
                <input type="number" name="stok_masuk" id="stok_masuk" class="form-control">
            </div> --}}


            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
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
