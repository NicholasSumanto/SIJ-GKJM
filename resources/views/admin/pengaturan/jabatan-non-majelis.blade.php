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
                    field: 'id',
                    title: 'No'
                }, {
                    field: 'name',
                    title: 'Nama Jabatan'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-edit" data-id="${row.id}" data-name="${row.name}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    columns: [0, 1]
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
                        field: 'id',
                        title: 'No'
                    }, {
                        field: 'name',
                        title: 'Nama Jabatan'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id}" data-name="${row.name}" style="color: #ffff;">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id}">Delete</button>`;
                        },
                        align: 'center'
                    }]
                });
            }).trigger('change');

            // Event listener untuk tombol tambah Jabatan Non Majelis
            $('.tambah-jabatan-non-majelis').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Jabatan Non Majelis Baru',
                    html: `
                        <form id="addJabatan Non MajelisForm">
                            <div class="form-group">
                                <label for="noJabatan">ID Jabatan Non Majelis</label>
                                <input type="text" id="noJabatan" class="form-control" placeholder="Masukkan Nomor Jabatan">
                            </div>
                            <div class="form-group mb-0">
                                <label for="namaJabatan">Nama Jabatan Non Majelis</label>
                                <input type="text" id="namaJabatan" class="form-control" placeholder="Masukkan Nama Jabatan Non Majelis">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const noJabatan = $('#noJabatan').val();
                        const namaJabatan = $('#namaJabatan').val();

                        // Validasi input
                        if (!noJabatan || !namaJabatan) {
                            Swal.showValidationMessage(
                                'ID Jabatan Non Majelis dan Nama Jabatan Non Majelis harus diisi!');
                            return false;
                        }

                        return {
                            noJabatan: noJabatan,
                            namaJabatan: namaJabatan
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ambil data dari result.value
                        const {
                            noJabatan,
                            namaJabatan
                        } = result.value;

                        // AJAX request untuk menambah Jabatan Non Majelis
                        $.ajax({
                            url: '/add-jabatan-non-majelis',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                noJabatan: noJabatan,
                                namaJabatan: namaJabatan
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data Jabatan Non Majelis berhasil ditambahkan!'
                                });
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Terjadi keslahan saat menambahkan data Jabatan Non Majelis!'
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
                var name = $(this).data('name');

                Swal.fire({
                    title: 'Edit Jabatan Majelis',
                    html: `
                        <form id="editForm">
                            <div class="form-group">
                                <label for="noJabatan">ID Jabatan Non Majelis</label>
                                <input type="text" id="noJabatan" class="form-control" value="${id}" disabled>
                            </div>
                            <div class="form-group mb-0">
                                <label for="namaJabatan">Nama Jabatan Non Majelis</label>
                                <input type="text" id="namaJabatan" class="form-control" value="${name}">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const newName = $('#namaJabatan').val();
                        if (!newName) {
                            Swal.showValidationMessage('Nama item tidak boleh kosong!');
                            return false;
                        }
                        return {
                            newName: newName
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const newName = result.value.newName;

                        // Contoh: Update menggunakan AJAX
                        $.ajax({
                            url: `/edit/${id}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id,
                                name: newName
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data Jabatan Non Majelis berhasil diupdate!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data Jabatan Non Majelis gagal diupdate!'
                                });
                            }
                        });
                    }
                });
            });
        });

        $(document).on('click', '.btn-delete', function() {
            event.preventDefault();
            var id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/delete/${id}`,
                        type: 'DELETE',
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

        function ApiGetJabatanNonMajelis(params) {
            $.ajax({
                type: "GET",
                url: "https://examples.wenzhixin.net.cn/examples/bootstrap_table/data",
                data: {
                    // _token: '{{ csrf_token() }}'
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
