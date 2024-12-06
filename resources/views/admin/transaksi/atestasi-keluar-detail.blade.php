@extends('layouts.admin-main-transaksi')

@section('title', 'Transaksi Atestasi Keluar')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
    <style>
        .btn-keluarga {
            color: white;
        }

        .btn-warning {
            color: #ffff;
        }
    </style>
@endpush

@section('content')
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{ route('admin.transaksi.atestasi-keluar') }}">Atestasi Keluar</a></li>
                <li class="breadcrumb-item active">Detail Atestasi Keluar ({{ $id_keluar ??  ''}})</li>
            </ol>
        </nav>
        <a href="" class="btn btn-success tambah-atestasi-keluar">Tambah Detail Atestasi Keluar</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetAtestasiKeluarDetail">
        </table>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    field: 'id_keluar_dtl',
                    title: 'ID Detail Keluar'
                }, {
                    field: 'id_jemaat',
                    title: 'ID Jemaat'
                }, {
                    field: 'nama_jemaat.nama_jemaat',
                    title: 'Nama Jemaat'
                }, {
                    field: 'keterangan',
                    title: 'Keterangan'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_keluar_dtl}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColoumns: [4, 5]
                }
            });

            // Handle perubahan toolbar select
            $('#toolbar').find('select').change(function() {
                var exportDataType = $(this).val();
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: exportDataType,
                    exportTypes: ['excel', 'pdf'],
                    columns: [{
                        field: 'id_keluar_dtl',
                        title: 'ID Detail Keluar'
                    }, {
                        field: 'id_jemaat',
                        title: 'ID Jemaat'
                    }, {
                        field: 'nama_jemaat.nama_jemaat',
                        title: 'Nama Jemaat'
                    }, {
                        field: 'keterangan',
                        title: 'Keterangan'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_keluar_dtl}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColoumns: [4, 5]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah
            $('.tambah-atestasi-keluar').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Detail Atestasi Keluar Baru',
                    html: `
                        <form id="addWilayahForm">
                            <div class="form-group">
                                <label for="nama_jemaat">Nama Jemaat *</label>
                                <select id="nama_jemaat" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Jemaat</option>
                                </select>
                            </div>
                            <div class="form-group mb-0">
                                <label for="keterangan">Keterangan *</label>
                                <textarea id="keterangan" name="keterangan" cols="50" style="width: 100%;"></textarea>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $('#nama_jemaat').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $(
                                '.swal2-container')
                        });

                        // Load Nama Jemaat
                        $.ajax({
                            url: "{{ route('api.get.jemaat') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                onlyName: true
                            },
                            dataType: "json",
                            success: function(response) {
                                const $jemaatSelect = $('#nama_jemaat');
                                $jemaatSelect.empty().append(
                                    '<option value="">Pilih Nama Jemaat</option>'
                                );
                                $.each(response.rows, function(key, value) {
                                    $jemaatSelect.append(new Option(value
                                        .nama_jemaat,
                                        value.id_jemaat));
                                });
                            }
                        });
                    },
                    preConfirm: () => {
                        const data = {
                            id_jemaat: $('#nama_jemaat').val(),
                            keterangan: $('#keterangan').val()
                        };

                        for (const [key, value] of Object.entries(data)) {
                            if (value === '') {
                                Swal.showValidationMessage(
                                    `Harap isi kolom ${key.replace('_', ' ')}`
                                );
                            }
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                url: "{{ route('api.get.atestasikeluardetail') }}",
                                method: "POST",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id_keluar: '{{ $id_keluar }}',
                                    id_jemaat: data.id_jemaat
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'Nama jemaat sudah terdaftar'
                                        );
                                    } else {
                                        resolve(data);
                                    }
                                },
                                error: function() {
                                    reject('Gagal memeriksa nama jemaat');
                                }
                            });
                        }).catch((error) => {
                            Swal.showValidationMessage(error);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('api.post.atestasikeluardetail') }}",
                            type: "POST",
                            data: {
                                ...result.value,
                                id_keluar: {{ $id_keluar }},
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data detail atestasi keluar berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function() {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data detail atestasi keluar gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol DELETE
            $(document).on('click', '.btn-delete', function() {
                event.preventDefault();
                const id_keluar_dtl = $(this).data('id');

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
                            url: `{{ route('api.delete.atestasikeluardetail') }}`,
                            type: 'POST',
                            data: {
                                id_keluar_dtl: id_keluar_dtl,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data detail atestasi keluar berhasil dihapus!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data detail atestasi keluar gagal dihapus!'
                                });
                            }
                        });
                    }
                });
            });

        });

        function ApiGetAtestasiKeluarDetail(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.atestasikeluardetail') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_keluar: {{ $id_keluar }}
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
