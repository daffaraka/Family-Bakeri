@extends('layout')
@section('title', 'Tambah Keuangan - Family Bakery')
@section('content')
    <style>
        select {
            color: black;
        }
    </style>
    <div class="container mt-3 pb-3">
        <h1>Tambah Data Keuangan</h1>
        <form action="{{ route('keuangan-harian.store') }}" method="POST">
            @csrf
            <div class="mb-2">
                <label for="">Toko</label>
                <select name="toko" class="form-control" id="" required>
                    <option value="Toko Nukila">Toko Nukila</option>
                    <option value="Toko Falajawa">Toko Falajawa</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="">Tanggal</label>
                <input type="date" class="form-control" name="tanggal" required>
            </div>

            <div class="mb-2">
                <label for="">Type laporan</label>
                <select class="form-control" name="type" required>
                    <option value="Pemasukan">Pemasukan</option>
                    <option value="Pengeluaran">Pengeluaran</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="">Uraian</label>
                <input type="text" class="form-control" name="uraian">
            </div>

            <div class="mb-2">
                <label for="">Kode Akun</label>
                <select class="form-control" name="kode_akun" required>
                    <option value="BKM - Pemasukan">BKM - Pemasukan</option>
                    <option value="BKK - Pengeluaran">BKK - Pengeluaran</option>
                    <option value="M01 - Penerimaan Penjualan Roti">M01 - Penerimaan Penjualan Roti</option>
                    <option value="M02 - Bayar Nota">M02 - Bayar Nota</option>
                    <option value="K01 - Bayar Bahan Baku">K01 - Bayar Bahan Baku</option>
                    <option value="K02 - Bayar Panjar">K02 - Bayar Panjar</option>
                    <option value="K03 - Operasional">K03 - Operasional</option>
                    <option value="K04 - BPJS Kes/TK">K04 - BPJS Kes/TK</option>
                    <option value="K05 - Gaji">K05 - Gaji</option>
                    <option value="K06 - Sedekah">K06 - Sedekah</option>
                    <option value="K07 - Bayar Listrik, Air">K07 - Bayar Listrik, Air</option>
                    <option value="K08 - WIFI">K08 - WIFI</option>
                    <option value="K09 - Transportasi">K09 - Transportasi</option>
                    <option value="K10 - Lembur">K10 - Lembur</option>
                    <option value="K11 - Operasional Mobil">K11 - Operasional Mobil</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="">Nominal</label>
                <input type="text" class="form-control" name="nominal" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan </button>

        </form>
    </div>

@endsection

