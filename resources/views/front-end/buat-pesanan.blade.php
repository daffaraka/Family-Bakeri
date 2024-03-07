@extends('front-end.layout-beranda')
@section('title', 'Buat Pesanan')
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <form action="{{route('beranda.storePesanan',$data->id)}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                        <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan"   placeholder="Nama anda pemesan">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_pesanan" class="form-label">Deskripsi Pesanan</label>
                        <textarea class="form-control" id="deskripsi_pesanan" name="deskripsi_pesanan" rows="4"  ></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="nama_pemesan" class="form-label">Kontak anda</label>
                        <input type="text" class="form-control" id="kontak_pemesan" name="kontak_pemesan"   placeholder="Kontak yang bisa dihubungi">
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Jumlah Pesanan</label>
                        <input type="number" class="form-control" id="jumlah_pesanan" name="jumlah_pesanan"  >
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Tanggal diambil</label>
                        <input type="date" class="form-control" id="tanggal_diambil" name="tanggal_diambil"  >
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
                </form>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <!-- Tempat untuk menampilkan detail pesanan Roti -->
                <h3>Detail Pesanan Roti</h3>
                <p>Nama Resep Roti: {{ $data->resepRoti->nama_resep_roti }}</p>
                <p>Nama Bahan Baku: {{ $data->nama_bahan_baku }}</p>
                <p>Stok Sekarang: {{ $data->stok_sekarang }}</p>
                <p>Laku: {{ $data->laku }}</p>
                <p>Harga: Rp. {{ number_format($data->harga) }}</p>
            </div>
        </div>
    </div>
@endsection
