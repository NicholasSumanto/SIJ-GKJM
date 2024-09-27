@extends('layouts.admin-main-pengaturan')

@section('title', 'Pengaturan Jabatan Non Majelis')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
@endpush

@section('content')
    <div class="card-body">
        <a href="" class="btn btn-success tambah-jabatan-non-majelis">Tambah Jabatan Non Majelis</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetJabatanNonMajelis">
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
                    field: 'id_jabatan_non',
                    title: 'ID Jabatan Non Majelis'
                }, {
                    field: 'jabatan_nonmajelis',
                    title: 'Nama Jabatan'
                }, {
                    field: 'periode',
                    title: 'Periode'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_jabatan_non}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_jabatan_non}">Delete</button>`;
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
                        field: 'id_jabatan_non',
                        title: 'ID Jabatan Non Majelis'
                    }, {
                        field: 'jabatan_nonmajelis',
                        title: 'Nama Jabatan'
                    }, {
                        field: 'periode',
                        title: 'Periode'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id_jabatan_non}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_jabatan_non}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [3, 4]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah Jabatan Non Majelis
            $('.tambah-jabatan-non-majelis').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Jabatan Non Majelis Baru',
                    html: `
                        <form id="addJabatanNonMajelisForm">
                           <div class="form-group">
                                <label for="id_jabatan_non">ID Jabatan Non Majelis *</label>
                                <input type="text" id="id_jabatan_non" class="form-control" placeholder="Masukkan ID Jabatan Non Majelis" required>
                            </div>
                            <div class="form-group">
                                <label for="jabatan_nonmajelis">Nama Jabatan Non Majelis *</label>
                                <input type="text" id="jabatan_nonmajelis" class="form-control" placeholder="Masukkan Nama Jabatan Non Majelis" required>
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
                        const id_jabatan_non = $('#id_jabatan_non').val();
                        const jabatan_nonmajelis = $('#jabatan_nonmajelis').val();
                        const periode = $('#periode').val();

                        // Validasi input
                        if (!id_jabatan_non || !jabatan_nonmajelis || !periode) {
                            Swal.showValidationMessage(
                                'Terdapat bagian yang tidak valid atau belum diisi!');
                            return false;
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.jabatan-non-majelis') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id_jabatan_non
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'ID jabatan non majelis sudah ada, silahkan gunakan ID non jabatan majelis lain!'
                                        );
                                    } else {
                                        resolve({
                                            id_jabatan_non: id_jabatan_non,
                                            jabatan_nonmajelis: jabatan_nonmajelis,
                                            periode: periode
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    reject(
                                        'Terjadi kesalahan saat memvalidasi ID jabatan non majelis.'
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
                            id_jabatan_non,
                            jabatan_nonmajelis,
                            periode
                        } = result.value;

                        $.ajax({
                            url: "{{ route('api.post.jabatan-non-majelis') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_jabatan_non: id_jabatan_non,
                                jabatan_nonmajelis: jabatan_nonmajelis,
                                periode: periode
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data jabatan non majelis berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data jabatan non majelis gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.get.jabatan-non-majelis') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        var id_jabatan_non = response.rows[0].id_jabatan_non;
                        var jabatan_nonmajelis = response.rows[0].jabatan_nonmajelis;
                        var periode = response.rows[0].periode;

                        Swal.fire({
                            title: 'Edit Jabatan Non Majelis Baru',
                            html: `
                                <form id="editJabatanNonMajelisForm">
                                <div class="form-group">
                                        <label for="id_jabatan_non">ID Jabatan Non Majelis *</label>
                                        <input type="text" id="id_jabatan_non" class="form-control" placeholder="Masukkan ID Jabatan Non Majelis" value="${id_jabatan_non}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jabatan_nonmajelis">Nama Jabatan Non Majelis *</label>
                                        <input type="text" id="jabatan_nonmajelis" class="form-control" placeholder="Masukkan Nama Jabatan Non Majelis" value="${jabatan_nonmajelis}" required>
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
                                const id_jabatan_non = $('#id_jabatan_non').val();
                                const jabatan_nonmajelis = $('#jabatan_nonmajelis')
                                    .val();
                                const periode = $('#periode').val();

                                // Validasi input
                                if (!id_jabatan_non || !jabatan_nonmajelis || !
                                    periode) {
                                    Swal.showValidationMessage(
                                        'Terdapat bagian yang tidak valid atau belum diisi!'
                                    );
                                    return false;
                                }

                                return new Promise((resolve, reject) => {
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('api.get.jabatan-non-majelis') }}",
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            id: id_jabatan_non
                                        },
                                        dataType: "json",
                                        success: function(
                                            response) {
                                            if (response.total >
                                                0) {
                                                if (response
                                                    .rows[0]
                                                    .id_jabatan_non !==
                                                    id) {
                                                    reject(
                                                        'ID jabatan majelis sudah ada, silahkan gunakan ID jabatan majelis lain!'
                                                    );
                                                } else {
                                                    resolve({
                                                        id_jabatan_non: id_jabatan_non,
                                                        jabatan_nonmajelis: jabatan_nonmajelis,
                                                        periode: periode
                                                    });
                                                }
                                            } else {
                                                resolve({
                                                    id_jabatan_non: id_jabatan_non,
                                                    jabatan_nonmajelis: jabatan_nonmajelis,
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
                                    id_jabatan_non,
                                    jabatan_nonmajelis,
                                    periode
                                } = result.value;

                                $.ajax({
                                    url: "{{ route('api.update.jabatan-non-majelis') }}",
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: id,
                                        id_jabatan_non: id_jabatan_non,
                                        jabatan_nonmajelis: jabatan_nonmajelis,
                                        periode: periode
                                    },
                                    success: function(response) {
                                        alert.fire({
                                            icon: 'success',
                                            title: 'Data jabatan non majelis berhasil dirubah!'
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function(xhr, status, error) {
                                        alert.fire({
                                            icon: 'error',
                                            title: 'Data jabatan non majelis gagal dirubah!'
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

            $(document).on('click', '.btn-delete', function() {
                event.preventDefault();
                var id_jabatan_non = $(this).data('id');

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
                            type: "POST",
                            url: `{{ route('api.delete.jabatan-non-majelis') }}`,
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id_jabatan_non
                            },
                            dataType: "json",
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data Jabatan Non Majelis berhasil Dihapus!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data Jabatan Non Majelis gagal dihapus!'
                                });
                            }
                        });
                    }
                });
            });
        });

        function ApiGetJabatanNonMajelis(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.jabatan-non-majelis') }}",
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
