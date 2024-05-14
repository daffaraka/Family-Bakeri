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
                    <li class="nav-item ">- Untuk menambahkan data realisasi, <b class="text-danger">anda diharuskan untuk menambahkan
                            data katalog roti terlebih dahulu. </b> </li>
                    <li class="nav-item ">- Data list nama roti untuk ditambahkan realisasi adalah data
                        berdasarkan <b  class="text-danger">PERENCANAAN PRODUKSI Yang telah ditambahkan dan HANYA HARI INI SAJA </b> </li>
                    <li class="nav-item ">- <b  class="text-danger">Jumlah Realisasi </b> tidak boleh melebihi perencanaan produksi</li>
                    <li class="nav-item ">- Jika anda tidak menginput siapa yang memproduksi, maka akan otomatis mengisi sesuai yang sedang login sekarang </li>



                    {{-- <li class="nav-item text-danger">-</li> --}}
                </ul>
            </div>
        </div>
        <form action="{{ route('realisasi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Roti <b>(Sesuai Perencanaan Produksi Hari Ini) </b> </label>
                <select name="produksi_id" id="produksi_id" class="livesearch form-control">
                    <option> Pilih </option>
                    @foreach ($produksi as $data)
                        <option value="{{ $data->id }}"> {{ $data->nama_roti }} - Tanggal
                            {{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('d F Y') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="">Jumlah Perencanaan Awal</label>
                <input type="number" class="form-control" id="jumlah_perencanaan" value="" readonly>
            </div>
            <div class="mb-3">
                <label for="">Jumlah Realisasi</label>
                <input type="number" class="form-control" name="jumlah_realisasi">
            </div>
            <div class="form-group">
                <label for="my-input">Diproduksi Oleh </label>
                <input class="form-control" type="text" name="diproduksi_oleh" id="diproduksi_oleh">
            </div>
            <div class="mb-3">
                <label for="">Waktu Mulai</label>
                <input type="time" class="form-control" name="waktu_dimulai">
            </div>


            <div class="mb-3">
                <label for="">Perkiraan Selesai</label>
                <input type="time" class="form-control" name="waktu_selesai">
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



        $(document).ready(function() {

            $('#produksi_id').on('change', function() {
                var produksi_id = this.value;

                $.ajax({
                    url: "{{ url('find-perencanaan-produksi') }}/" + produksi_id,
                    type: "post",
                    data: {
                        id: produksi_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                        $('#jumlah_perencanaan').val(result.rencana_produksi);

                    }
                });

            });

        });
    });
</script>
