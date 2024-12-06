    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 60px; height: 60px;">
            </div>
            <div class="sidebar-brand-text mx-3">GKJ Mergangsan<sup>v2</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDashboard" aria-expanded="false" aria-controls="collapseDashboard">
                <i class="fa-solid fa-gauge-high"></i>
                <span>{{ __('Dashboard') }}</span>
            </a>
            <div id="collapseDashboard" class="collapse" aria-labelledby="headingDashboard" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Dashboard</h6>
                    <a class="collapse-item" href="{{ route('admin.dashboard') }}">Dashboard Jemaat</a>
                    <a class="collapse-item" href="{{ route('admin.birthdayDash') }}">Dashboard Ulangtahun</a>
                    <a class="collapse-item" href="{{ route('admin.dashboardUsia') }}">Dashboard Usia</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            {{ __('Tambahan') }}
        </div>

        <!-- Nav Item -->
        <li class="nav-item {{ Nav::isRoute('admin.pengaturan.*') }}">
            <a class="nav-link" href="{{ route('admin.pengaturan.wilayah') }}">
                <i class="fa-solid fa-gear"></i>
                <span>{{ __('Pengaturan') }}</span>
            </a>
        </li>

        <!-- Nav Item -->
        <li class="nav-item {{ Nav::isRoute('admin.data.*') }}">
            <a class="nav-link" href="{{ route('admin.data.anggota-jemaat') }}">
                <i class="fa-solid fa-book"></i>
                <span>{{ __('Data') }}</span>
            </a>
        </li>
        <!-- Nav Item -->
        <li class="nav-item {{ Nav::isRoute('admin.transaksi.*') }}">
            <a class="nav-link" href="{{ route('admin.transaksi.pernikahan') }}">
                <i class="fa-solid fa-right-left"></i>
                <span>{{ __('Transaksi') }}</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->
