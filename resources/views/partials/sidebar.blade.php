<nav class="sidenav navbar navbar-vertical  fixed-left navbar-expand-xs navbar-expand-lg navbar-light bg-white"
    id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="/">
                <h1 class="fw-900">Family Bakery </h1>
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="ni ni-tv-2 text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('keuangan-harian.index') }}">
                            <i class="ni ni-money-coins text-success"></i>
                            <span class="nav-link-text">Keuangan Harian</span>
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('keuangan-harian.index') }}">
                            <i class="ni ni-money-coins text-danger"></i>
                            <span class="nav-link-text">Keuangan Bulanan</span>
                        </a>
                    </li> --}}
                    @can('pemesanan_bahan_baku-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pemesanan.index') }}">
                                <i class="ni ni-planet text-orange"></i>
                                <span class="nav-link-text">Pemesanan Bahan Baku</span>
                            </a>
                        </li>
                    @endcan

                    {{-- @can('pemesanan_bahan_baku-list') --}}

                    {{-- @endcan --}}

                    @can('stok_bahan_baku-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('stok.index') }}">
                                <i class="ni ni-pin-3 text-primary"></i>
                                <span class="nav-link-text">Stok Bahan Baku</span>
                            </a>
                        </li>
                    @endcan
                    @can('resep_roti-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('resep.index') }}">
                                <i class="ni ni-basket text-default"></i>
                                <span class="nav-link-text">Resep Roti</span>
                            </a>
                        </li>
                    @endcan
                    @can('produksi_roti-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('produksi.index') }}">
                                <i class="ni ni-square-pin text-yellow"></i>
                                <span class="nav-link-text">Perencanaan Produksi Roti</span>
                            </a>
                        </li>
                    @endcan


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('realisasi.index') }}">

                            <i class="ni ni-tag text-primary"></i>
                            <span class="nav-link-text">Realisasi Produksi Roti</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('katalog.index') }}">

                            <i class="ni ni-bold-up text-success"></i>
                            <span class="nav-link-text">Katalog Roti</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('pemesanan-online.index')}}">

                            <i class="ni ni-cart text-danger"></i>
                            <span class="nav-link-text">Pemesanan Online</span>
                        </a>
                    </li>

                    @can('kasir-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kasir.index') }}">
                                <i class="ni ni-shop text-default"></i>
                                <span class="nav-link-text">Data Penjualan/Kasir Keseluruhan</span>
                            </a>
                        </li>
                    @endcan
                    @can('kasir-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kasir.indexCustomer') }}">
                                <i class="ni ni-shop text-primary"></i>
                                <span class="nav-link-text">Penjualan Customer</span>
                            </a>
                        </li>
                    @endcan
                    @can('kasir-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kasir.indexPemesanan') }}">
                                <i class="ni ni-shop text-warning"></i>
                                <span class="nav-link-text">Penjualan Pemesanan</span>
                            </a>
                        </li>
                    @endcan
                    @can('user-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <i class="ni ni-single-02 text-default"></i>
                                <span class="nav-link-text">User</span>
                            </a>
                        </li>
                    @endcan


                    {{-- @can('role-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('roles.index') }}">
                                <i class="ni ni-user-run text-default"></i>
                                <span class="nav-link-text">Role</span>
                            </a>
                        </li>
                    @endcan --}}




                </ul>
                <!-- Divider -->


            </div>
        </div>
    </div>
</nav>
