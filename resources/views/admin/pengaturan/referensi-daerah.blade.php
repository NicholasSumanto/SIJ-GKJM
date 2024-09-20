@extends('layouts.admin-main-pengaturan')

@section('title', 'Pengaturan Referensi Daerah')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
@endpush

@section('content')
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="#">Kabupaten</a></li>
                <li class="breadcrumb-item active"><a href="#">Kecamatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kelurahan</li>
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
                    field: 'id',
                    title: 'Kode'
                }, {
                    field: 'name',
                    title: 'Nama Kabupaten'
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
                        title: 'Kode'
                    }, {
                        field: 'name',
                        title: 'Nama Kabupaten'
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

            // Event listener untuk tombol tambah daerah
            $('.tambah-daerah').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Referensi Daerah Baru',
                    html: `
                        <form id="addReferensiDaerahh">
                            <div class="form-group">
                                <label for="kodeDaerah">Kode Daerah (Kabupaten)</label>
                                <input type="text" id="kodeDaerah" class="form-control" placeholder="Masukkan Kode Daerah Kabupaten">
                            </div>
                            <div class="form-group mb-0">
                                <label for="namaDaerah">Nama Daerah (Kabupaten)</label>
                                <input type="text" id="namaDaerah" class="form-control" placeholder="Masukkan Nama Daerah Kabupaten">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const kodeDaerah = $('#kodeDaerah').val();
                        const namaDaerah = $('#namaDaerah').val();

                        // Validasi input
                        if (!kodeDaerah || !namaDaerah) {
                            Swal.showValidationMessage(
                                'Kode Daerah atau Nama Daerah harus diisi!');
                            return false;
                        }

                        return {
                            kodeDaerah: kodeDaerah,
                            namaDaerah: namaDaerah
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ambil data dari result.value
                        const {
                            kodeDaerah,
                            namaDaerah
                        } = result.value;

                        // AJAX request untuk menambah daerah
                        $.ajax({
                            url: '/add-daerah',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                kodeDaerah: kodeDaerah,
                                namaDaerah: namaDaerah
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data referensi daerah kabupaten berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data referensi daerah kabupaten gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function() {
                event.preventDefault();
                var kodeDaerah = $(this).data('id');
                var namaDaerah = $(this).data('name');

                Swal.fire({
                    title: 'Edit Referensi Daerah',
                    html: `
                        <form id="addReferensiDaerah">
                            <div class="form-group">
                                <label for="kodeDaerah">Kode Daerah (Kabupaten)</label>
                                <input type="text" id="kodeDaerah" class="form-control" placeholder="Masukkan Kode Daerah Kabupaten" value=${kodeDaerah} disabled>
                            </div>
                            <div class="form-group mb-0">
                                <label for="namaDaerah">Nama Daerah (Kabupaten)</label>
                                <input type="text" id="namaDaerah" class="form-control" placeholder="Masukkan Nama Wiayah Kabupaten" value=${namaDaerah}>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const namaDaerah = $('#namaDaerah').val();

                        // Validasi input
                        if (!namaDaerah) {
                            Swal.showValidationMessage(
                                'Nama Daerah harus diisi!');
                            return false;
                        }

                        return {
                            namaDaerah: namaDaerah
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const namaDaerah = result.value.namaDaerah;

                        // Contoh: Update menggunakan AJAX
                        $.ajax({
                            url: `/edit/${id}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                kodeDaerah: kodeDaerah,
                                namaDaerah: namaDaerah
                            },
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data referensi daerah kabupaten berhasil diubah!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'danger',
                                    title: 'Data referensi daerah kabupaten gagal diupdate!'
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
                                title: 'Data referensi daerah kabupaten berhasil dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data referensi daerah kabupaten gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        function ApiGetReferensiDaerah(params) {
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
