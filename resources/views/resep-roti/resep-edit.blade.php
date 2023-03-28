@extends('layout')
@section('title', 'Edit Resep - Family Bakery')
@section('content')
    <style>
        .select2.select2-container {
            width: 50% !important;
        }

        .select2-container .select2-selection--single {
            width: auto;
            display: flex;
            height: auto;
            line-height: inherit;
            padding: 0.5rem 1rem;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: unset;
        }
    </style>
    <div class="container py-3">
        <form action="{{ route('resep.update',$resep->id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="">Nama Roti</label>
                        <input type="text" name="nama_roti" class="form-control m-input" placeholder="Nama Roti"
                            autocomplete="on" value="{{ $resep->nama_roti }}">
                    </div>


                    @foreach ($resep_select['nama_bahan_baku'] as $nama_bahan)
                        <label for="">Nama Bahan Baku</label>
                        <div id="inputFormRow">
                            <div class="input-group mb-3">
                                <select class="livesearch form-control d-flex" name="nama_bahan_baku[]">
                                    <option value="">Pilih Bahan Baku</option>
                                    @foreach ($stok as $item)
                                        <option value="{{ $item->nama_bahan_baku }}"
                                            {{ $item->nama_bahan_baku == $nama_bahan ? 'selected' : '' }}>
                                            {{ $item->nama_bahan_baku }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" name="jumlah_bahan_baku[]" required class="form-control w-25"
                                    placeholder="Jumlah Bahan Baku" autocomplete="on" value="">
                                <div class="input-group-append">
                                    <button id="removeRow" type="button" class="btn btn-danger">Kurangi</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div id="newRow"></div>
                    <button id="addRow" type="button" class="btn btn-sm btn-secondary mb-4">Tambah Bahan Baku</button>

                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script type="text/javascript">
        // Add new row when #addRow is clicked
        $("#addRow").click(function() {

            // Get the JSON data as an array
            var stokArray = {!! $stok_json !!};

            // Create the options HTML using a loop
            var options = '';
            $.each(stokArray, function(key, stok) {
                options += '<option value="' + stok.nama_bahan_baku + '">' + stok.nama_bahan_baku + '</option>';
            });

            // Create the new row HTML

            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html +=
                '<select class="livesearch form-control" name="nama_bahan_baku[]" ';
            html += options;
            html += '</select>';
            html +=
                '<input type="number" name="jumlah_bahan_baku[]" class="form-control m-input" placeholder="Jumlah Bahan Baku" required autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Kurangi</button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            // Append the new row to #newRow

            $('#newRow').append(html);
            $('.livesearch').select2();
        });

        // remove row
        $(document).on('click', '#removeRow', function() {
            $(this).closest('#inputFormRow').remove();
        });

        $(document).ready(function() {
            $('.livesearch').select2();
        });
    </script>
@endsection
