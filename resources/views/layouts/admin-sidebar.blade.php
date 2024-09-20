    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">GKJ Mergangsan<sup>v2</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ Nav::isRoute('home') }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fa-solid fa-gauge-high"></i>
                <span>{{ __('Dashboard') }}</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            {{ __('Settings') }}
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
            <a class="nav-link" href="{{ route('admin.pengaturan.wilayah') }}">
                <i class="fa-solid fa-book"></i>
                <span>{{ __('Data') }}</span>
            </a>
        </li>
        <!-- Nav Item -->
        <li class="nav-item">
            <a class="nav-link" href="">
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
