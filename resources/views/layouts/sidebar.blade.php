<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fab fa-playstation"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RentalPS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @if (auth()->user()->status === 'admin' || auth()->user()->status === 'owner')
        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ $active === 'dashboard' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if (auth()->user()->status === 'admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Menu Utama
        </div>

        <li class="nav-item {{ $active === 'member' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('members.index') }}">
                <i class="fas fa-users"></i>
                <span>Data Member</span></a>
        </li>

        <li class="nav-item {{ $active === 'play' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('playstation.index') }}">
                <i class="fas fa-gamepad"></i>
                <span>Data Playstation</span></a>
        </li>
    @endif

    @if (auth()->user()->status === 'user' || auth()->user()->status === 'admin')
        <li class="nav-item {{ $active === 'device' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('device.index') }}">
                <i class="fas fa-tv"></i>
                <span>Data Perangkat</span></a>
        </li>

        <li class="nav-item {{ $active === 'transaction' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('transaction.index') }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Transaksi</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
    @endif

    @if (auth()->user()->status === 'admin' || auth()->user()->status === 'owner')
        <!-- Heading -->
        <div class="sidebar-heading">
            Laporan
        </div>

        <!-- Nav Item - Pages Collapse Menu -->


        <!-- Nav Item - Charts -->
        <li class="nav-item {{ $active === 'report' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('report') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Laporan</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
