@extends('layout')
@section('title', 'Bahan Baku - Family Bakery')
@section('content')
    <style>
        td {
            font-size: 1rem !important;
        }

        .dataTables_length,
        .dataTables_length select {
            font-size: 1em;
            margin: 10px 0;
            padding: 0;
            width: 50px !important;
        }
    </style>
    <div class="container py-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label><strong>Status :</strong></label>
                    <select id="status" class="form-control" style="width: 200px">
                        <option value="">--Pilih Status--</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Dibayar">Dibayar</option>
                        <option value="Sedang Diantar">Sedang Diantar</option>

                    </select>
                </div>
            </div>
        </div>
        <a href="{{ route('pemesanan.create') }}" class="btn btn-sm btn-primary my-2 py-2 rounded"> <i class="fa fa-plus"
                aria-hidden="true"></i> Tambah Bahan Baku</a>
        <table class="table table-hover table-light table-striped" id="dataTable">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Bahan Baku</th>
                    <th scope="col">Jumlah Pesanan</th>
                    <th scope="col">Harga Satuan</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">Status</th>
                    <th scope="col">Jumlah DP</th>
                    <th scope="col">Deadline DP</th>
                    <th scope="col">Sisa Pembayaran</th>
                    <th scope="col">Tanggal Pesanan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @forelse ($bb as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama_bahan_baku }}</td>
                        <td>{{ $data->jumlah_pesanan }}</td>
                        <td>Rp.{{ number_format($data->harga_satuan) }}</td>
                        <td>Rp.{{ number_format($data->total_harga) }}</td>
                        <td> <button
                                class="btn py-1 btn-{{ $data->status_pesanan == 'Sedang Diantar' ? 'primary' : ($data->status_pesanan == 'Diterima' ? 'success' : 'info') }}">{{ $data->status_pesanan }}
                            </button> </td>
                        <td>{{ $data->created_at }}</td>
                        <td>
                            <a href="{{ route('pemesanan.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('pemesanan.delete', $data->id) }}" class="btn btn-danger">Hapus</a>

                        </td>

                    </tr>
                @empty
                    <h3>Belum ada data</h3>
                @endforelse --}}

            </tbody>
        </table>
    </div>




@endsection
@include('partials.scripts')
<script>
    //
    $(function() {

        var table = $('#dataTable').DataTable({
            language: {
                paginate: {
                    previous: '<span class="fa fa-chevron-left"></span>',
                    next: '<span class="fa fa-chevron-right"></span>' // or '→'

                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('pemesanan.index') }}",
                data: function(d) {
                    d.status = $('#status').val(),
                        d.search = $('input[type="search"]').val()
                }
            },

            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama_bahan_baku',
                    name: 'nama_bahan_baku'
                },
                {
                    data: 'jumlah_pesanan',
                    name: 'jumlah_pesanan'
                },
                {
                    data: 'harga_satuan',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'total_harga',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'status_pesanan',
                    name: 'status_pesanan'
                },
                {
                    data: 'dp',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'deadline_dp',
                    type: 'num',
                    render: {
                        _: 'display',
                        sort: 'timestamp'
                    }
                },
                {
                    data: 'sisa_pembayaran',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp.')
                },
                {
                    data: 'created_at',
                    type: 'num',
                    render: {
                        _: 'display',
                        sort: 'timestamp'
                    }
                },
                {
                    data: 'action',
                }
            ]
        });

        $('#status').change(function() {
            table.draw();
        });
    });
</script>
