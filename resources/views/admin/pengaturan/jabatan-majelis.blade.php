@extends('layouts.admin-main-pengaturan')

@section('title', 'Pengaturan Jabatan Majelis')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
@endpush

@section('content')
    <div class="card-body">
        <a href="" class="btn btn-success tambah-jabatan-majelis">Tambah Jabatan Majelis</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetJabatanMajelis">
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
                    field: 'id_jabatan',
                    title: 'ID Jabatan Majelis'
                }, {
                    field: 'jabatan_majelis',
                    title: 'Nama Jabatan'
                }, {
                    field: 'periode',
                    title: 'Periode'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_jabatan}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_jabatan}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColumn: [3, 4]
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
                        field: 'id_jabatan',
                        title: 'ID Jabatan Majelis'
                    }, {
                        field: 'jabatan_majelis',
                        title: 'Nama Jabatan'
                    }, {
                        field: 'periode',
                        title: 'Periode'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id_jabatan}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_jabatan}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [3, 4]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah Jabatan Majelis
            $('.tambah-jabatan-majelis').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Jabatan Majelis Baru',
                    html: `
                        <form id="addJabatanMajelisForm">
                           <div class="form-group">
                                <label for="id_jabatan">ID Jabatan *</label>
                                <input type="text" id="id_jabatan" class="form-control" placeholder="Masukkan ID Jabatan" required>
                            </div>
                            <div class="form-group">
                                <label for="jabatan_majelis">Nama Jabatan *</label>
                                <input type="text" id="jabatan_majelis" class="form-control" placeholder="Masukkan Nama Jabatan Majelis" required>
                            </div>
                            <div class="form-group mb-0">
                                <label for="periode">Periode *</label>
                                <input type="number" id="periode" class="form-control" placeholder="Masukkan Tahun Periode" min="1900" max="2100" required>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const id_jabatan = $('#id_jabatan').val();
                        const jabatan_majelis = $('#jabatan_majelis').val();
                        const periode = $('#periode').val();

                        // Validasi input
                        if (!id_jabatan || !jabatan_majelis || !periode) {
                            Swal.showValidationMessage(
                                'Terdapat bagian yang tidak valid atau belum diisi!');
                            return false;
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.jabatan-majelis') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id_jabatan
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'ID jabatan majelis sudah ada, silahkan gunakan ID jabatan majelis lain!'
                                        );
                                    } else {
                                        resolve({
                                            id_jabatan: id_jabatan,
                                            jabatan_majelis: jabatan_majelis,
                                            periode: periode
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    reject(
                                        'Terjadi kesalahan saat memvalidasi ID jabatan majelis.'
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
                            id_jabatan,
                            jabatan_majelis,
                            periode
                        } = result.value;

                        $.ajax({
                            url: "{{ route('api.post.jabatan-majelis') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id_jabatan,
                                jabatan_majelis: jabatan_majelis,
                                periode: periode
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data jabatan majelis berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data jabatan majelis gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function() {
                event.preventDefault();
                var id = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.get.jabatan-majelis') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        var id_jabatan = response.rows[0].id_jabatan;
                        var jabatan_majelis = response.rows[0].jabatan_majelis;
                        var periode = response.rows[0].periode;

                        Swal.fire({
                            title: 'Edit Wilayah',
                            html: `
                                <form id="addJabatanMajelisForm">
                                    <div class="form-group">
                                        <label for="id_jabatan">ID Jabatan *</label>
                                        <input type="text" id="id_jabatan" class="form-control" placeholder="Masukkan ID Jabatan" value="${id_jabatan}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jabatan_majelis">Nama Jabatan *</label>
                                        <input type="text" id="jabatan_majelis" class="form-control" placeholder="Masukkan Nama Jabatan Majelis" value="${jabatan_majelis}" required>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="periode">Periode *</label>
                                        <input type="number" id="periode" class="form-control" placeholder="Masukkan Tahun Periode" min="1900" max="2100" value="${periode}" required>
                                    </div>
                                </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                            cancelButtonText: 'Cancel',
                            preConfirm: () => {
                                const id_jabatan = $('#id_jabatan').val();
                                const jabatan_majelis = $('#jabatan_majelis').val();
                                const periode = $('#periode').val();

                                // Validasi input
                                if (!id_jabatan || !jabatan_majelis || !periode) {
                                    Swal.showValidationMessage(
                                        'Terdapat bagian yang tidak valid atau belum diisi!'
                                    );
                                    return false;
                                }

                                return new Promise((resolve, reject) => {
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('api.get.jabatan-majelis') }}",
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            id: id_jabatan
                                        },
                                        dataType: "json",
                                        success: function(
                                            response) {
                                            if (response.total >
                                                0) {
                                                if (response
                                                    .rows[0]
                                                    .id_jabatan !==
                                                    id) {
                                                    reject(
                                                        'ID jabatan majelis sudah ada, silahkan gunakan ID jabatan majelis lain!'
                                                    );
                                                } else {
                                                    resolve({
                                                        id_jabatan: id_jabatan,
                                                        jabatan_majelis: jabatan_majelis,
                                                        periode: periode
                                                    });
                                                }
                                            } else {
                                                resolve({
                                                    id_jabatan: id_jabatan,
                                                    jabatan_majelis: jabatan_majelis,
                                                    periode: periode
                                                });
                                            }
                                        },
                                        error: function(xhr, status,
                                            error) {
                                            reject(
                                                'Terjadi kesalahan saat memvalidasi ID jabatan majelis.'
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
                                    id_jabatan,
                                    jabatan_majelis,
                                    periode
                                } = result.value;

                                $.ajax({
                                    url: "{{ route('api.update.jabatan-majelis') }}",
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: id,
                                        id_jabatan: id_jabatan,
                                        jabatan_majelis: jabatan_majelis,
                                        periode: periode
                                    },
                                    success: function(response) {
                                        alert.fire({
                                            icon: 'success',
                                            title: 'Data jabatan majelis berhasil dirubah!'
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function(xhr, status, error) {
                                        alert.fire({
                                            icon: 'error',
                                            title: 'Data jabatan majelis gagal dirubah!'
                                        });
                                    }
                                });
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                        console.error("Status: " + status);
                        console.dir(xhr);
                    }
                });
            });
        });

        $(document).on('click', '.btn-delete', function() {
            event.preventDefault();
            var id_jabatan = $(this).data('id');

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
                        url: `{{ route('api.delete.jabatan-majelis') }}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id_jabatan
                        },
                        dataType: "json",
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data Jabatan Majelis berhasil Dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data Jabatan Majelis gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        function ApiGetJabatanMajelis(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.jabatan-majelis') }}",
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
