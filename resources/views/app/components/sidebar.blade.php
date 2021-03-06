<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-cut"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Scott Barber</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Keuangan
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ request()->is('daily-transactions') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('daily-transactions') }}">
            <i class="fa-solid fa-money-bill-transfer"></i>
            <span>Transaksi Harian</span></a>
    </li>
    @if (auth()->user()->role == 'admin')
    <li class="nav-item {{ request()->is('journal') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('journal') }}">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Jurnal Keuangan</span></a>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if (auth()->user()->role == 'admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Data Master
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ request()->is('employee') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('employee') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Karyawan</span></a>
        </li>
        <li class="nav-item {{ request()->is('package') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('package') }}">
                <i class="fa-solid fa-fw fa-hand-holding-heart"></i>
                <span>Paket Jasa</span></a>
        </li>
        <li class="nav-item {{ request()->is('item') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('item') }}">
                <i class="fa-solid fa-fw fa-box"></i>
                <span>Barang</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    @endif
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
