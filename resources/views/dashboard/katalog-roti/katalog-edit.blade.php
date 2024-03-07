@extends('layout')
@section('title', 'Edit Katalog - Family Bakery')
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
        <form action="{{ route('katalog.update',$katalog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">

                    <div class="mb-3">
                        <label for="">Pilih Roti berdasarkan Resep Roti yang ada</label>
                        <select name="resep_roti" id="" class="form-control">
                            @foreach ($resep as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_resep_roti }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="">Deskripsi</label>
                        <textarea name="deskripsi" id="" class="form-control" cols="30" rows="4">{{$katalog->deskripsi}}</textarea>
                    </div>


                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>



@endsection
