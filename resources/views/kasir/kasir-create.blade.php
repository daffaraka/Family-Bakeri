<style>
    td {
        font-size: 1rem !important;
    }


    .dataTables_length select {
        font-size: 1em;
        margin: 10px 0;
        padding: 0;
        width: 50px !important;
    }

    #dataTables_length {
        padding-left: unset !important;
    }
    input {
        color: black !important;
    }

    .select2-container .select2-selection--single {
        height: auto;
        line-height: inherit;
        padding: 0.5rem 1rem;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: unset;
    }

    #dataTable_filter {
        margin-top: 20px;
    }

    #dataTable_wrapper {
        margin-top: 10vh;
    }

    .position-absolute {
        position: absolute;
        top: 0;
        right: 0;
    }

    body.swal2-toast-shown .swal2-container.swal2-center {
        top: 65%;
        /* bottom: 10%; */
        right: auto;
        bottom: auto;
        left: 50%;
        transform: translate(-50%, 100%);
    }

    select, option {
        color: black;
    }
</style>

<div class="container my-5 px-5">
    <form action="{{ route('kasir.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="">Pesanan Oleh </label>
            <select id="pemesan" name="pemesanan" class="form-control text-dark">
                <option value="">Tidak</option>
                <option value="Rizky">Rizky</option>
                <option value="Palem">Palem</option>
                <option value="Moro Jaya">Moro Jaya</option>

            </select>
        </div>

        <div class="form-group">
            <label for="">Nama Roti</label>
            <select name="nama_roti" id="nama_roti" class="livesearch form-control text-dark">
                <option value="">Pilih Roti</option>
                @foreach ($roti as $data)
                    <option class="text-dark" value="{{ $data->nama_resep_roti }}">{{ $data->nama_resep_roti }}</option>
                @endforeach

            </select>
        </div>
        <div class="form-group">
            <label for="">Harga</label>
            <input type="number" name="harga" id="harga" readonly class="form-control">
        </div>
        <div class="form-group">
            <label for="">Stok Tersedia</label>
            <input type="text" name="stok_sekarang" id="stok_sekarang" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Jumlah Laku</label>
            <input type="number" name="laku" id="laku" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="">Sisa </label>
            <input type="number" name="sisa" id="sisa" class="form-control" id="target-sisa" required>
        </div>
        <div class="form-group">
            <label for="">Roti Off </label>
            <input type="number" name="roti_off" id="roti_off" class="form-control" value="0">
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-warning" id="btn-submit"> <i class="fa fa-plus"
                    aria-hidden="true"></i> Tambah Data Baru</button>

            <a href="{{ route('kasir.updateStokTersisa') }}" class="btn btn-primary"> <i class="fa fa-save"
                    aria-hidden="true"></i> Simpan Data Hari Ini </a>
        </div>

    </form>


    <hr>
</div>
