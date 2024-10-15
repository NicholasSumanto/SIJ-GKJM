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
                    field: 'id_pekerjaan',
                    title: 'ID Pekerjaan'
                }, {
                    field: 'pekerjaan',
                    title: 'Nama Pekerjaan'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_pekerjaan}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_pekerjaan}">Delete</button>`;
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
                        field: 'id_pekerjaan',
                        title: 'ID Pekerjaan'
                    }, {
                        field: 'pekerjaan',
                        title: 'Nama Pekerjaan'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id_pekerjaan}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_pekerjaan}">Delete</button>`;
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
                                <label for="id_pekerjaan">ID Pekerjaan</label>
                                <input type="text" id="id_pekerjaan" class="form-control" placeholder="Masukkan ID Pekerjaan">
                            </div>
                            <div class="form-group mb-0">
                                <label for="nama_pekerjaan">Nama Pekerjaan</label>
                                <input type="text" id="nama_pekerjaan" class="form-control" placeholder="Masukkan Nama Pekerjaan">
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const id_pekerjaan = $('#id_pekerjaan').val();
                        const nama_pekerjaan = $('#nama_pekerjaan').val();

                        // Validasi input
                        if (!id_pekerjaan || !nama_pekerjaan) {
                            Swal.showValidationMessage(
                                'Terdapat bagian yang tidak valid atau belum diisi!');
                            return false;
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.pekerjaan') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id_pekerjaan
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'ID pekerjaan sudah ada, silahkan gunakan ID pekerjaan lain!'
                                        );
                                    } else {
                                        resolve({
                                            id_pekerjaan: id_pekerjaan,
                                            nama_pekerjaan: nama_pekerjaan,
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    reject(
                                        'Terjadi kesalahan saat memvalidasi ID pekerjaan.'
                                    );
                                }
                            });
                        }).catch(error => {
                            Swal.showValidationMessage(error);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ambil data dari result.value
                        const {
                            id_pekerjaan,
                            nama_pekerjaan
                        } = result.value;

                        // AJAX request untuk menambah wilayah
                        $.ajax({
                            url: "{{ route('api.post.pekerjaan') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_pekerjaan: id_pekerjaan,
                                nama_pekerjaan: nama_pekerjaan
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
                                 <form id="editReferensiPekerjaan">
                                    <div class="form-group">
                                        <label for="id_pekerjaan">ID Pekerjaan</label>
                                        <input type="text" id="id_pekerjaan" class="form-control" placeholder="Masukkan ID Pekerjaan">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="nama_pekerjaan">Nama Pekerjaan</label>
                                        <input type="text" id="nama_pekerjaan" class="form-control" placeholder="Masukkan Nama Pekerjaan">
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
                type: "POST",
                url: "{{ route('api.get.pekerjaan') }}",
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
