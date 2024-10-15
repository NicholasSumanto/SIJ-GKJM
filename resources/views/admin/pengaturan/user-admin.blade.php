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
                    field: 'username',
                    title: 'User'
                }, {
                    field: 'nama_user',
                    title: 'Nama User'
                }, {
                    field: 'role',
                    title: 'Role Admin'
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
                }],
                exportOptions: {
                    ignoreCoulomn: [3, 4]
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
                        field: 'username',
                        title: 'User'
                    }, {
                        field: 'nama_user',
                        title: 'Nama User'
                    }, {
                        field: 'role',
                        title: 'Role Admin'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-username="${row.username}" style="color: #ffff;">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-username="${row.username}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreCoulomn: [3, 4]
                    }
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
                                <label for="username">Username *</label>
                                <input type="text" id="username" class="form-control" placeholder="Masukkan Username" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_user">Nama User *</label>
                                <input type="text" id="nama_user" class="form-control" placeholder="Masukkan Nama User" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password User *</label>
                                <input type="password" id="password" class="form-control" placeholder="Masukkan Password User" required>
                            </div>
                            <div class="form-group">
                                <label for="ulangi_password">Ulangi Password User *</label>
                                <input type="password" id="ulangi_password" class="form-control" placeholder="Ulang Password User" required>
                            </div>
                            <div class="form-group mb-0">
                                <label for="role_user">Role User *</label>
                                <select id="role_user" class="form-control" required>
                                    <option value="">Pilih Role User</option>
                                    <!-- AJAX -->
                                </select>
                                <div id="new-role-container" style="margin-top: 10px; display: none;">
                                    <input type="text" id="new_role" class="form-control" placeholder="Masukkan Role Baru">
                                </div>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $.ajax({
                            url: "{{ route('api.get.roles') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $roleSelect = $('#role_user');
                                response.rows.forEach(function(role) {
                                    $roleSelect.append(
                                        `<option value="${role.id_role}">${role.nama_role}</option>`
                                    );
                                });
                                $roleSelect.append(
                                    '<option value="add-new-role">+ Tambah Role Baru</option>'
                                );
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', 'Gagal memuat data role user',
                                    'error');
                            }
                        });

                        // Event ketika opsi tambah role baru dipilih
                        $('#role').on('change', function() {
                            const selectedValue = $(this).val();
                            if (selectedValue === 'add-new-role') {
                                $('#new-role-container').show();
                                $('#new-role').value('');
                            } else {
                                $('#new-role-container').hide();
                                $('#new-role').value('');
                            }
                        });
                    },
                    preConfirm: () => {
                        const username = $('#username').val();
                        const nama_user = $('#nama_user').val();
                        const role_user = $('#role_user').val();
                        const new_role = $('#new_role').val();
                        const password = $('#password').val();
                        const ulangi_password = $('#ulangi_password').val();

                        // Validasi input
                        if (!username || !nama_user || !role_user) {
                            Swal.showValidationMessage(
                                'Terdapat bagian yang tidak valid atau belum diisi!');
                            return false;
                        }

                        if (password !== ulangi_password) {
                            Swal.showValidationMessage('Password tidak sama!');
                            return false;
                        }

                        if (password.lenght < 8) {
                            Swal.showValidationMessage('Password minimal 8 karakter!');
                            return false;
                        }

                        // Jika user memilih tambah role baru tapi tidak mengisi nama role
                        if (role_user === 'add-new-role' && !new_role) {
                            Swal.showValidationMessage('Nama Role baru belum diisi!');
                            return false;
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.user-admin') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    username: username
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'Username sudah ada, silahkan gunakan Username lain!'
                                        );
                                    } else {
                                        resolve({
                                            username: username,
                                            nama_user: nama_user,
                                            role_user: role_user ===
                                                'add-new-role' ?
                                                '' : role_user,
                                            new_role: new_role ===
                                                '' ?
                                                '' : new_role,
                                            password: password
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
                            username,
                            nama_user,
                            role_user,
                            new_role,
                            password
                        } = result.value;

                        $.ajax({
                            url: "{{ route('api.post.user') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                username: username,
                                nama_user: nama_user,
                                role_user: role_user,
                                new_role: new_role,
                                password: password
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data user admin berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data user admin gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });


            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function() {
                var old_username = $(this).data('username'); // Fix typo

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.get.user-admin') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        username: old_username
                    },
                    dataType: "json",
                    success: function(response) {
                        var username = response.rows[0].username;
                        var nama_user = response.rows[0].nama_user;
                        var role = response.rows[0].role;

                        Swal.fire({
                            title: 'Edit User Admin',
                            html: `
                            <form id="addUserAdminForm">
                                <div class="form-group">
                                    <label for="username">Username *</label>
                                    <input type="text" id="username" class="form-control" placeholder="Masukkan Username" value="${username}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_user">Nama User *</label>
                                    <input type="text" id="nama_user" class="form-control" placeholder="Masukkan Nama User" value="${nama_user}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password User * (Jika Berganti) </label>
                                    <input type="password" id="password" class="form-control" placeholder="Masukkan Password User" required>
                                </div>
                                <div class="form-group">
                                    <label for="ulangi_password">Ulangi Password User * (Jika Berganti) </label>
                                    <input type="password" id="ulangi_password" class="form-control" placeholder="Ulang Password User" required>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="role_user">Role User *</label>
                                    <select id="role_user" class="form-control" required>
                                        <option value="">Pilih Role User</option>
                                        <!-- AJAX -->
                                    </select>
                                    <div id="new-role-container" style="margin-top: 10px; display: none;">
                                        <input type="text" id="new_role" class="form-control" placeholder="Masukkan Role Baru">
                                    </div>
                                </div>
                            </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            didOpen: () => {
                                $.ajax({
                                    url: "{{ route('api.get.roles') }}",
                                    type: "POST",
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        const $roleSelect = $(
                                            '#role_user');
                                        response.rows.forEach(function(
                                            role) {
                                            $roleSelect.append(
                                                `<option value="${role.id_role}">${role.nama_role}</option>`
                                            );
                                        });
                                        $roleSelect.append(
                                            '<option value="add-new-role">+ Tambah Role Baru</option>'
                                        );

                                        // Pilih role yang sesuai dengan response
                                        $('#role_user option').filter(
                                            function() {
                                                return $(this)
                                                .text() === role;
                                            }).prop('selected',
                                            true);
                                    },
                                    error: function(xhr, status, error) {
                                        Swal.fire('Error',
                                            'Gagal memuat data role user',
                                            'error');
                                    }
                                });

                                // Event ketika opsi tambah role baru dipilih
                                $('#role_user').on('change', function() {
                                    const selectedValue = $(this).val();
                                    if (selectedValue === 'add-new-role') {
                                        $('#new-role-container').show();
                                        $('#new_role').val(
                                        ''); // Bersihkan input
                                    } else {
                                        $('#new-role-container').hide();
                                        $('#new_role').val('');
                                    }
                                });
                            },
                            preConfirm: () => {
                                const username = $('#username').val();
                                const nama_user = $('#nama_user').val();
                                const role_user = $('#role_user').val();
                                const new_role = $('#new_role').val();
                                const password = $('#password').val();
                                const ulangi_password = $('#ulangi_password').val();

                                // Validasi input
                                if (!username || !nama_user || !role_user) {
                                    Swal.showValidationMessage(
                                        'Terdapat bagian yang tidak valid atau belum diisi!'
                                        );
                                    return false;
                                }

                                if (password != '' && password !== ulangi_password) {
                                    Swal.showValidationMessage(
                                        'Password tidak sama!');
                                    return false;
                                }

                                if (password != '' && password.length < 8) {
                                    Swal.showValidationMessage(
                                        'Password minimal 8 karakter!');
                                    return false;
                                }

                                if (role_user === 'add-new-role' && !new_role) {
                                    Swal.showValidationMessage(
                                        'Nama Role baru belum diisi!');
                                    return false;
                                }

                                return {
                                    username: username,
                                    nama_user: nama_user,
                                    role_user: role_user === 'add-new-role' ? '' :
                                        role_user,
                                    new_role: new_role === '' ? '' : new_role,
                                    password: password
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed && result.value) {
                                const {
                                    username,
                                    nama_user,
                                    role_user,
                                    new_role,
                                    password
                                } = result.value;

                                $.ajax({
                                    url: "{{ route('api.update.user') }}",
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        old_username: old_username,
                                        username: username,
                                        nama_user: nama_user,
                                        role_user: role_user,
                                        new_role: new_role,
                                        password: password
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Data user admin berhasil ditambahkan!'
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function(xhr, status, error) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Data user admin gagal ditambahkan!'
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
                var username = $(this).data('username');

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
                            url: `{{ route('api.delete.user') }}`,
                            data: {
                                _token: '{{ csrf_token() }}',
                                username: username
                            },
                            dataType: "json",
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data User Dihapus!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data User gagal dihapus!'
                                });
                            }
                        });
                    }
                });
            });

        function ApiGetUserAdmin(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.user-admin') }}",
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
