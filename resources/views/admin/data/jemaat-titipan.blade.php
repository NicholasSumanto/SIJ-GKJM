@extends('layouts.admin-main-data')

@section('title', 'Jemaat Titipan')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table-filter-control.css') }}">
    <style>
        th {
            vertical-align: top !important;
        }
    </style>
@endpush

@section('content')
    <div class="card-body">
        <a href="" class="btn btn-success tambah-wilayah">Tambah Jemaat</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-filter-control="true" data-ajax="ApiGetJemaatTitipan">
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
    <script src="{{ asset('js/table-export/filter-control/bootstrap-table-filter-control.js') }}"></script>
    <script src="{{ asset('js/table-export/filter-control/utils.js') }}"></script>
    <script>
        var $table = $('#table');
        $(document).ready(function() {
            // Initialize bootstrap table
            $table.bootstrapTable({
                columns: [{
                    field: 'no',
                    title: 'No',
                    align: 'center',
                    formatter: function(value, row, index) {
                        return index + 1;
                    }
                }, {
                    field: 'nama_jemaat',
                    title: 'Nama',
                    align: 'center'
                }, {
                    field: 'kelamin',
                    title: 'Kelamin',
                    align: 'center'
                },{
                    field: 'nama_gereja',
                    title: 'Gereja Asal',
                    align: 'center'
                }, {
                    field: 'alamat_jemaat',
                    title: 'Alamat',
                    align: 'center'
                }, {
                    field: 'titipan',
                    title: 'Titipan',
                    align: 'center'
                }, {
                    field: 'surat',
                    title: 'Surat',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-surat" data-id="${row.id}">Surat</button>`;
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
                    field: 'no',
                    title: 'No',
                    align: 'center',
                    formatter: function(value, row, index) {
                        return index + 1;
                    }
                    }, {
                        field: 'nama_jemaat',
                        title: 'nama',
                        align: 'center'
                    }, {
                        field: 'kelamin',
                        title: 'Kelamin',
                        align: 'center'
                    },{
                        field: 'nama_gereja',
                        title: 'Gereja Asal',
                        align: 'center'
                    }, {
                        field: 'alamat_jemaat',
                        title: 'Alamat',
                        align: 'center'
                    }, {
                        field: 'titipan',
                        title: 'Titipan',
                        align: 'center'
                    }, {
                    field: 'surat',
                    title: 'Surat',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-surat" data-id="${row.id}">Surat</button>`;
                    },
                    align: 'center'
                    },{
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id}" data-name="${row.name}">Edit</button>`;
                    },
                    align: 'center'
                    },{
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
            $('.tambah-wilayah').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Wilayah Baru',
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

            $(document).on('click', '.btn-surat', function() {
            var suratUrl = $(this).data('url');

            if (suratUrl) {
                window.open(suratUrl, '_blank'); 
            } else {
                alert('Surat tidak tersedia.');
            }
        });

            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function() {
                event.preventDefault();
                var id = $(this).data('id');
                var name = $(this).data('name');

                Swal.fire({
                    title: 'Edit Wilayah',
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

        function ApiGetJemaatTitipan(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.jemaattitipan') }}",
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
