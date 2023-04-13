<style>

ul {
    text-align: left;
}

li {
    list-style-type: none;
}
</style>

@if (session('errors'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan.',
            html: '<ul>@foreach (session('errors')->all() as $error)<li>- {{ $error }}</li>@endforeach</ul>',
        });
    </script>
@endif



@if (session('success'))
    <script>
        Swal.fire({
            type: 'success',
            title: 'Sukses',
            text: '{{ session('success') }}',
        });
    </script>
@endif


@if (session('info'))
    <script>
        Swal.fire({
            type: 'info',
            title: 'Informasi',
            text: '{{ session('info') }}',
        });
    </script>
@endif

@if (session('warning'))
    <script>
        Swal.fire({
            type: 'warning',
            title: 'Peringatan',
            text: '{{ session('warning') }}',
        });
    </script>
@endif

@if (session('confirmation'))
    <script>
        Swal.fire({
            type: 'question',
            title: 'Konfirmasi',
            text: '{{ session('confirmation') }}',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                // Lakukan tindakan jika tombol "Ya" ditekan
            } else {
                // Lakukan tindakan jika tombol "Tidak" ditekan atau modal ditutup
            }
        });
    </script>
@endif
