<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
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
                    @can('pemesanan_bahan_baku-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pemesanan.index') }}">
                                <i class="ni ni-planet text-orange"></i>
                                <span class="nav-link-text">Pemesanan Bahan Baku</span>
                            </a>
                        </li>
                    @endcan

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
                                <span class="nav-link-text">Produksi Roti</span>
                            </a>
                        </li>
                    @endcan

                    @can('kasir-list')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kasir.index') }}">
                                <i class="ni ni-shop text-default"></i>
                                <span class="nav-link-text">Kasir</span>
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
