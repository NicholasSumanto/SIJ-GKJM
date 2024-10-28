@extends('layouts.admin-main-pengaturan')

@section('title', 'Pengaturan Referensi Daerah Kelurahan')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
@endpush

@section('content')
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ route('admin.pengaturan.referensi-daerah') }}">Provinsi
                        ({{ $provinsi->nama_provinsi }})</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.pengaturan.referensi-daerah-kabupaten', $provinsi->id_provinsi) }}">Kabupaten
                        ({{ $kabupaten->kabupaten }})</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.pengaturan.referensi-daerah-kecamatan', $kabupaten->id_kabupaten) }}">Kecamatan
                        ({{ $kecamatan->kecamatan }})</a></li>
                <li class="breadcrumb-item" aria-current="page">Kelurahan</li>
            </ol>
        </nav>
        <a href="" class="btn btn-success tambah-daerah-kelurahan">Tambah Referensi Daerah</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetReferensiDaerahKelurahan">
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
    <script>
        var $table = $('#table');
        $(document).ready(function() {
            // Initialize bootstrap table
            $table.bootstrapTable({
                columns: [{
                    field: 'id_kelurahan',
                    title: 'ID Kelurahan'
                }, {
                    field: 'kelurahan',
                    title: 'Nama Kelurahan'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_kelurahan}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColumn: [2]
                }
            });

            // Handle perubahan toolbar select
            $('#toolbar').find('select').change(function() {
                var exportDataType = $(this).val();
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: exportDataType,
                    exportTypes: ['excel', 'pdf'],
                    columns: [{
                        field: 'state',
                        checkbox: true,
                        visible: exportDataType === 'selected'
                    }, {
                        field: 'id_kelurahan',
                        title: 'ID Kelurahan'
                    }, {
                        field: 'kelurahan',
                        title: 'Nama Kelurahan'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_kelurahan}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [2]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah wilayah
            $('.tambah-daerah-kelurahan').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Wilayah Kelurahan Baru',
                    html: `
                        <form id="addWilayahBaru">
                           <div class="form-group">
                                <label for="id_kelurahan">ID Kelurahan *</label>
                                <input type="text" id="id_kelurahan" class="form-control" placeholder="ID Kelurahan" required disabled>
                            </div>
                            <div class="form-group mb-0">
                                <label for="nama_kelurahan">Nama Kelurahan *</label>
                                <select id="nama_kelurahan" class="form-control" required>
                                    <option value="">Pilih Nama Kelurahan</option>
                                    <!-- AJAX -->
                                </select>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $.ajax({
                            url: "{{ route('api.proxy.wilayah') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_provinsi: `{{ $provinsi->id_provinsi }}`,
                                id_kabupaten: `{{ str_pad($kabupaten->id_kabupaten - $provinsi->id_provinsi * 100, 2, '0', STR_PAD_LEFT) }}`,
                                id_kecamatan: `0{{ str_pad($kecamatan->id_kecamatan - $kabupaten->id_kabupaten * 1000, 2, '0', STR_PAD_LEFT) }}`
                            },
                            dataType: "json",
                            success: function(response) {
                                const $kelurahanSelect = $('#nama_kelurahan');
                                Object.entries(response).forEach(function([key,
                                    value
                                ]) {
                                    $kelurahanSelect.append(
                                        `<option value="${value}" data-key="${key}">${value}</option>`
                                    );
                                });

                                $kelurahanSelect.on('change', function() {
                                    const selectedKey = $(this).find(
                                        'option:selected').data('key');

                                    $('#id_kelurahan').val(selectedKey);
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', 'Gagal memuat data wilayah',
                                    'error');
                            }
                        });
                    },
                    preConfirm: () => {
                        const id_kelurahan = $('#id_kelurahan').val();
                        const nama_kelurahan = $('#nama_kelurahan').val();

                        // Validasi input
                        if (!id_kelurahan || !nama_kelurahan) {
                            Swal.showValidationMessage(
                                'Terdapat bagian yang tidak valid atau belum diisi!');
                            return false;
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.kelurahan') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id_kelurahan
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'Kelurahan sudah ada, silahkan gunakan kelurahan lain!'
                                        );
                                    } else {
                                        resolve({
                                            id_kelurahan: id_kelurahan,
                                            nama_kelurahan: nama_kelurahan,
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    reject(
                                        'Terjadi kesalahan saat memvalidasi kabupaten.'
                                    );
                                }
                            });
                        }).catch(error => {
                            Swal.showValidationMessage(error);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value) {
                        const {
                            id_kelurahan,
                            nama_kelurahan,
                        } = result.value;

                        $.ajax({
                            url: "{{ route('api.post.kelurahan') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_kecamatan: `{{ $kecamatan->id_kecamatan }}`,
                                id_kelurahan: id_kelurahan,
                                nama_kelurahan: nama_kelurahan
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data kelurahan berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data kelurahan gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.btn-delete', function() {
                event.preventDefault();
                var id_kelurahan = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    html: `<div class="text-delete">You won't be able to revert this!</div>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('api.delete.kelurahan') }}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_kelurahan: id_kelurahan
                            },
                            dataType: "json",
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data kelurahan berhasil dihapus!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data kelurahan gagal dihapus!'
                                });
                            }
                        });
                    }
                });
            });
        });

        function ApiGetReferensiDaerahKelurahan(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.kelurahan') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_kecamatan: `{{ $kecamatan->id_kecamatan }}`
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
    </script>
@endpush
