@extends('layout')
@section('title', 'Edit Keuangan - Family Bakery')
@section('content')
    <style>
        select {
            color: black;
        }
    </style>
    <div class="container mt-3 pb-3">
        <h1>Edit Data Keuangan</h1>
        <form action="{{ route('keuangan-harian.update',$keuangan->id) }}" method="POST">
            @csrf
            <div class="mb-2">
                <label for="">Toko</label>
                <select name="toko" class="form-control" id="" required>
                    <option value="Toko Nukila" {{$keuangan->toko == 'Toko Nukila' ? 'selected' :''}}>Toko Nukila</option>
                    <option value="Toko Falajawa"  {{$keuangan->toko == 'Toko Falajawa' ? 'selected' :''}}>Toko Falajawa</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="">Tanggal</label>
                <input type="date" class="form-control" name="tanggal" required value="{{$keuangan->tanggal}}">
            </div>

            <div class="mb-2">
                <label for="">Type laporan</label>
                <select class="form-control" name="type" required>
                    <option value="Pemasukan"  {{$keuangan->type == 'Pemasukan' ? 'selected' :''}}>Pemasukan</option>
                    <option value="Pengeluaran" {{$keuangan->type == 'Pengeluaran' ? 'selected' :''}}>Pengeluaran</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="">Uraian</label>
                <input type="text" class="form-control" name="uraian" value="{{$keuangan->uraian}}">
            </div>

            <div class="mb-2">
                <label for="">Kode Akun</label>
                <select class="form-control" name="kode_akun" required>
                    <option value="BKM - Pemasukan" {{ $keuangan->kode_akun =='BKM - Pemasukan' ? 'selected' : ''}}>BKM - Pemasukan</option>
                    <option value="BKK - Pengeluaran" {{ $keuangan->kode_akun =='BKK - Pengeluaran' ? 'selected' : ''}}>BKK - Pengeluaran</option>
                    <option value="M01 - Penerimaan Penjualan Roti" {{ $keuangan->kode_akun =='M01 - Penerimaan Penjualan Roti' ? 'selected' : ''}}>M01 - Penerimaan Penjualan Roti</option>
                    <option value="M02 - Bayar Nota" {{ $keuangan->kode_akun =='M02 - Bayar Nota' ? 'selected' : ''}}>M02 - Bayar Nota</option>
                    <option value="K01 - Bayar Bahan Baku" {{ $keuangan->kode_akun =='K01 - Bayar Bahan Baku' ? 'selected' : ''}}>K01 - Bayar Bahan Baku</option>
                    <option value="K02 - Bayar Panjar" {{ $keuangan->kode_akun =='K02 - Bayar Panjar' ? 'selected' : ''}}>K02 - Bayar Panjar</option>
                    <option value="K03 - Operasional" {{ $keuangan->kode_akun =='K03 - Operasional' ? 'selected' : ''}}>K03 - Operasional</option>
                    <option value="K04 - BPJS Kes/TK" {{ $keuangan->kode_akun =='K04 - BPJS Kes/TK' ? 'selected' : ''}}>K04 - BPJS Kes/TK</option>
                    <option value="K05 - Gaji" {{ $keuangan->kode_akun =='K05 - Gaji' ? 'selected' : ''}}>K05 - Gaji</option>
                    <option value="K06 - Sedekah" {{ $keuangan->kode_akun =='K06 - Sedekah' ? 'selected' : ''}}>K06 - Sedekah</option>
                    <option value="K07 - Bayar Listrik, Air" {{ $keuangan->kode_akun =='K07 - Bayar Listrik, Air' ? 'selected' : ''}}>K07 - Bayar Listrik, Air</option>
                    <option value="K08 - WIFI" {{ $keuangan->kode_akun =='K08 - WIFI' ? 'selected' : ''}}>K08 - WIFI</option>
                    <option value="K09 - Transportasi" {{ $keuangan->kode_akun =='K09 - Transportasi' ? 'selected' : ''}}>K09 - Transportasi</option>
                    <option value="K10 - Lembur" {{ $keuangan->kode_akun =='K10 - Lembur' ? 'selected' : ''}}>K10 - Lembur</option>
                    <option value="K11 - Operasional Mobil" {{ $keuangan->kode_akun =='K11 - Operasional Mobil' ? 'selected' : ''}}>K11 - Operasional Mobil</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="">Nominal</label>
                <input type="text" class="form-control" name="nominal" required value="{{$keuangan->nominal}}">
            </div>
            <button type="submit" class="btn btn-primary">Simpan </button>

        </form>
    </div>

@endsection

