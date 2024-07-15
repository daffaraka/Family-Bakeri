@extends('layout')
@section('title', 'Buat Resep Roti - Family Bakery')
@section('content')

    <style>
        select option {
            color: black;
        }

        .select2.select2-container {
            width: 50% !important;
            margin-right: 2vh;
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
        <form action="{{ route('resep.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="">Gambar Roti</label>
                        <div class="my-3">
                            <img id="preview" src="#" alt="preview image" class="shadow" style=" max-height: 200px;" />

                        </div>

                        <input type="file" name="gambar_roti" class="form-control m-input" id="selectImage"
                            autocomplete="on" accept="image/*" required>

                    </div>
                    <div class="mb-3">
                        <label for="">Nama Roti</label>
                        <input type="text" name="nama_resep_roti" class="form-control m-input" placeholder="Nama Roti"
                            autocomplete="on" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Harga Roti</label>
                        <input type="text" name="harga" class="form-control m-input" placeholder="Harga Roti"
                            autocomplete="on" required>
                    </div>
                    <div class="mb-3">
                        <label for="">PPn</label>
                        <select name="ppn" id="" class="form-control text-dark">
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>

                        </select>
                    </div>
                    <label for="">Nama Bahan Baku</label>
                    <div id="inputFormRow">
                        <div class="input-group mb-3">
                            <select class="livesearch form-control d-flex" name="nama_bahan_baku[]">
                                <option value="">Pilih bahan baku</option>
                                @foreach ($stok as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_bahan_baku }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="jumlah_bahan_baku[]" required class="form-control w-25 text-dark"
                                placeholder="Jumlah Bahan Baku" autocomplete="on">
                            <select name="satuan[]" class="form-control text-dark" id="">
                                <option value="Gram">Gram</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Butir">Butir</option>
                            </select>
                            <div class="input-group-append">
                                <button id="removeRow" type="button" class="btn btn-danger">Kurangi</button>
                            </div>
                        </div>
                    </div>

                    <div id="newRow"></div>
                    <button id="addRow" type="button" class="btn btn-sm btn-secondary mb-4">Tambah Bahan Baku</button>

                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    @include('partials.scripts')
    <script type="text/javascript">
        // Add new row when #addRow is clicked
        $("#addRow").click(function() {

            // Get the JSON data as an array
            var stokArray = {!! $stok_json !!};

            // Create the options HTML using a loop
            var options = '';
            $.each(stokArray, function(key, stok) {
                options += '<option value="' + stok.id + '">' + stok.nama_bahan_baku +
                    '</option>';
            });

            // Create the new row HTML

            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html +=
                '<select class="livesearch form-control" name="nama_bahan_baku[]" ';
            html += '<option>Pilih Bahan Baku </option> '
            html += '<option>Pilih Bahan Baku </option> ';
            html += options;
            html += '</select>';
            html +=
                '<input type="number" name="jumlah_bahan_baku[]" class="form-control m-input text-dark" placeholder="Jumlah Bahan Baku" required autocomplete="off">';
            html +=
                '  <select name="satuan[]" class="form-control text-dark" id="">'
            html += '<option value="Gram">Gram</option>'
            html += '<option value="Pcs">Pcs</option>'
            html += '<option value="Butir">Butir</option>'
            html += '</select>'
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

        selectImage.onchange = evt => {
            preview = document.getElementById('preview');
            preview.style.display = 'block';
            const [file] = selectImage.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>


@endsection
