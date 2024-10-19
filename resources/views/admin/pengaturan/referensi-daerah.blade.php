@extends('layouts.admin-main-pengaturan')

@section('title', 'Pengaturan Referensi Daerah Provinsi')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
@endpush

@section('content')
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Provinsi</li>
            </ol>
        </nav>
        <a href="" class="btn btn-success tambah-daerah">Tambah Referensi Daerah</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetReferensiDaerah">
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
                    field: 'id_provinsi',
                    title: 'ID Provinsi'
                }, {
                    field: 'nama_provinsi',
                    title: 'Nama Provinsi'
                }, {
                    field: 'view',
                    title: 'View',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-success btn-view" data-id="${row.id_provinsi}">View</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_provinsi}">Delete</button>`;
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
                        field: 'id_provinsi',
                        title: 'ID Provinsi'
                    }, {
                        field: 'nama_provinsi',
                        title: 'Nama Provinsi'
                    }, {
                        field: 'view',
                        title: 'View',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-success btn-view" data-id="${row.id_provinsi}">View</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_provinsi}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [2, 3, 4]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah wilayah
            $('.tambah-daerah').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Wilayah Baru',
                    html: `
                        <form id="addWilayahBaru">
                           <div class="form-group">
                                <label for="id_provinsi">ID Provinsi *</label>
                                <input type="text" id="id_provinsi" class="form-control" placeholder="ID Provinsi" required disabled>
                            </div>
                            <div class="form-group mb-0">
                                <label for="nama_provinsi">Nama Provinsi *</label>
                                <select id="nama_provinsi" class="form-control" required>
                                    <option value="">Pilih Nama Provinsi</option>
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
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $provinsiSelect = $('#nama_provinsi');
                                Object.entries(response).forEach(function([key,
                                    value
                                ]) {
                                    $provinsiSelect.append(
                                        `<option value="${value}" data-key="${key}">${value}</option>`
                                    );
                                });

                                $provinsiSelect.on('change', function() {
                                    const selectedKey = $(this).find(
                                        'option:selected').data('key');

                                    $('#id_provinsi').val(selectedKey);
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', 'Gagal memuat data wilayah',
                                    'error');
                            }
                        });
                    },
                    preConfirm: () => {
                        const id_provinsi = $('#id_provinsi').val();
                        const nama_provinsi = $('#nama_provinsi').val();

                        // Validasi input
                        if (!id_provinsi || !nama_provinsi) {
                            Swal.showValidationMessage(
                                'Terdapat bagian yang tidak valid atau belum diisi!');
                            return false;
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.provinsi') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id_provinsi
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'Provinsi sudah ada, silahkan gunakan provinsi lain!'
                                        );
                                    } else {
                                        resolve({
                                            id_provinsi: id_provinsi,
                                            nama_provinsi: nama_provinsi,
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    reject(
                                        'Terjadi kesalahan saat memvalidasi Provinsi.'
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
                            id_provinsi,
                            nama_provinsi,
                        } = result.value;

                        $.ajax({
                            url: "{{ route('api.post.provinsi') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_provinsi: id_provinsi,
                                nama_provinsi: nama_provinsi
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data provinsi berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data provinsi gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.btn-view', function() {
                var idProvinsi = $(this).data('id');

                var url = '{{ route('admin.pengaturan.referensi-daerah-kabupaten', ':id') }}';
                url = url.replace(':id', idProvinsi);

                window.location.href = url;
            });


            $(document).on('click', '.btn-delete', function() {
                event.preventDefault();
                var id_provinsi = $(this).data('id');

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
                            url: `{{ route('api.delete.provinsi') }}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_provinsi: id_provinsi
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

        function ApiGetReferensiDaerah(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.provinsi') }}",
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
    </script>
@endpush
