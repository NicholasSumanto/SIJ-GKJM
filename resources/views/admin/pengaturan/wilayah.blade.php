@extends('layouts.admin-main-pengaturan')

@section('title', 'Pengaturan Wilayah')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
@endpush

@section('content')
    <div class="card-body">
        <a href="" class="btn btn-success tambah-wilayah">Tambah Wilayah</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetWilayah">
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
                    field: 'id_wilayah',
                    title: 'ID Wilayah'
                }, {
                    field: 'nama_wilayah',
                    title: 'Nama Wilayah'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-edit" data-id="${row.id_wilayah}" data-name="${row.name}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_wilayah}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColumn: [2, 3]
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
                        field: 'id_wilayah',
                        title: 'ID Wilayah'
                    }, {
                        field: 'nama_wilayah',
                        title: 'Nama Wilayah'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id_wilayah}" style="color: #ffff;">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_wilayah}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [2, 3]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah wilayah
            $('.tambah-wilayah').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Wilayah Baru',
                    html: `
                        <form id="addWilayahForm">
                            <div class="form-group">
                                <label for="id_wilayah">ID Wilayah *</label>
                                <input type="text" id="id_wilayah" class="form-control" placeholder="Masukkan ID Wilayah" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_wilayah">Nama Wilayah *</label>
                                <input type="text" id="nama_wilayah" class="form-control" placeholder="Masukkan Nama Wilayah" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat_wilayah">Alamat Wilayah *</label>
                                <input type="text" id="alamat_wilayah" class="form-control" placeholder="Masukkan Alamat Wilayah" required>
                            </div>
                            <div class="form-group">
                                <label for="kota_wilayah">Kota Wilayah *</label>
                                <input type="text" id="kota_wilayah" class="form-control" placeholder="Masukkan Kota Wilayah" required>
                            </div>
                            <div class="form-group">
                                <label for="email_wilayah">Email Wilayah *</label>
                                <input type="email" id="email_wilayah" class="form-control" placeholder="Masukkan Email Wilayah" required>
                            </div>
                            <div class="form-group">
                                <label for="telepon_wilayah">Nomor Telepon Wilayah *</label>
                                <input type="text" id="telepon_wilayah" class="form-control" placeholder="Masukkan Nomor Telepon Wilayah" required>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const id_wilayah = $('#id_wilayah').val();
                        const nama_wilayah = $('#nama_wilayah').val();
                        const alamat_wilayah = $('#alamat_wilayah').val();
                        const kota_wilayah = $('#kota_wilayah').val();
                        const email_wilayah = $('#email_wilayah').val();
                        const telepon_wilayah = $('#telepon_wilayah').val();

                        // Validasi input
                        if (!id_wilayah || !nama_wilayah || !alamat_wilayah || !kota_wilayah ||
                            !email_wilayah || !telepon_wilayah) {
                            Swal.showValidationMessage(
                                'Terdapat bagian yang tidak valid atau belum diisi!');
                            return false;
                        }

                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(email_wilayah)) {
                            Swal.showValidationMessage(
                                'Email tidak valid, silakan masukkan email yang benar!');
                            return false;
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.wilayah') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id_wilayah
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'ID wilayah sudah ada, silahkan gunakan ID wilayah lain!'
                                        );
                                    } else {
                                        resolve({
                                            id_wilayah: id_wilayah,
                                            nama_wilayah: nama_wilayah,
                                            alamat_wilayah: alamat_wilayah,
                                            kota_wilayah: kota_wilayah,
                                            email_wilayah: email_wilayah,
                                            telepon_wilayah: telepon_wilayah
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    reject(
                                        'Terjadi kesalahan saat memvalidasi ID wilayah.'
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
                            id_wilayah,
                            nama_wilayah,
                            alamat_wilayah,
                            kota_wilayah,
                            email_wilayah,
                            telepon_wilayah
                        } = result.value;

                        $.ajax({
                            url: "{{ route('api.post.wilayah') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_wilayah: id_wilayah,
                                nama_wilayah: nama_wilayah,
                                alamat_wilayah: alamat_wilayah,
                                kota_wilayah: kota_wilayah,
                                email_wilayah: email_wilayah,
                                telepon_wilayah: telepon_wilayah
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data wilayah berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data wilayah gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function(event) {
                event.preventDefault();
                var id = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.get.wilayah') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        var id_wilayah = response.rows[0].id_wilayah;
                        var nama_wilayah = response.rows[0].nama_wilayah;
                        var alamat_wilayah = response.rows[0].alamat_wilayah;
                        var kota_wilayah = response.rows[0].kota_wilayah;
                        var email_wilayah = response.rows[0].email_wilayah;
                        var telepon_wilayah = response.rows[0].telepon_wilayah;

                        Swal.fire({
                            title: 'Edit Wilayah',
                            html: `
                                <form id="editWilayahForm">
                                    <div class="form-group">
                                        <label for="id_wilayah">ID Wilayah *</label>
                                        <input type="text" id="id_wilayah" class="form-control" placeholder="Masukkan ID Wilayah" value="${id_wilayah}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_wilayah">Nama Wilayah *</label>
                                        <input type="text" id="nama_wilayah" class="form-control" placeholder="Masukkan Nama Wilayah" value="${nama_wilayah}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat_wilayah">Alamat Wilayah *</label>
                                        <input type="text" id="alamat_wilayah" class="form-control" placeholder="Masukkan Alamat Wilayah" value="${alamat_wilayah}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kota_wilayah">Kota Wilayah *</label>
                                        <input type="text" id="kota_wilayah" class="form-control" placeholder="Masukkan Kota Wilayah" value="${kota_wilayah}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email_wilayah">Email Wilayah *</label>
                                        <input type="email" id="email_wilayah" class="form-control" placeholder="Masukkan Email Wilayah" value="${email_wilayah}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="telepon_wilayah">Nomor Telepon Wilayah *</label>
                                        <input type="text" id="telepon_wilayah" class="form-control" placeholder="Masukkan Nomor Telepon Wilayah" value="${telepon_wilayah}" required>
                                    </div>
                                </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                            cancelButtonText: 'Cancel',
                            preConfirm: () => {
                                const id_wilayah = $('#id_wilayah').val();
                                const nama_wilayah = $('#nama_wilayah').val();
                                const alamat_wilayah = $('#alamat_wilayah').val();
                                const kota_wilayah = $('#kota_wilayah').val();
                                const email_wilayah = $('#email_wilayah').val();
                                const telepon_wilayah = $('#telepon_wilayah').val();

                                // Validasi input
                                if (!id_wilayah || !nama_wilayah || !
                                    alamat_wilayah || !kota_wilayah ||
                                    !email_wilayah || !telepon_wilayah) {
                                    Swal.showValidationMessage(
                                        'Terdapat bagian yang tidak valid atau belum diisi!'
                                    );
                                    return false;
                                }

                                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                if (!emailRegex.test(email_wilayah)) {
                                    Swal.showValidationMessage(
                                        'Email tidak valid, silakan masukkan email yang benar!'
                                    );
                                    return false;
                                }

                                return new Promise((resolve, reject) => {
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('api.get.wilayah') }}",
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            id: id_wilayah
                                        },
                                        dataType: "json",
                                        success: function(
                                            response) {
                                            if (response.total >
                                                0) {
                                                if (response
                                                    .rows[0]
                                                    .id_wilayah !==
                                                    id) {
                                                    reject(
                                                        'ID wilayah sudah ada, silahkan gunakan ID wilayah lain!'
                                                    );
                                                } else {
                                                    resolve({
                                                        id_wilayah: id_wilayah,
                                                        nama_wilayah: nama_wilayah,
                                                        alamat_wilayah: alamat_wilayah,
                                                        kota_wilayah: kota_wilayah,
                                                        email_wilayah: email_wilayah,
                                                        telepon_wilayah: telepon_wilayah
                                                    });
                                                }
                                            } else {
                                                resolve({
                                                    id_wilayah: id_wilayah,
                                                    nama_wilayah: nama_wilayah,
                                                    alamat_wilayah: alamat_wilayah,
                                                    kota_wilayah: kota_wilayah,
                                                    email_wilayah: email_wilayah,
                                                    telepon_wilayah: telepon_wilayah
                                                });
                                            }
                                        },
                                        error: function(xhr, status,
                                            error) {
                                            reject(
                                                'Terjadi kesalahan saat memvalidasi ID wilayah.'
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
                                    id_wilayah,
                                    nama_wilayah,
                                    alamat_wilayah,
                                    kota_wilayah,
                                    email_wilayah,
                                    telepon_wilayah
                                } = result.value;

                                $.ajax({
                                    url: "{{ route('api.update.wilayah') }}",
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: id,
                                        id_wilayah: id_wilayah,
                                        nama_wilayah: nama_wilayah,
                                        alamat_wilayah: alamat_wilayah,
                                        kota_wilayah: kota_wilayah,
                                        email_wilayah: email_wilayah,
                                        telepon_wilayah: telepon_wilayah
                                    },
                                    success: function(response) {
                                        alert.fire({
                                            icon: 'success',
                                            title: 'Data wilayah berhasil dirubah!'
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function(xhr, status, error) {
                                        alert.fire({
                                            icon: 'error',
                                            title: 'Data wilayah gagal dirubah!'
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
                var id_wilayah = $(this).data('id');

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
                            url: `{{ route('api.delete.wilayah') }}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id_wilayah
                            },
                            dataType: "json",
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data wilayah berhasil dihapus!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data wilayah gagal dihapus!'
                                });
                            }
                        });
                    }
                });
            });
        });

        function ApiGetWilayah(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.wilayah') }}",
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
