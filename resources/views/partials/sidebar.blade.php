<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="/">
          <img src="assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link {{request()->is('dashboard') ? 'active' : ''}}" href="{{route('dashboard')}}">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('pemesanan.index')}}">
                <i class="ni ni-planet text-orange"></i>
                <span class="nav-link-text">Pemesanan Bahan Baku</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('stok.index')}}">
                <i class="ni ni-pin-3 text-primary"></i>
                <span class="nav-link-text">Stok Bahan Baku</span>
              </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('resep.index')}}">
                  <i class="ni ni-basket text-default"></i>
                  <span class="nav-link-text">Resep Roti</span>
                </a>
              </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('produksi.index')}}">
                <i class="ni ni-single-02 text-yellow"></i>
                <span class="nav-link-text">Produksi Roti</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="examples/tables.html">
                <i class="ni ni-bullet-list-67 text-default"></i>
                <span class="nav-link-text">Kasir</span>
              </a>
            </li>

          </ul>
          <!-- Divider -->


        </div>
      </div>
    </div>
  </nav>
