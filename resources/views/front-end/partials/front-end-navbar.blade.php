<nav class="navbar navbar-expand-lg shadow" id="navbar">
    <div class="container py-2">
        <a class="navbar-brand" href="{{ route('beranda.index') }}">Family Bakery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('beranda.index') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Produk Roti</a>
                </li>
            </ul>
            <div class="d-flex">
                @auth
                    <div class="dropdown">
                        <a href="#" class="nav-link" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('beranda.daftarTransaksi') }}">Daftar
                                    Transaksi</a></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="nav-link">Login</a>

                @endguest
            </div>
        </div>
    </div>
</nav>
