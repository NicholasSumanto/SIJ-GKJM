@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">{{ __('Pengaturan') }}</h1>

    <!-- Main Content goes here -->
    <div class="card shadow">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.data.anggota-jemaat') }}" aria-current="true" href="{{ route('admin.data.anggota-jemaat') }}">DATA JEMAAT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.pengaturan.jabatan-majelis') }}" aria-current="true" href="{{ route('admin.pengaturan.jabatan-majelis') }}">KELUARGA JEMAAT</a>
                </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.pengaturan.jabatan-non-majelis') }}" aria-current="true" href="{{ route('admin.pengaturan.jabatan-non-majelis') }}">JEMAAT BARU</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.pengaturan.user-admin') }}" aria-current="true" href="{{ route('admin.pengaturan.user-admin') }}">MAJELIS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.pengaturan.referensi-pekerjaan') }}" aria-current="true" href="{{ route('admin.pengaturan.referensi-pekerjaan') }}">NON MAJELIS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.pengaturan.referensi-daerah') }}" aria-current="true" href="{{ route('admin.pengaturan.referensi-daerah') }}">JEMAAT TITIPAN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.pengaturan.referensi-daerah') }}" aria-current="true" href="{{ route('admin.pengaturan.referensi-daerah') }}">JEMAAT ULTAH</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Nav::isRoute('admin.pengaturan.referensi-daerah') }}" aria-current="true" href="{{ route('admin.pengaturan.referensi-daerah') }}">JEMAAT ULTAH NIKAH</a>
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
