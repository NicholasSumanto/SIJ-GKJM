@extends('layouts.admin-main-data')

@section('title', 'Anggota Jemaat')

@push('css')
    <style>
        .biodata-title {
            background-color: #d9edf7;
            padding: 10px;
            font-weight: bold;
        }

        th {
            font-weight: normal;
        }
    </style>
@endpush

@section('content')
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.data.anggota-jemaat') }}">Daftar
                        Jemaat</a></li>
                <li class="breadcrumb-item active">Detail Jemaat ({{ $jemaat->nama_jemaat }})</li>
            </ol>
        </nav>
        <a href="" class="btn btn-success tambah-jemaat">Eksport Jemaat</a>

        <div class="biodata-title mt-4">Biodata</div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID Jemaat</th>
                <td>{{ $jemaat->id_jemaat }}</td>
            </tr>
            <tr>
                <th>Nama Jemaat</th>
                <td>{{ $jemaat->nama_jemaat }}</td>
            </tr>
            <tr>
                <th>Tempat Lahir</th>
                <td>{{ $jemaat->tempat_lahir }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $jemaat->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $jemaat->kelamin }}</td>
            </tr>
            <tr>
                <th>Golongan Darah</th>
                <td>{{ $jemaat->golongan_darah }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $jemaat->alamat_jemaat }}</td>
            </tr>
            <tr>
                <th>Kodepos</th>
                <td>{{ $jemaat->kodepos }}</td>
            </tr>
            <tr>
                <th>No. Telepon</th>
                <td>{{ $jemaat->telepon }}</td>
            </tr>
            <tr>
                <th>HP</th>
                <td>{{ $jemaat->hp }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $jemaat->email }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>{{ $jemaat->nik }}</td>
            </tr>
            <tr>
                <th>No KK</th>
                <td>{{ $jemaat->no_kk }}</td>
            </tr>
            <tr>
                <th>Wilayah</th>
                <td>{{ $jemaat->wilayah['nama_wilayah'] }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $jemaat->status['keterangan_status'] }}</td>
            </tr>
            <tr>
                <th>Gereja Baptis</th>
                <td>{{ $jemaat->gereja_baptis }}</td>
            </tr>
            <tr>
                <th>Instansi</th>
                <td>{{ $jemaat->instansi }}</td>
            </tr>
            <tr>
                <th>Pekerjaan</th>
                <td>{{ $jemaat->id_pekerjaan }}</td>
            </tr>
            <tr>
                <th>Penghasilan</th>
                <td>{{ number_format($jemaat->penghasilan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Stamboek</th>
                <td>{{ $jemaat->stamboek }}</td>
            </tr>
            <tr>
                <th>Tanggal Baptis</th>
                <td>{{ $jemaat->tanggal_baptis }}</td>
            </tr>
            <tr>
                <th>Alat Transportasi</th>
                <td>{{ $jemaat->alat_transportasi }}</td>
            </tr>
            <tr>
                <th>Foto</th>
                <td>
                    @if ($jemaat->photo !== null)
                        <img src="{{ $jemaat->photo }}" alt="Foto Jemaat" width="200">
                    @endif
                </td>
            </tr>
        </table>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/bootstrap-table.js') }}"></script>
    <script src="{{ asset('js/table-export/jsPDF/polyfills.umd.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-table-export.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
    <script src="{{ asset('js/table-export/jsPDF/jspdf.umd.min.js') }}"></script>
    <script src="{{ asset('js/table-export/FileSaver/FileSaver.min.js') }}"></script>
    <script src="{{ asset('js/table-export/js-xlsx/xlsx.core.min.js') }}"></script>
    <script src="{{ asset('js/table-export/html2canvas/html2canvas.min.js') }}"></script>
    <script src="{{ asset('js/table-export/filter-control/bootstrap-table-filter-control.js') }}"></script>
    <script src="{{ asset('js/table-export/filter-control/utils.js') }}"></script>
@endpush
