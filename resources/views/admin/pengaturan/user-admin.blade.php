@extends('layouts.admin-main-pengaturan')

@section('title', 'Pengaturan User Admin')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
@endpush

@section('content')
    <div class="card-body">
        <a href="" class="btn btn-success tambah-user-admin">Tambah User Admin</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetUserAdmin">
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
                    title: 'User'
                }, {
                    field: 'name',
                    title: 'Nama User'
                }, {
                    field: 'name',
                    title: 'Level Admin'
                }, {
                    field: 'name',
                    title: 'Wilayah'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-no="${row.id}" data-user="${row.name}" data-nama-user="${name}" data-level-admin="${name}" data-wilayah="${name}" style="color: #ffff;">Edit</button>`;
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
                        title: 'User'
                    }, {
                        field: 'name',
                        title: 'Nama User'
                    }, {
                        field: 'name',
                        title: 'Level Admin'
                    }, {
                        field: 'name',
                        title: 'Wilayah'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-no="${row.id}" data-user="${row.name}" data-nama-user="${row.name}" data-level-admin="${row.name}" data-wilayah="${row.name}" style="color: #ffff;">Edit</button>`;
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

            // Event listener untuk tombol tambah User Admin
            $('.tambah-user-admin').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah User Admin Baru',
                    html: `
                        <form id="addUserAdminForm">
                            <div class="form-group">
                                <label for="noUserAdmin">ID User Admin</label>
                                <input type="text" id="noUserAdmin" class="form-control" placeholder="Masukkan Nomor User Admin">
                            </div>
                            <div class="form-group">
                                <label for="userAdmin">User Admin</label>
                                <input type="text" id="userAdmin" class="form-control" placeholder="Masukkan User Admin">
                            </div>
                            <div class="form-group">
                                <label for="namaUserAdmin">Nama User Admin</label>
                                <input type="text" id="namaUserAdmin" class="form-control" placeholder="Masukkan Nama User Admin">
                            </div>
                            <div class="form-group">
                                <label for="levelUserAdmin">Level User Admin</label>
                                <input type="text" id="levelUserAdmin" class="form-control" placeholder="Masukkan Level User Admin">
                            </div>
                            <div class="form-group mb-0">
                                <label for="wilayahUserAdmin">Wilayah</label>
                                <input type="text" id="wilayahUserAdmin" class="form-control" placeholder="Masukkan Wilayah User Admin">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const noUserAdmin = $('#noUserAdmin').val();
                        const userAdmin = $('#userAdmin').val();
                        const namaUserAdmin = $('#namaUserAdmin').val();
                        const levelUserAdmin = $('#levelUserAdmin').val();
                        const wilayahUserAdmin = $('#wilayahUserAdmin').val();

                        // Validasi input
                        if (!noUserAdmin || !userAdmin || !namaUserAdmin || !levelUserAdmin || !
                            wilayahUserAdmin) {
                            Swal.showValidationMessage(
                                'Seluruh data User Admin harus diisi!'
                            );
                            return false;
                        }

                        return {
                            noUserAdmin: noUserAdmin,
                            userAdmin: userAdmin,
                            namaUserAdmin: namaUserAdmin,
                            levelUserAdmin: levelUserAdmin,
                            wilayahUserAdmin: wilayahUserAdmin
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ambil data dari result.value
                        const {
                            noUserAdmin,
                            userAdmin,
                            namaUserAdmin,
                            levelUserAdmin,
                            wilayahUserAdmin
                        } = result.value;

                        // AJAX request untuk menambah User Admin
                        $.ajax({
                            url: '/add-user0-admin',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                noUserAdmin: noUserAdmin,
                                userAdmin: userAdmin,
                                namaUserAdmin: namaUserAdmin,
                                levelUserAdmin: levelUserAdmin,
                                wilayahUserAdmin: wilayahUserAdmin
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data User Admin berhasil ditambahkan!'
                                });
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Terjadi keslahan saat menambahkan data User Admin!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function() {
                event.preventDefault();
                var id = $(this).data('no');
                var user = $(this).data('user');
                var namaUser = $(this).data('nama-user');
                var levelAdmin = $(this).data('level-admin');
                var wilayah = $(this).data('wilayah');

                Swal.fire({
                    title: 'Edit Jabatan Majelis',
                    html: `
                        <form id="addUserAdminForm">
                            <div class="form-group">
                                <label for="noUserAdmin">ID User Admin</label>
                                <input type="text" id="noUserAdmin" class="form-control" placeholder="Masukkan Nomor User Admin" value="${id}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="userAdmin">User Admin</label>
                                <input type="text" id="userAdmin" class="form-control" placeholder="Masukkan User Admin" value="${user}">
                            </div>
                            <div class="form-group">
                                <label for="namaUserAdmin">Nama User Admin</label>
                                <input type="text" id="namaUserAdmin" class="form-control" placeholder="Masukkan Nama User Admin" value="${namaUser}">
                            </div>
                            <div class="form-group">
                                <label for="levelUserAdmin">Level User Admin</label>
                                <input type="text" id="levelUserAdmin" class="form-control" placeholder="Masukkan Level User Admin" value="${levelAdmin}">
                            </div>
                            <div class="form-group mb-0">
                                <label for="wilayahUserAdmin">Wilayah</label>
                                <input type="text" id="wilayahUserAdmin" class="form-control" placeholder="Masukkan Wilayah User Admin" value="${wilayah}">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const noUserAdmin = $('#noUserAdmin').val();
                        const userAdmin = $('#userAdmin').val();
                        const namaUserAdmin = $('#namaUserAdmin').val();
                        const levelUserAdmin = $('#levelUserAdmin').val();
                        const wilayahUserAdmin = $('#wilayahUserAdmin').val();

                        // Validasi input
                        if (!noUserAdmin || !userAdmin || !namaUserAdmin || !levelUserAdmin || !
                            wilayahUserAdmin) {
                            Swal.showValidationMessage(
                                'Seluruh data User Admin harus diisi!'
                            );
                            return false;
                        }

                        return {
                            noUserAdmin: noUserAdmin,
                            userAdmin: userAdmin,
                            namaUserAdmin: namaUserAdmin,
                            levelUserAdmin: levelUserAdmin,
                            wilayahUserAdmin: wilayahUserAdmin
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const {
                            noUserAdmin,
                            userAdmin,
                            namaUserAdmin,
                            levelUserAdmin,
                            wilayahUserAdmin
                        } = result.value;

                        // Contoh: Update menggunakan AJAX
                        $.ajax({
                            url: `/edit/${id}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                noUserAdmin: noUserAdmin,
                                userAdmin: userAdmin,
                                namaUserAdmin: namaUserAdmin,
                                levelUserAdmin: levelUserAdmin,
                                wilayahUserAdmin: wilayahUserAdmin
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data User Admin berhasil diupdate!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data User Admin gagal diupdate!'
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

        function ApiGetUserAdmin(params) {
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
