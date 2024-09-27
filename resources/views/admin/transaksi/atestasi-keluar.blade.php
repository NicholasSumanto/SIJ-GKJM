@extends('layouts.admin-main-transaksi')

@section('title', 'Transaksi Atestasi Keluar')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
        <a href="" class="btn btn-success tambah-keluarga">Tambah Atestasi</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetKeluarga">
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
                    title: 'No Surat'
                }, {
                    field: 'name',
                    title: 'Gereja Tujuan'
                }, {
                    field: 'tanggal',
                    title: 'Tanggal'
                }, {
                    field: 'keterangan',
                    title: 'Keterangan'
                }, {
                    field: 'jemaat',
                    title: 'jemaat',
                    formatter: function(value, row, index) {
                        return `
                        <button class="btn btn-warning btn-keluarga" type="button" data-bs-toggle="collapse" data-bs-target="#${row.id}" aria-expanded="false" aria-controls="${row.id}" data-id="${row.id}" data-name="${row.name}">
                            Lihat Keluarga
                        </button>

                        <div class="collapse" id="${row.id}">
                            <div class="card card-body mt-2">
                                Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                            </div>
                        </div>`;
                    },
                    align: 'center'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id}" data-name="${row.name}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id}">Delete</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'cetak',
                    title: 'Cetak',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-view" data-id="${row.id}">Cetak</button>`;
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
                        field: 'id',
                        title: 'No Surat'
                    }, {
                        field: 'name',
                        title: 'Gereja Tujuan'
                    }, {
                        field: 'tanggal',
                        title: 'Tanggal'
                    }, {
                        field: 'keterangan',
                        title: 'Keterangan'
                    }, {
                        field: 'jemaat',
                        title: 'jemaat',
                        formatter: function(value, row, index) {
                            return `
                        <button class="btn btn-warning btn-keluarga" type="button" data-bs-toggle="collapse" data-bs-target="#${row.id}" aria-expanded="false" aria-controls="${row.id}" data-id="${row.id}" data-name="${row.name}">
                            Lihat Keluarga
                        </button>

                        <div class="collapse" id="${row.id}">
                            <div class="card card-body mt-2">
                                Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                            </div>
                        </div>`;
                        },
                        align: 'center'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id}" data-name="${row.name}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id}">Delete</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'cetak',
                        title: 'Cetak',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-primary btn-view" data-id="${row.id}">Cetak</button>`;
                        },
                        align: 'center'
                    }]
                });
            }).trigger('change');

            // Event listener untuk tombol tambah wilayah
            $('.tambah-anggota-keluarga').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Keluarga Baru',
                    html: `
                        <form id="addWilayahForm">
                            <div class="form-group">
                                <label for="idWilayah">ID Wilayah</label>
                                <input type="text" id="idWilayah" class="form-control" placeholder="Masukkan ID Wilayah">
                            </div>
                            <div class="form-group mb-0">
                                <label for="namaWilayah">Nama Wilayah</label>
                                <input type="text" id="namaWilayah" class="form-control" placeholder="Masukkan Nama Wilayah">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const idWilayah = $('#idWilayah').val();
                        const namaWilayah = $('#namaWilayah').val();

                        // Validasi input
                        if (!idWilayah || !namaWilayah) {
                            Swal.showValidationMessage(
                                'ID Wilayah dan Nama Wilayah harus diisi!');
                            return false;
                        }

                        return {
                            idWilayah: idWilayah,
                            namaWilayah: namaWilayah
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ambil data dari result.value
                        const {
                            idWilayah,
                            namaWilayah
                        } = result.value;

                        // AJAX request untuk menambah wilayah
                        $.ajax({
                            url: '/add-wilayah',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                idWilayah: idWilayah,
                                namaWilayah: namaWilayah
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
                                    icon: 'success',
                                    title: 'Data wilayah gagal ditambahkan!'
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
                    title: 'Edit Keluarga',
                    html: `
                        <form id="editForm">
                            <div class="form-group">
                                <label for="idWilayah">ID Wilayah</label>
                                <input type="text" id="idWilayah" class="form-control" value="${id}" disabled>
                            </div>
                            <div class="form-group mb-0">
                                <label for="nameItem">Nama Wilayah</label>
                                <input type="text" id="nameItem" class="form-control" value="${name}">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const newName = $('#nameItem').val();
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
                                    title: 'Data wilayah berhasil diubah!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'danger',
                                    title: 'Data wilayah gagal diupdate!'
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

        function ApiGetKeluarga(params) {
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
