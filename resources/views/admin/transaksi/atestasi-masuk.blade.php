@extends('layouts.admin-main-transaksi')

@section('title', 'Transaksi Atestasi Masuk')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        <a href="" class="btn btn-success tambah-atestasi-masuk">Tambah Atestasi</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetAtestasiMasuk">
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
    <script>
        var $table = $('#table');
        $(document).ready(function() {
            // Initialize bootstrap table
            $table.bootstrapTable({
                columns: [{
                    field: 'id_masuk',
                    title: 'ID Masuk'
                }, {
                    field: 'no_surat',
                    title: 'Nomor Surat'
                }, {
                    field: 'nama_wilayah',
                    title: 'Nama Wilayah'
                }, {
                    field: 'nama_gereja',
                    title: 'Nama Gereja'
                }, {
                    field: 'tanggal',
                    title: 'Tanggal'
                }, {
                    field: 'surat',
                    title: 'Surat'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_masuk}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_masuk}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColoumns: [5, 6]
                }
            });

            // Handle perubahan toolbar select
            $('#toolbar').find('select').change(function() {
                var exportDataType = $(this).val();
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: exportDataType,
                    exportTypes: ['excel', 'pdf'],
                    columns: [{
                        field: 'id_masuk',
                        title: 'ID Masuk'
                    }, {
                        field: 'no_surat',
                        title: 'Nomor Surat'
                    }, {
                        field: 'nama_wilayah',
                        title: 'Nama Wilayah'
                    }, {
                        field: 'nama_gereja',
                        title: 'Nama Gereja'
                    }, {
                        field: 'tanggal',
                        title: 'Tanggal'
                    }, {
                        field: 'surat',
                        title: 'Surat'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id_masuk}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_masuk}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColoumns: [5, 6]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah wilayah
            $('.tambah-atestasi-masuk').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Atestasi Masuk Baru',
                    html: `
                        <form id="addAtestasiMasukBaruForm">
                            <div class="form-group">
                                <label for="no_surat">Nomor Surat *</label>
                                <input type="text" id="no_surat" class="form-control" placeholder="Masukkan Nomor Surat *" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_wilayah">Nama Wilayah *</label>
                                <select id="nama_wilayah" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Wilayah</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_gereja">Nama Gereja *</label>
                                <select id="nama_gereja" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Gereja</option>
                                </select>
                                <div id="new-gereja-container" style="margin-top: 10px; display: none;">
                                    <input type="text" id="new_gereja" class="form-control" placeholder="Masukkan Gereja Baru">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal *</label>
                                <input type="date" id="tanggal" class="form-control" required>
                            </div>
                            <div class="form-group mb-0">
                                <label for="surat">Surat *</label>
                                <textarea id="surat" name="surat" cols="50" style="width: 100%;"></textarea>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $('#nama_wilayah, #nama_gereja').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $(
                                '.swal2-container')
                        });

                        // Load Nama Gereja
                        $.ajax({
                            url: "{{ route('api.get.gereja') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $gerejaSelect = $('#nama_gereja');
                                $gerejaSelect.empty().append(
                                    '<option value="">Pilih Nama Gereja</option>'
                                );
                                $.each(response, function(key, value) {
                                    $gerejaSelect.append(new Option(value
                                        .nama_gereja,
                                        value.nama_gereja));
                                });
                                $gerejaSelect.append(new Option(
                                    '+ Tambah Gereja Baru',
                                    'add-new-gereja'));
                            }
                        });

                        // Load Nama Wilayah
                        $.ajax({
                            url: "{{ route('api.get.wilayah') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $wilayahSelect = $('#nama_wilayah');
                                $wilayahSelect.empty().append(
                                    '<option value="">Pilih Nama Wilayah</option>'
                                );
                                $.each(response, function(key, value) {
                                    $wilayahSelect.append(new Option(value
                                        .nama_wilayah,
                                        value.id_wilayah));
                                });
                            }
                        });
                    },
                    preConfirm: () => {
                        const data = {
                            no_surat: $('#no_surat').val(),
                            id_wilayah: $('#nama_wilayah').val(),
                            nama_gereja: $('#nama_gereja').val(),
                            new_gereja: $('#new_gereja').val(),
                            tanggal: $('#tanggal').val(),
                            surat: $('#surat').val()
                        };

                        // Jika memilih "Tambah Gereja Baru", ganti nama_gereja dengan new_gereja jika terisi
                        if (data.nama_gereja === 'add-new-gereja' && data.new_gereja) {
                            data.nama_gereja = data.new_gereja;
                        } else if (data.nama_gereja === 'add-new-gereja' && !data.new_gereja) {
                            Swal.showValidationMessage('Masukkan nama gereja baru');
                            return false;
                        }

                        // Validasi semua input, pastikan tidak ada yang kosong
                        if (!data.no_surat || !data.nama_gereja || !data.id_wilayah || !data
                            .tanggal || !data
                            .surat) {
                            Swal.showValidationMessage('Data tidak boleh kosong!');
                            return false;
                        }

                        return data;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('api.post.atestasimasuk') }}",
                            type: "POST",
                            data: {
                                ...result.value,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data atestasi keluar berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function() {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data atestasi keluar gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function() {
                event.preventDefault();
                var old_id_masuk = $(this).data('id');

                $.ajax({
                    url: "{{ route('api.get.atestasimasuk') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: old_id_masuk,
                    },
                    dataType: "json",
                    success: function(response) {
                        var nama_gereja = response.rows[0].nama_gereja;
                        var id_wilayah = response.rows[0].id_wilayah;

                        Swal.fire({
                            title: 'Edit Atestasi Masuk',
                            html: `
                                <form id="addAtestasiMasukForm">
                                    <div class="form-group">
                                        <label for="no_surat">Nomor Surat *</label>
                                        <input type="text" id="no_surat" class="form-control" placeholder="Masukkan Nomor Surat *" value="${response.rows[0].no_surat}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_wilayah">Nama Wilayah *</label>
                                        <select id="nama_wilayah" class="form-control" required style="width: 100%;">
                                            <option value="">Pilih Nama Wilayah</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_gereja">Nama Gereja *</label>
                                        <select id="nama_gereja" class="form-control" required style="width: 100%;">
                                            <option value="">Pilih Nama Gereja</option>
                                        </select>
                                        <div id="new-gereja-container" style="margin-top: 10px; display: none;">
                                            <input type="text" id="new_gereja" class="form-control" placeholder="Masukkan Gereja Baru">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal *</label>
                                        <input type="date" id="tanggal" class="form-control" value="${response.rows[0].tanggal}" required>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="surat">Surat *</label>
                                        <textarea id="surat" name="surat" cols="50" style="width: 100%;">${response.rows[0].surat}</textarea>
                                    </div>
                                </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            didOpen: () => {
                                $('#nama_wilayah, #nama_gereja').select2({
                                    placeholder: "Pilih atau cari",
                                    allowClear: true,
                                    dropdownParent: $(
                                        '.swal2-container')
                                });

                                // Load Nama Gereja
                                $.ajax({
                                    url: "{{ route('api.get.gereja') }}",
                                    type: "POST",
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        const $gerejaSelect = $(
                                            '#nama_gereja');
                                        $gerejaSelect.empty().append(
                                            '<option value="">Pilih Nama Gereja</option>'
                                        );
                                        $.each(response, function(key,
                                            value) {
                                            $gerejaSelect
                                                .append(
                                                    new Option(
                                                        value
                                                        .nama_gereja,
                                                        value
                                                        .nama_gereja
                                                    ));
                                        });
                                        $gerejaSelect.append(new Option(
                                            '+ Tambah Gereja Baru',
                                            'add-new-gereja'));

                                        $gerejaSelect.val(nama_gereja);
                                    }
                                });

                                // Load Nama Wilayah
                                $.ajax({
                                    url: "{{ route('api.get.wilayah') }}",
                                    type: "POST",
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        const $wilayahSelect = $(
                                            '#nama_wilayah');
                                        $wilayahSelect.empty().append(
                                            '<option value="">Pilih Nama Wilayah</option>'
                                        );
                                        $.each(response, function(key,
                                            value) {
                                            $wilayahSelect
                                                .append(
                                                    new Option(
                                                        value
                                                        .nama_wilayah,
                                                        value
                                                        .id_wilayah
                                                    ));
                                        });
                                        $wilayahSelect.val(id_wilayah);
                                    }
                                });
                            },
                            preConfirm: () => {
                                const data = {
                                    no_surat: $('#no_surat').val(),
                                    id_wilayah: $('#nama_wilayah').val(),
                                    nama_gereja: $('#nama_gereja').val(),
                                    new_gereja: $('#new_gereja').val(),
                                    tanggal: $('#tanggal').val(),
                                    surat: $('#surat').val()
                                };

                                // Jika memilih "Tambah Gereja Baru", ganti nama_gereja dengan new_gereja jika terisi
                                if (data.nama_gereja === 'add-new-gereja' && data
                                    .new_gereja) {
                                    data.nama_gereja = data.new_gereja;
                                } else if (data.nama_gereja === 'add-new-gereja' &&
                                    !data.new_gereja) {
                                    Swal.showValidationMessage(
                                        'Masukkan nama gereja baru');
                                    return false;
                                }

                                // Validasi semua input, pastikan tidak ada yang kosong
                                if (!data.no_surat || !data.nama_gereja || !data
                                    .id_wilayah || !data
                                    .tanggal || !data
                                    .surat) {
                                    Swal.showValidationMessage(
                                        'Data tidak boleh kosong!');
                                    return false;
                                }

                                return data;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ route('api.update.atestasimasuk') }}",
                                    type: "POST",
                                    data: {
                                        ...result.value,
                                        old_id_masuk: old_id_masuk,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function() {
                                        alert.fire({
                                            icon: 'success',
                                            title: 'Data atestasi masuk berhasil diupdate!'
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function() {
                                        alert.fire({
                                            icon: 'error',
                                            title: 'Data atestasi masuk gagal diupdate!'
                                        });
                                    }
                                });
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        reject('Terjadi kesalahan saat memuat data atestasi masuk.');
                    }
                });
            });
        });

        $(document).on('click', '.btn-delete', function() {
            event.preventDefault();
            var id_masuk = $(this).data('id');

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
                        url: `{{ route('api.delete.atestasimasuk') }}`,
                        type: 'POST',
                        data: {
                            id_masuk: id_masuk,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data atestasi keluar berhasil dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data atestasi keluar gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        function ApiGetAtestasiMasuk(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.atestasimasuk') }}",
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
