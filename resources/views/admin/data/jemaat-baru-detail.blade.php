@extends('layouts.admin-main-data')

@section('title', 'Detail Jemaat Baru')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
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
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.data.jemaat-baru') }}">Daftar
                        Jemaat</a></li>
                <li class="breadcrumb-item active">Detail Jemaat ({{ $jemaat->nama_jemaat }})</li>
            </ol>
        </nav>
        <a href="" class="btn btn-primary tambah-jemaat">Eksport Jemaat</a>
        <button class="btn btn-success btn-validasi" style="color: white;" data-id="{{ $jemaat->id_jemaat }}">Validasi
            Status
            Jemaat</button>

        <div class="biodata-title mt-4">Biodata</div>
        <div style="overflow-x: auto; width: 100%;">
            <table class="table table-bordered table-striped" style="width: 100%;">
                <tr>
                    <th>ID Jemaat</th>
                    <td>{{ $jemaat->id_jemaat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nama Jemaat</th>
                    <td>{{ $jemaat->nama_jemaat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tempat Lahir</th>
                    <td>{{ $jemaat->tempat_lahir ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>{{ $jemaat->tanggal_lahir ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $jemaat->kelamin ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Golongan Darah</th>
                    <td>{{ $jemaat->golongan_darah ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $jemaat->alamat_jemaat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kelurahan</th>
                    <td>{{ $jemaat->nama_kelurahan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kecamatan</th>
                    <td>{{ $jemaat->nama_kecamatan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kabupaten</th>
                    <td>{{ $jemaat->nama_kabupaten ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Provinsi</th>
                    <td>{{ $jemaat->nama_provinsi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kodepos</th>
                    <td>{{ $jemaat->kodepos ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No. Telepon</th>
                    <td>{{ $jemaat->telepon ?? '-' }}</td>
                </tr>
                <tr>
                    <th>HP</th>
                    <td>{{ $jemaat->hp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $jemaat->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>NIK</th>
                    <td>{{ $jemaat->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No KK</th>
                    <td>{{ $jemaat->no_kk ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Wilayah</th>
                    <td>{{ $jemaat->wilayah['nama_wilayah'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $jemaat->status['keterangan_status'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Gereja Baptis</th>
                    <td>{{ $jemaat->gereja_baptis ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Instansi</th>
                    <td>{{ $jemaat->instansi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Pekerjaan</th>
                    <td>{{ $jemaat->id_pekerjaan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Penghasilan</th>
                    <td>{{ $jemaat->penghasilan !== null ? number_format($jemaat->penghasilan, 0, ',', '.') : '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Stamboek</th>
                    <td>{{ $jemaat->stamboek ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Baptis</th>
                    <td>{{ $jemaat->tanggal_baptis ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alat Transportasi</th>
                    <td>{{ $jemaat->alat_transportasi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>
                        Foto <br>
                        @if ($jemaat->photo_url !== null)
                            <a href="{{ $jemaat->photo_url }}" target="_blank" class="btn btn-secondary mb-2 btn-sm">Lihat
                                Detail Foto</a>
                        @endif
                    </th>
                    <td>
                        @if ($jemaat->photo_url !== null)
                            <img src="{{ $jemaat->photo_url }}" alt="Foto Jemaat" width="200">
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </table>
        </div>
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

    <script>
        $(document).ready(function() {
            // Event listener untuk tombol edit
            $(document).on('click', '.btn-validasi', function(event) {
                event.preventDefault();
                var id_jemaat = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    html: `<div class="text-delete">You won't be able to revert this!</div>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Validasi Jemaat!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('api.post.validasi.jemaat') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_jemaat: id_jemaat
                            },
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data Jemaat Baru berhasil divalidasi!'
                                }).then(() => {
                                    window.location.href =
                                        "{{ route('admin.data.jemaat-baru') }}";
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data Jemaat Baru gagal divalidasi!',
                                    text: xhr.responseJSON.message ||
                                        'Terjadi kesalahan saat menghapus data.'
                                });
                            }
                        });
                    }
                });
            });

            function ApiGetJemaatById(id_jemaat, params) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('api.get.jemaat.by.id', ['id_jemaat' => '__ID__']) }}".replace('__ID__',
                        id_jemaat),
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: "json",
                    success: function(data) {
                        params.success(data);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                        console.error("Status: " + status);
                        console.dir(xhr);

                    }
                });
            }
        });
    </script>
@endpush
