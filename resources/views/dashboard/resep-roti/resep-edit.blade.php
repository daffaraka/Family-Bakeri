@extends('layout')
@section('title', 'Edit Resep - Family Bakery')
@section('content')
    <style>
        .select2.select2-container {
            width: 50% !important;
            color: black;
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
        <form action="{{ route('resep.update', $resep->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12"> <div class="my-2 mb-3">
                        </div>
                        <div class="mb-3">
                            <label for="">Gambar Roti</label>
                            <div class="my-3">
                                <img id="preview" src="{{asset('images/Resep Roti/'.$resep->gambar_roti)}}" class="shadow" style=" max-height: 200px;" />
                            </div>

                            <input type="file" name="gambar_roti" class="form-control m-input" id="selectImage"
                                autocomplete="on" accept="image/*">

                        </div>
                    <div class="mb-3">
                        <label for="">Nama Roti</label>
                        <input type="text" name="nama_resep_roti" class="form-control m-input text-dark"
                            placeholder="Nama Roti" autocomplete="on" value="{{ $resep->nama_resep_roti }}">
                    </div>
                    <div class="mb-3">
                        <label for="">PPn</label>
                        <select name="ppn" id="" class="form-control text-dark">
                            <option value="Ya" {{$resep->ppn == 2000 ? 'selected' : ''}}>Ya</option>
                            <option value="Tidak" {{$resep->ppn == 2000 ? '' : 'selected'}} >Tidak</option>

                        </select>
                    </div>


                    @foreach ($resep_select->resepBahanBakus as $data)
                        <div id="inputFormRow">
                            <label for="">Nama Bahan Baku </label>
                            <div class="input-group mb-3">
                                <select class="livesearch form-control d-flex" name="nama_bahan_baku[]">
                                    <option value="">Pilih Bahan Baku</option>
                                    @foreach ($stok as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->nama_bahan_baku == $data->bahanBaku->nama_bahan_baku ? 'selected' : '' }}>
                                            {{ $item->nama_bahan_baku }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" name="jumlah_bahan_baku[]" required
                                    class="form-control w-25 text-dark" placeholder="Jumlah Bahan Baku" autocomplete="on"
                                    value="{{ $data->jumlah_bahan_baku }}">
                                <select name="satuan[]" class="form-control text-dark" id="">
                                    <option value="Gram" {{$data->satuan == "Gram" ? 'selected' : ''}}>Gram</option>
                                    <option value="Kg" {{$data->satuan == "Kg" ? 'selected' : ''}}>Kg</option>
                                    <option value="Pcs" {{$data->satuan == "Pcs" ? 'selected' : ''}}>Pcs</option>
                                    <option value="Butir" {{$data->satuan == "Butir" ? 'selected' : ''}}>Butir</option>
                                </select>
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
                options += '<option value="' + stok.id + '">' + stok.nama_bahan_baku +
                    '</option>';
            });

            // Create the new row HTML

            var html = '';

            html += '<div id="inputFormRow">';
            html += '<label for="" class="nbb">Nama Bahan Baku</label> <br> '
            html += '<div class="input-group mb-3">';

            html += '<select class="livesearch form-control" name="nama_bahan_baku[]" ';
            html += options;
            html += '</select>';
            html +=
                '<input type="number" name="jumlah_bahan_baku[]" class="form-control text-dark m-input" placeholder="Jumlah Bahan Baku" required autocomplete="off">';
            html += '<select name="satuan[]" class="form-control text-dark" id="">';
            html += '<option value="Gram">Gram</option>';
            html += '<option value="Kg">Kg</option>';
            html += '<option value="Pcs">Pcs</option>';
            html += '<option value="Butir">Butir</option>';
            html += '</select>';
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
            $(this).closest('#inputFormRow', '.nbb').remove();
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
