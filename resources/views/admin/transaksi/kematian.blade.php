@extends('layouts.admin-main-transaksi')

@section('title', 'Transaksi Kematian')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table-filter-control.css') }}">
    <style>
        th {
            vertical-align: top !important;
        }

        .btn-warning {
            color: #fff !important;
        }
    </style>
@endpush

@section('content')
    <div class="card-body">
        <a href="" class="btn btn-success tambah-kematian">Tambah Data Kematian</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-filter-control="true" data-ajax="ApiGetJemaatBaru">
        </table>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    field: 'id_jemaat',
                    title: 'ID Jemaat',
                    align: 'center'
                }, {
                    field: 'nama_jemaat',
                    title: 'Nama',
                    align: 'center'
                }, {
                    field: 'tanggal_meninggal',
                    title: 'Tanggal Meninggal',
                    align: 'center'
                }, {
                    field: 'tanggal_pemakaman',
                    title: 'Tanggal Pemakaman',
                    align: 'center'
                }, {
                    field: 'tempat_pemakaman',
                    title: 'Tempat Pemakaman',
                    align: 'center'
                }, {
                    field: 'keterangan',
                    title: 'Keterangan',
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_kematian}">Hapus</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'cetak',
                    title: 'Cetak',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-view" data-id="${row.id_kematian}">Cetak</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColumn: [6, 7]
                }
            });

            // Handle perubahan toolbar select
            $('#toolbar').find('select').change(function() {
                var exportDataType = $(this).val();
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: exportDataType,
                    exportTypes: ['excel', 'pdf'],
                    columns: [{
                        field: 'id_jemaat',
                        title: 'ID Jemaat',
                        align: 'center'
                    }, {
                        field: 'nama_jemaat',
                        title: 'Nama',
                        align: 'center'
                    }, {
                        field: 'tanggal_meninggal',
                        title: 'Tanggal Meninggal',
                        align: 'center'
                    }, {
                        field: 'tanggal_pemakaman',
                        title: 'Tanggal Pemakaman',
                        align: 'center'
                    }, {
                        field: 'tempat_pemakaman',
                        title: 'Tempat Pemakaman',
                        align: 'center'
                    }, {
                        field: 'keterangan',
                        title: 'Keterangan',
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_kematian}">Hapus</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'cetak',
                        title: 'Cetak',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-primary btn-view" data-id="${row.id_kematian}">Cetak</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [6, 7]
                    }
                });
            }).trigger('change');
        });

        $(document).on('click', '.tambah-kematian', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Tambah Kematian',
                html: `
                    <form id="addKematianForm">
                        <div class="form-group">
                            <label for="nama_jemaat">Nama Jemaat *</label>
                            <select id="nama_jemaat" class="form-control" required style="width: 100%;">
                                <option value="">Pilih Nama Jemaat</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_pendeta">Nama Pendeta *</label>
                            <select id="nama_pendeta" class="form-control" required style="width: 100%;">
                                <option value="">Pilih Nama Pendeta</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_meninggal">Tanggal Meninggal *</label>
                            <input type="date" id="tanggal_meninggal" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pemakaman">Tanggal Pemakaman *</label>
                            <input type="date" id="tanggal_pemakaman" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tempat_pemakaman">Tempat Pemakaman *</label>
                            <input type="text" id="tempat" class="form-control" placeholder="Masukkan Nama Lokasi" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="keterangan">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" cols="50" style="width: 100%;"></textarea>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                didOpen: () => {
                    $('#nama_jemaat,  #nama_pendeta').select2({
                        placeholder: "Pilih atau cari",
                        allowClear: true,
                        dropdownParent: $(
                            '.swal2-container')
                    });

                    // Load Nama Pendeta
                    $.ajax({
                        url: "{{ route('api.get.pendeta') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            onlyName: true
                        },
                        dataType: "json",
                        success: function(response) {
                            const $pendetaSelect = $('#nama_pendeta');
                            $pendetaSelect.empty().append(
                                '<option value="">Pilih Nama Pendeta</option>');
                            $.each(response.rows, function(key, value) {
                                $pendetaSelect.append(new Option(value.nama_pendeta,
                                    value.id_pendeta));
                            });
                        }
                    });

                    // Load Nama Jemaat
                    $.ajax({
                        url: "{{ route('api.get.jemaat') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            onlyName: true
                        },
                        dataType: "json",
                        success: function(response) {
                            const $jemaatSelect = $('#nama_jemaat');
                            $jemaatSelect.empty().append(
                                '<option value="">Pilih Nama Jemaat</option>');
                            $.each(response.rows, function(key, value) {
                                $jemaatSelect.append(new Option(value.nama_jemaat,
                                    value.id_jemaat));
                            });
                        }
                    });
                },
                preConfirm: () => {
                    const data = {
                        id_jemaat: $('#nama_jemaat').val(),
                        id_pendeta: $('#nama_pendeta').val(),
                        tanggal_meninggal: $('#tanggal_meninggal').val(),
                        tanggal_pemakaman: $('#tanggal_pemakaman').val(),
                        tempat_pemakaman: $('#tempat').val(),
                        keterangan: $('#keterangan').val()
                    };


                    // Validasi data lainnya
                    if (!data.id_jemaat || !data.id_pendeta || !data.tanggal_meninggal ||
                        !data.tanggal_pemakaman || !data.tempat_pemakaman) {
                        Swal.showValidationMessage('Semua field bertanda * wajib diisi!');
                        return false;
                    }


                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: "{{ route('api.get.kematian') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_jemaat: data.id_jemaat
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.total > 0) {
                                    reject('Nama jemaat sudah terdaftar');
                                } else {
                                    resolve(data);
                                }
                            },
                            error: function() {
                                reject('Gagal memeriksa nama jemaat');
                            }
                        });
                    }).catch((error) => {
                        Swal.showValidationMessage(error);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('api.post.kematian') }}",
                        type: "POST",
                        data: {
                            ...result.value,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data kematian berhasil ditambahkan!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Data kematian gagal ditambahkan!'
                            });
                        }
                    });
                }
            });
        });



        // Event listener untuk tombol delete
        $(document).on('click', '.btn-delete', function() {
            event.preventDefault();
            var id_kematian = $(this).data('id');

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
                        url: `{{ route('api.delete.kematian') }}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_kematian: id_kematian
                        },
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data kematian berhasil dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data kematian gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        function ApiGetJemaatBaru(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.kematian') }}",
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
