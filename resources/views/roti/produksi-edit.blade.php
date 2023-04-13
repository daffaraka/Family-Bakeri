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
        <form action="{{ route('produksi.update',$roti->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Roti <b>(Sesuai Resep) </b> </label>
                <input type="text" name="nama_roti" readonly value="{{$roti->nama_roti}}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="">Jumlah Produksi</label>
                <input type="number" class="form-control" value="{{$roti->jumlah_produksi}}" name="jumlah_produksi">
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
