@extends('layouts.admin-main-pengaturan')

@section('title', 'Pengaturan Referensi Daerah Kecamatan')

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
                <li class="breadcrumb-item active"><a
                        href="{{ route('admin.pengaturan.referensi-daerah-kabupaten', $provinsi->id_provinsi) }}">Kabupaten
                        ({{ $kabupaten->kabupaten }})</a></li>
                <li class="breadcrumb-item" aria-current="page">Kecamatan</li>
            </ol>
        </nav>
        <a href="" class="btn btn-success tambah-daerah-kecamatan">Tambah Referensi Daerah</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetReferensiDaerahKecamatan">
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
                    field: 'id_kecamatan',
                    title: 'ID Kecamatan'
                }, {
                    field: 'kecamatan',
                    title: 'Nama Kecamatan'
                }, {
                    field: 'view',
                    title: 'View',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-success btn-view" data-id="${row.id_kecamatan}">View</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_kecamatan}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColumn: [2, 3, 4]
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
                        field: 'id_kecamatan',
                        title: 'ID Kecamatan'
                    }, {
                        field: 'kecamatan',
                        title: 'Nama Kecamatan'
                    }, {
                        field: 'view',
                        title: 'View',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-success btn-view" data-id="${row.id_kecamatan}">View</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_kecamatan}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [2, 3, 4]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah wilayah
            $('.tambah-daerah-kecamatan').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Daerah kecamatan',
                    html: `
                        <form id="addDaerahKecamatanBaru">
                           <div class="form-group">
                                <label for="id_kecamatan">ID Kecamatan *</label>
                                <input type="text" id="id_kecamatan" class="form-control" placeholder="ID Kecamatan" required disabled>
                            </div>
                            <div class="form-group mb-0">
                                <label for="nama_kecamatan">Nama Kecamatan *</label>
                                <select id="nama_kecamatan" class="form-control" required>
                                    <option value="">Pilih Nama Kecamatan</option>
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
                                id_kabupaten: `{{ str_pad($kabupaten->id_kabupaten - $provinsi->id_provinsi * 100, 2, '0', STR_PAD_LEFT) }}`
                            },
                            dataType: "json",
                            success: function(response) {
                                const $kecamatanSelect = $('#nama_kecamatan');
                                Object.entries(response).forEach(function([key,
                                    value
                                ]) {
                                    $kecamatanSelect.append(
                                        `<option value="${value}" data-key="${key}">${value}</option>`
                                    );
                                });

                                $kecamatanSelect.on('change', function() {
                                    const selectedKey = $(this).find(
                                        'option:selected').data('key');

                                    $('#id_kecamatan').val(selectedKey);
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', 'Gagal memuat data wilayah',
                                    'error');
                            }
                        });
                    },
                    preConfirm: () => {
                        const id_kecamatan = $('#id_kecamatan').val();
                        const nama_kecamatan = $('#nama_kecamatan').val();

                        // Validasi input
                        if (!id_kecamatan || !nama_kecamatan) {
                            Swal.showValidationMessage(
                                'Terdapat bagian yang tidak valid atau belum diisi!');
                            return false;
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.kecamatan') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id_kecamatan
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'Kecamatan sudah ada, silahkan gunakan kabupaten lain!'
                                        );
                                    } else {
                                        resolve({
                                            id_kecamatan: id_kecamatan,
                                            nama_kecamatan: nama_kecamatan,
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
                            id_kecamatan,
                            nama_kecamatan,
                        } = result.value;

                        $.ajax({
                            url: "{{ route('api.post.kecamatan') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_kabupaten: '{{ $kabupaten->id_kabupaten }}',
                                id_kecamatan: id_kecamatan,
                                nama_kecamatan: nama_kecamatan
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data kecamatan berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data kecamatan gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.btn-view', function() {
                var id_Kecamatan = $(this).data('id');

                var url = '{{ route('admin.pengaturan.referensi-daerah-kelurahan', ':id') }}';
                url = url.replace(':id', id_Kecamatan);

                window.location.href = url;
            });

            $(document).on('click', '.btn-delete', function() {
                event.preventDefault();
                var id_kecamatan = $(this).data('id');

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
                            url: `{{ route('api.delete.kecamatan') }}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_kecamatan: id_kecamatan
                            },
                            dataType: "json",
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data kecamatan berhasil dihapus!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data kecamatan gagal dihapus!'
                                });
                            }
                        });
                    }
                });
            });
        });

        function ApiGetReferensiDaerahKecamatan(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.kecamatan') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_kabupaten: `{{ $kabupaten->id_kabupaten }}`
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
