@extends('layouts.admin-main-pengaturan')

@section('title', 'Pengaturan Referensi Pekerjaan')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
@endpush

@section('content')
    <div class="card-body">
        <a href="" class="btn btn-success tambah-pekerjaan">Tambah Pekerjaan</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetReferensiPekerjaan">
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
                    title: 'ID Wilayah'
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
                        title: 'ID'
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

            // Event listener untuk tombol tambah wilayah
            $('.tambah-pekerjaan').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Referensi Pekerjaan Baru',
                    html: `
                        <form id="addReferensiPekerjaan">
                            <div class="form-group">
                                <label for="idPekerjaan">ID Pekerjaan</label>
                                <input type="text" id="idPekerjaan" class="form-control" placeholder="Masukkan ID Pekerjaan">
                            </div>
                            <div class="form-group mb-0">
                                <label for="namaPekerjaan">Nama Pekerjaan</label>
                                <input type="text" id="namaPekerjaan" class="form-control" placeholder="Masukkan Nama Pekerjaan">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const idPekerjaan = $('#idPekerjaan').val();
                        const namaPekerjaan = $('#namaPekerjaan').val();

                        // Validasi input
                        if (!idPekerjaan || !namaPekerjaan) {
                            Swal.showValidationMessage(
                                'ID Pekerjaan atau Nama Pekerjaan harus diisi!');
                            return false;
                        }

                        return {
                            idPekerjaan: idPekerjaan,
                            namaPekerjaan: namaPekerjaan
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ambil data dari result.value
                        const {
                            idPekerjaan,
                            namaPekerjaan
                        } = result.value;

                        // AJAX request untuk menambah wilayah
                        $.ajax({
                            url: '/add-wilayah',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                idPekerjaan: idPekerjaan,
                                namaPekerjaan: namaPekerjaan
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data pekerjaan berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data pekerjaan gagal ditambahkan!'
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
                    title: 'Edit Referensi Pekerjaan',
                    html: `
                        <form id="addReferensiPekerjaan">
                            <div class="form-group">
                                <label for="idPekerjaan">ID Pekerjaan</label>
                                <input type="text" id="idPekerjaan" class="form-control" placeholder="Masukkan ID Pekerjaan" value="${id}" disabled>
                            </div>
                            <div class="form-group mb-0">
                                <label for="namaPekerjaan">Nama Pekerjaan</label>
                                <input type="text" id="namaPekerjaan" class="form-control" placeholder="Masukkan Nama Pekerjaan" value="${name}">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const namaPekerjaan = $('#namaPekerjaan').val();
                        if (!newName) {
                            Swal.showValidationMessage('Nama pekerjaan tidak boleh kosong!');
                            return false;
                        }
                        return {
                            namaPekerjaan: namaPekerjaan
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const namaPekerjaan = result.value.namaPekerjaan;

                        // Contoh: Update menggunakan AJAX
                        $.ajax({
                            url: `/edit/${id}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id,
                                namaPekerjaan: namaPekerjaan
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data pekerjaan berhasil diubah!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'danger',
                                    title: 'Data pekerjaan gagal diupdate!'
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
                                title: 'Data pekerjaan berhasil dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data pekerjaan gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        function ApiGetReferensiPekerjaan(params) {
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
