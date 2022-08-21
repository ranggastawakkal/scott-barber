<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/logo.jpeg') }}" class="sidebar-logo" alt="Logo">
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
    <li class="nav-item {{ request()->is('journal*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseJournal"
        aria-expanded="true" aria-controls="collapseJournal">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Jurnal Keuangan</span>
        </a>
        <div id="collapseJournal" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('journal/cash-flow') ? 'active' : '' }}" href="{{ route('cash-flow') }}">Arus Kas</a>
                <a class="collapse-item {{ request()->is('journal/income-statement') ? 'active' : '' }}" href="{{ route('income-statement') }}">Laba / Rugi</a>
            </div>
        </div>
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
