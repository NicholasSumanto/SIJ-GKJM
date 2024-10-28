@extends('layouts.admin-main-pengaturan')

@section('title', 'Pengaturan Referensi Daerah Kabupaten')

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
                <li class="breadcrumb-item" aria-current="page">Kabupaten</li>
            </ol>
        </nav>
        <a href="" class="btn btn-success tambah-daerah-kabupaten">Tambah Referensi Daerah</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetReferensiDaerahKabupaten">
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
                    field: 'id_kabupaten',
                    title: 'ID Kabupaten'
                }, {
                    field: 'kabupaten',
                    title: 'Nama Kabupaten'
                }, {
                    field: 'view',
                    title: 'View',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-success btn-view" data-id="${row.id_kabupaten}">View</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_kabupaten}">Delete</button>`;
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
                        field: 'id_kabupaten',
                        title: 'ID Kabupaten'
                    }, {
                        field: 'kabupaten',
                        title: 'Nama Kabupaten'
                    }, {
                        field: 'view',
                        title: 'View',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-success btn-view" data-id="${row.id_kabupaten}">View</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_kabupaten}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [2, 3, 4]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah wilayah
            $('.tambah-daerah-kabupaten').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Wilayah Kabupaten Baru',
                    html: `
                        <form id="addWilayahBaru">
                           <div class="form-group">
                                <label for="id_kabupaten">ID kabupaten *</label>
                                <input type="text" id="id_kabupaten" class="form-control" placeholder="ID Kabupaten" required disabled>
                            </div>
                            <div class="form-group mb-0">
                                <label for="kabupaten"> Kabupaten *</label>
                                <select id="kabupaten" class="form-control" required>
                                    <option value="">Pilih  Kabupaten</option>
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
                                id_provinsi: `{{ $provinsi->id_provinsi }}`
                            },
                            dataType: "json",
                            success: function(response) {
                                const $kabupatenSelect = $('#kabupaten');
                                Object.entries(response).forEach(function([key,
                                    value
                                ]) {
                                    $kabupatenSelect.append(
                                        `<option value="${value}" data-key="${key}">${value}</option>`
                                    );
                                });

                                $kabupatenSelect.on('change', function() {
                                    const selectedKey = $(this).find(
                                        'option:selected').data('key');

                                    $('#id_kabupaten').val(selectedKey);
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', 'Gagal memuat data wilayah',
                                    'error');
                            }
                        });
                    },
                    preConfirm: () => {
                        const id_kabupaten = $('#id_kabupaten').val();
                        const kabupaten = $('#kabupaten').val();

                        // Validasi input
                        if (!id_kabupaten || !kabupaten) {
                            Swal.showValidationMessage(
                                'Terdapat bagian yang tidak valid atau belum diisi!');
                            return false;
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.kabupaten') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id_kabupaten
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'Kabupaten sudah ada, silahkan gunakan kabupaten lain!'
                                        );
                                    } else {
                                        resolve({
                                            id_kabupaten: id_kabupaten,
                                            kabupaten: kabupaten,
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
                            id_kabupaten,
                            kabupaten,
                        } = result.value;

                        $.ajax({
                            url: "{{ route('api.post.kabupaten') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_provinsi: `{{ $provinsi->id_provinsi }}`,
                                id_kabupaten: id_kabupaten,
                                kabupaten: kabupaten
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data kabupaten berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data kabupaten gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.btn-view', function() {
                var id_Kabupaten = $(this).data('id');

                var url = '{{ route('admin.pengaturan.referensi-daerah-kecamatan', ':id') }}';
                url = url.replace(':id', id_Kabupaten);

                window.location.href = url;
            });

            $(document).on('click', '.btn-delete', function() {
                event.preventDefault();
                var id_kabupaten = $(this).data('id');

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
                            url: `{{ route('api.delete.kabupaten') }}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_kabupaten: id_kabupaten
                            },
                            dataType: "json",
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data provinsi berhasil dihapus!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data provinsi gagal dihapus!'
                                });
                            }
                        });
                    }
                });
            });
        });

        function ApiGetReferensiDaerahKabupaten(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.kabupaten') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_provinsi: `{{ $provinsi->id_provinsi }}`
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
