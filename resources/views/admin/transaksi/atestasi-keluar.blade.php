@extends('layouts.admin-main-transaksi')

@section('title', 'Transaksi Atestasi Keluar')

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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Atestasi Keluar</a></li>
            </ol>
        </nav>
        <a href="" class="btn btn-success tambah-atestasi-keluar">Tambah Atestasi</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetAtestasiKeluar">
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
                    field: 'id_keluar',
                    title: 'ID Keluar'
                }, {
                    field: 'no_surat',
                    title: 'Nomor Surat'
                }, {
                    field: 'nama_pendeta',
                    title: 'Nama Pendeta'
                }, {
                    field: 'nama_gereja',
                    title: 'Nama Gereja'
                }, {
                    field: 'tanggal',
                    title: 'Tanggal'
                }, {
                    field: 'keterangan',
                    title: 'Keterangan'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_keluar}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_keluar}">Delete</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'lihat',
                    title: 'Lihat Detail',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-view" data-id="${row.id_keluar}">Lihat</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColoumns: [7, 8, 9]
                }
            });

            // Handle perubahan toolbar select
            $('#toolbar').find('select').change(function() {
                var exportDataType = $(this).val();
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: exportDataType,
                    exportTypes: ['excel', 'pdf'],
                    columns: [{
                        field: 'id_keluar',
                        title: 'ID Keluar'
                    }, {
                        field: 'no_surat',
                        title: 'Nomor Surat'
                    }, {
                        field: 'nama_pendeta',
                        title: 'Nama Pendeta'
                    }, {
                        field: 'nama_gereja',
                        title: 'Nama Gereja'
                    }, {
                        field: 'tanggal',
                        title: 'Tanggal'
                    }, {
                        field: 'keterangan',
                        title: 'Keterangan'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id_keluar}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_keluar}">Delete</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'lihat',
                        title: 'Lihat Detail',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-primary btn-view" data-id="${row.id_keluar}">Lihat</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColoumns: [7, 8, 9]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah
            $('.tambah-atestasi-keluar').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Atestasi Keluar Baru',
                    html: `
                        <form id="addWilayahForm">
                            <div class="form-group">
                                <label for="nama_pendeta">Nama Pendeta *</label>
                                <select id="nama_pendeta" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Pendeta</option>
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
                                <label for="no_surat">Nomor Surat *</label>
                                <input type="text" id="no_surat" class="form-control" placeholder="Masukkan Nomor Surat *" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal *</label>
                                <input type="date" id="tanggal" class="form-control" required>
                            </div>
                            <div class="form-group mb-0">
                                <label for="keterangan">Keterangan *</label>
                                <textarea id="keterangan" name="keterangan" cols="50" style="width: 100%;"></textarea>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $('#nama_gereja, #nama_pendeta').select2({
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
                                    $gerejaSelect.append(new Option(value.nama_gereja,value.nama_gereja));
                                });
                                $gerejaSelect.append(new Option(
                                    '+ Tambah Gereja Baru',
                                    'add-new-gereja'));
                            }
                        });

                        // Tampilkan input untuk menambahkan Gereja baru jika opsi dipilih
                        $('#nama_gereja').change(function() {
                            const selectedValue = $(this).val();
                            if (selectedValue === 'add-new-gereja') {
                                $('#new-gereja-container').show();
                                $('#new_gereja').val('');
                            } else {
                                $('#new-gereja-container').hide();
                            }
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
                                    '<option value="">Pilih Nama Pendeta</option>'
                                );
                                $.each(response.rows, function(key, value) {
                                    $pendetaSelect.append(new Option(value.nama_pendeta,value.id_pendeta));
                                });
                            }
                        });
                    },
                    preConfirm: () => {
                        const data = {
                            id_pendeta: $('#nama_pendeta').val(),
                            nama_gereja: $('#nama_gereja').val(),
                            new_gereja: $('#new_gereja').val(),
                            no_surat: $('#no_surat').val(),
                            tanggal: $('#tanggal').val(),
                            keterangan: $('#keterangan').val()
                        };

                        // Jika memilih "Tambah Gereja Baru", ganti nama_gereja dengan new_gereja jika terisi
                        if (data.nama_gereja === 'add-new-gereja' && data.new_gereja) {
                            data.nama_gereja = data.new_gereja;
                        } else if (data.nama_gereja === 'add-new-gereja' && !data.new_gereja) {
                            Swal.showValidationMessage('Masukkan nama gereja baru');
                            return false;
                        }

                        // Validasi semua input, pastikan tidak ada yang kosong
                        if (!data.id_pendeta || !data.nama_gereja || !data.no_surat || !data
                            .tanggal || !data.keterangan) {
                            Swal.showValidationMessage('Data tidak boleh kosong!');
                            return false;
                        }

                        return data;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('api.post.atestasikeluar') }}",
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
                var old_id_keluar = $(this).data('id');

                $.ajax({
                    url: "{{ route('api.get.atestasikeluar') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: old_id_keluar,
                    },
                    dataType: "json",
                    success: function(response) {
                        var nama_gereja = response.rows[0].nama_gereja;
                        var id_pendeta = response.rows[0].id_pendeta;

                        Swal.fire({
                            title: 'Edit Atestasi Keluar',
                            html: `
                                <form id="editAtestesiKeluarForm">
                                    <div class="form-group">
                                        <label for="nama_pendeta">Nama Pendeta *</label>
                                        <select id="nama_pendeta" class="form-control" required style="width: 100%;">
                                            <option value="">Pilih Nama Pendeta</option>
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
                                        <label for="no_surat">Nomor Surat *</label>
                                        <input type="text" id="no_surat" class="form-control" placeholder="Masukkan Nomor Surat *" value="${response.rows[0].no_surat}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal *</label>
                                        <input type="date" id="tanggal" class="form-control" value="${response.rows[0].tanggal}" required>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="keterangan">Keterangan *</label>
                                        <textarea id="keterangan" name="keterangan" cols="50" style="width: 100%;">${response.rows[0].keterangan}</textarea>
                                    </div>
                                </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            didOpen: () => {
                                $('#nama_gereja, #nama_pendeta').select2({
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

                                // Tampilkan input untuk menambahkan Gereja baru jika opsi dipilih
                                $('#nama_gereja').change(function() {
                                    const selectedValue = $(this).val();
                                    if (selectedValue ===
                                        'add-new-gereja') {
                                        $('#new-gereja-container').show();
                                        $('#new_gereja').val('');
                                    } else {
                                        $('#new-gereja-container').hide();
                                    }
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
                                        const $pendetaSelect = $(
                                            '#nama_pendeta');
                                        $pendetaSelect.empty().append(
                                            '<option value="">Pilih Nama Pendeta</option>'
                                        );
                                        $.each(response.rows, function(
                                            key, value) {
                                            $pendetaSelect
                                                .append(
                                                    new Option(
                                                        value
                                                        .nama_pendeta,
                                                        value
                                                        .id_pendeta
                                                    ));
                                        });

                                        $pendetaSelect.val(id_pendeta);
                                    }
                                });
                            },
                            preConfirm: () => {
                                const data = {
                                    id_pendeta: $('#nama_pendeta').val(),
                                    nama_gereja: $('#nama_gereja').val(),
                                    new_gereja: $('#new_gereja').val(),
                                    no_surat: $('#no_surat').val(),
                                    tanggal: $('#tanggal').val(),
                                    keterangan: $('#keterangan').val()
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
                                if (!data.id_pendeta || !data.nama_gereja || !data
                                    .no_surat || !data
                                    .tanggal || !data.keterangan) {
                                    Swal.showValidationMessage(
                                        'Data tidak boleh kosong!');
                                    return false;
                                }

                                return data;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ route('api.update.atestasikeluar') }}",
                                    type: "POST",
                                    data: {
                                        ...result.value,
                                        old_id_keluar: old_id_keluar,
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
                    },
                    error: function(xhr, status, error) {
                        reject('Terjadi kesalahan saat memuat data atestasi keluar.');
                    }
                });
            });
        });

        $(document).on('click', '.btn-view', function() {
            event.preventDefault();
            var id_keluar = $(this).data('id');

            var url = `{{ route('admin.transaksi.atestasi-keluar-detail', ':id') }}`;
            url = url.replace(':id', id_keluar);

            window.location.href = url;
        });

        $(document).on('click', '.btn-delete', function() {
            event.preventDefault();
            var id_keluar = $(this).data('id');

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
                        url: `{{ route('api.delete.atestasikeluar') }}`,
                        type: 'POST',
                        data: {
                            id_keluar: id_keluar,
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

        function ApiGetAtestasiKeluar(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.atestasikeluar') }}",
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
