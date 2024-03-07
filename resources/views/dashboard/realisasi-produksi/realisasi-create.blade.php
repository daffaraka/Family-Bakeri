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
        <form action="{{ route('realisasi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Roti <b>(Sesuai Perencanaan Produksi Hari Ini) </b> </label>
                <select name="produksi_id" id="" class="livesearch form-control">
                    @foreach ($produksi as $data)
                        <option value="{{ $data->id }}"> {{ $data->nama_roti }} - Tanggal
                            {{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('d F Y') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="">Jumlah Realisasi</label>
                <input type="number" class="form-control" name="jumlah_realisasi">
            </div>
                <div class="form-group">
                <label for="my-input">Diproduksi Oleh</label>
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
    });
</script>
