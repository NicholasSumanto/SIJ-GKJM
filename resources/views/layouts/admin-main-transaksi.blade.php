@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">{{ __('Transaksi') }}</h1>

    <!-- Main Content goes here -->
    <div class="card shadow">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.transaksi.pernikahan') }}" aria-current="true" href="{{ route('admin.transaksi.pernikahan') }}">PERNIKAHAN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.transaksi.kematian') }}" aria-current="true" href="{{ route('admin.transaksi.kematian') }}">KEMATIAN</a>
                </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.transaksi.atestasi-keluar*') }}" aria-current="true" href="{{ route('admin.transaksi.atestasi-keluar') }}">ATESTASI KELUAR</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.transaksi.atestasi-masuk') }}" aria-current="true" href="{{ route('admin.transaksi.atestasi-masuk') }}">ATESTASI MASUK</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.transaksi.baptis-anak') }}" aria-current="true" href="{{ route('admin.transaksi.baptis-anak') }}">BAPTIS ANAK</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.transaksi.baptis-dewasa') }}" aria-current="true" href="{{ route('admin.transaksi.baptis-dewasa') }}">BAPTIS DEWASA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.transaksi.baptis-sidi') }}" aria-current="true" href="{{ route('admin.transaksi.baptis-sidi') }}">BAPTIS SIDI</a>
                </li>
            </ul>
        </div>
        @yield('content')
    </div>

    <!-- End of Main Content -->
@endsection

@push('notif')
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
@endpush
