@extends('layouts.admin-main-transaksi')

@section('title', 'Transaksi Baptis Dewasa')

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
        <a href="" class="btn btn-success tambah-baptis">Tambah Baptis</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-filter-control="true" data-ajax="ApiGetBaptisDewasa">
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
                    field: 'id_bd',
                    title: 'ID Baptis',
                    align: 'center'
                }, {
                    field: 'nama',
                    title: 'Nama',
                    align: 'center'
                }, {
                    field: 'nama_wilayah',
                    title: 'Nama Wilayah',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'kelamin',
                    title: 'Kelamin',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'nama_pendeta',
                    title: 'Nama Pendeta',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'nomor',
                    title: 'Nomor',
                    align: 'center'
                }, {
                    field: 'tempat_lahir',
                    title: 'Tempat Lahir',
                    align: 'center'
                }, {
                    field: 'tanggal_lahir',
                    title: 'Tanggal Lahir',
                    align: 'center'
                }, {
                    field: 'ayah',
                    title: 'Ayah',
                    align: 'center'
                }, {
                    field: 'ibu',
                    title: 'Ibu',
                    align: 'center'
                }, {
                    field: 'tanggal_baptis',
                    title: 'Tanggal Baptis',
                    align: 'center'
                }, {
                    field: 'ketua_majelis',
                    title: 'Ketua Majelis',
                    align: 'center'
                }, {
                    field: 'sekretaris_majelis',
                    title: 'Sekretaris Majelis',
                    align: 'center'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_ba}" data-nama="${row.nama}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_ba}">Hapus</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'cetak',
                    title: 'Cetak',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-view" data-id="${row.id_ba}">Cetak</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColumn: [12, 13, 14]
                }
            });

            // Handle perubahan toolbar select
            $('#toolbar').find('select').change(function() {
                var exportDataType = $(this).val();
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: exportDataType,
                    exportTypes: ['excel', 'pdf'],
                    columns: [{
                        field: 'id_bd',
                        title: 'ID Baptis',
                        align: 'center'
                    }, {
                        field: 'nama',
                        title: 'Nama ',
                        align: 'center'
                    }, {
                        field: 'nama_wilayah',
                        title: 'Nama Wilayah',
                        filterControl: 'select',
                        align: 'center'
                    }, {
                        field: 'kelamin',
                        title: 'Kelamin',
                        filterControl: 'select',
                        align: 'center'
                    }, {
                        field: 'nama_pendeta',
                        title: 'Nama Pendeta',
                        filterControl: 'select',
                        align: 'center'
                    }, {
                        field: 'nomor',
                        title: 'Nomor',
                        align: 'center'
                    }, {
                        field: 'tempat_lahir',
                        title: 'Tempat Lahir',
                        align: 'center'
                    }, {
                        field: 'tanggal_lahir',
                        title: 'Tanggal Lahir',
                        align: 'center'
                    }, {
                        field: 'ayah',
                        title: 'Ayah',
                        align: 'center'
                    }, {
                        field: 'ibu',
                        title: 'Ibu',
                        align: 'center'
                    }, {
                        field: 'tanggal_baptis',
                        title: 'Tanggal Baptis',
                        align: 'center'
                    }, {
                        field: 'ketua_majelis',
                        title: 'Ketua Majelis',
                        align: 'center'
                    }, {
                        field: 'sekretaris_majelis',
                        title: 'Sekretaris Majelis',
                        align: 'center'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id_bd}" data-nama="${row.nama}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_bd}">Hapus</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'cetak',
                        title: 'Cetak',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-primary btn-view" data-id="${row.id_bd}">Cetak</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [12, 13, 14]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah
            $('.tambah-baptis').on('click', function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Baptis Dewasa Baru',
                    html: `
                        <form id="addWilayahForm">
                            <div class="form-group">
                                <label for="nama">Nama *</label>
                                <select id="nama" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama</option>
                                </select>
                                    <div id="new-nama-container" style="margin-top: 10px; display: none;">
                                    <input type="text" id="new_nama" class="form-control" placeholder="Masukkan Nama Baru">
                            </div>
                            </div>
                            <div class="form-group nama-wilayah-container">
                                <label for="nama_wilayah">Nama Wilayah *</label>
                                <select id="nama_wilayah" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Wilayah</option>
                                </select>
                            </div>
                            <div class="form-group alamaat-jemaat-container">
                                <label for="alamat_jemaat">Alamat *</label>
                                <input type="text" id="alamat_jemaat" class="form-control" placeholder="Masukkan Alamat" required>
                            </div>
                            <div class="form-group kelamin-container">
                                <label for="kelamin">Kelamin *</label>
                                <select id="kelamin" class="form-control" required>
                                    <option value="" disabled selected>Pilih Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group nama-pendeta-container">
                                <label for="nama_pendeta">Nama Pendeta *</label>
                                <select id="nama_pendeta" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Pendeta</option>
                                </select>
                            </div>
                            <div class="form-group nomor-container">
                                <label for="nomor">Nomor *</label>
                                <input type="number" id="nomor" class="form-control" placeholder="Nomor *" required>
                            </div>
                            <div class="form-group tempat-lahir-container">
                                <label for="tempat_lahir">Tempat Lahir *</label>
                                <input type="text" id="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir *" required>
                            </div>
                            <div class="form-group tanggal-lahir-container">
                                <label for="tanggal_lahir">Tanggal Lahir *</label>
                                <input type="date" id="tanggal_lahir" class="form-control" required>
                            </div>
                            <div class="form-group ayah-container">
                                <label for="ayah">Ayah *</label>
                                <input type="text" id="ayah" class="form-control" placeholder="Masukkan Nama Ayah *" required>
                            </div>
                            <div class="form-group ibu-container">
                                <label for="ibu">Ibu *</label>
                                <input type="text" id="ibu" class="form-control" placeholder="Masukkan Nama Ibu *" required>
                            </div>
                            <div class="form-group tanggal-baptis-container">
                                <label for="tanggal_baptis">Tanggal Baptis *</label>
                                <input type="date" id="tanggal_baptis" class="form-control" required>
                            </div>
                            <div class="form-group ketua-majelis-container">
                                <label for="ketua_majelis">Ketua Majelis *</label>
                                <input type="text" id="ketua_majelis" class="form-control" placeholder="Masukkan Nama Ketua Majelis *" required>
                            </div>
                            <div class="form-group sekretaris-majelis-container">
                                <label for="sekretaris_majelis">Sekretaris Majelis *</label>
                                <input type="text" id="sekretaris_majelis" class="form-control" placeholder="Masukkan Nama Sekretaris Majelis *" required>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $('#nama_wilayah, #nama_pendeta, #nama').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $(
                                '.swal2-container')
                        });

                        // Load Nama
                        $.ajax({
                            url: "{{ route('api.get.jemaat') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                onlyName: true
                            },
                            dataType: "json",
                            success: function(response) {
                                const $namaSelect = $('#nama');
                                $namaSelect.empty().append(
                                    '<option value="">Pilih Nama Jemaat</option>'
                                );
                                $namaSelect.append(new Option(
                                    '+ Tambah Nama Baru',
                                    'add-new-nama'));
                                $.each(response.rows, function(
                                    key, value) {
                                    $namaSelect.append(
                                        new Option(
                                            value
                                            .nama_jemaat,
                                            value
                                            .id_jemaat
                                        ));
                                });
                            }
                        });

                        $('#new-nama-container').hide();
                        $('#new_nama').val('');
                        $('.alamaat-jemaat-container').hide();
                        $('.kelamin-container').hide();
                        $('.tempat-lahir-container').hide();
                        $('.tanggal-lahir-container').hide();
                        $('.nama-wilayah-container').hide();

                        $('#nama').change(function() {
                            const selectedValue = $(this).val();
                            if (selectedValue ===
                                'add-new-nama') {
                                $('#new-nama-container').show();
                                $('#new_nama').val('');
                                $('.alamaat-jemaat-container')
                                    .show();
                                $('.kelamin-container').show();
                                $('.tempat-lahir-container').show();
                                $('.tanggal-lahir-container').show();
                                $('.nama-wilayah-container').show();
                            } else {
                                $('#new-nama-container').hide();
                                $('#new_nama').val('');
                                $('.alamaat-jemaat-container')
                                    .hide();
                                $('.kelamin-container').hide();
                                $('.tempat-lahir-container').hide();
                                $('.tanggal-lahir-container').hide();
                                $('.nama-wilayah-container').hide();
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
                                    $pendetaSelect.append(new Option(value
                                        .nama_pendeta,
                                        value.id_pendeta));
                                });
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
                            id_wilayah: $('#nama_wilayah').val(),
                            alamat: $('#alamat_jemaat').val(),
                            kelamin: $('#kelamin').val(),
                            id_pendeta: $('#nama_pendeta').val(),
                            nomor: $('#nomor').val(),
                            tempat_lahir: $('#tempat_lahir').val(),
                            tanggal_lahir: $('#tanggal_lahir').val(),
                            ayah: $('#ayah').val(),
                            ibu: $('#ibu').val(),
                            tanggal_baptis: $('#tanggal_baptis').val(),
                            ketua_majelis: $('#ketua_majelis').val(),
                            sekretaris_majelis: $('#sekretaris_majelis').val()
                        };

                        // Validasi semua input, pastikan tidak ada yang kosong
                        const nama = $('#nama').val();
                        const new_name = $('#new_nama').val();

                        if (nama === 'add-new-nama') {
                            for (const key in data) {
                                if (!data[key]) {
                                    Swal.showValidationMessage(
                                        `Harap isi kolom ${key.replace('_', ' ')} terlebih dahulu!`
                                    );
                                    return false;
                                }
                            }
                        } else {
                            if (!nama || !data['tanggal_baptis'] || !data['ketua_majelis'] || !
                                data['sekretaris_majelis'] || !data['ayah'] || !data['ibu'] || !
                                data['nomor'] || !data['id_pendeta']) {
                                Swal.showValidationMessage(
                                    `Harap isi semua kolom terlebih dahulu!`
                                );
                                return false;
                            }
                        }

                        if (nama === 'add-new-nama' && !new_name) {
                            Swal.showValidationMessage(
                                `Harap isi kolom Nama Anak terlebih dahulu!`
                            );
                            return false;
                        }

                        data.nama = nama;
                        data.new_name = new_name;

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.baptisanak') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id_jemaat: data.nama
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'Nama anak sudah terdaftar dalam data baptis anak!'
                                        );
                                    } else {
                                        resolve(data);
                                    }
                                }
                            });
                        }).catch(error => {
                            Swal.showValidationMessage(error);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('api.post.baptisdewasa') }}",
                            type: "POST",
                            data: {
                                ...result.value,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data baptis anak berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function() {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data baptis anak gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function() {
                event.preventDefault();
                var old_id_bd = $(this).data('id');
                var nama = $(this).data('nama');

                $.ajax({
                    url: "{{ route('api.get.baptisdewasa') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: old_id_bd,
                    },
                    dataType: "json",
                    success: function(response) {
                        var id_pendeta = response.rows[0].id_pendeta;
                        var id_wilayah = response.rows[0].id_wilayah;

                        Swal.fire({
                            title: 'Edit Baptis Dewasa',
                            html: `
                                <form id="addWilayahForm">
                                    <div class="form-group">
                                        <label for="nama">Nama Jemaat</label>
                                        <input type="text" id="alamat_jemaat" class="form-control" value="${nama}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_pendeta">Nama Pendeta *</label>
                                        <select id="nama_pendeta" class="form-control" required style="width: 100%;">
                                            <option value="">Pilih Nama Pendeta</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nomor">Nomor *</label>
                                        <input type="number" id="nomor" class="form-control" placeholder="Nomor *" value="${response.rows[0].nomor}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ayah">Ayah *</label>
                                        <input type="text" id="ayah" class="form-control" placeholder="Masukkan Nama Ayah *" value="${response.rows[0].ayah}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ibu">Ibu *</label>
                                        <input type="text" id="ibu" class="form-control" placeholder="Masukkan Nama Ibu *" value="${response.rows[0].ibu}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_baptis">Tanggal Baptis *</label>
                                        <input type="date" id="tanggal_baptis" class="form-control" value="${response.rows[0].tanggal_baptis}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="ketua_majelis">Ketua Majelis *</label>
                                        <input type="text" id="ketua_majelis" class="form-control" placeholder="Masukkan Nama Ketua Majelis *" value="${response.rows[0].ketua_majelis}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="sekretaris_majelis">Sekretaris Majelis *</label>
                                        <input type="text" id="sekretaris_majelis" class="form-control" placeholder="Masukkan Nama Sekretaris Majelis *" value="${response.rows[0].sekretaris_majelis}" required>
                                    </div>
                                </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            didOpen: () => {
                                $('#nama_pendeta').select2({
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
                                    nomor: $('#nomor').val(),
                                    ayah: $('#ayah').val(),
                                    ibu: $('#ibu').val(),
                                    tanggal_baptis: $('#tanggal_baptis').val(),
                                    ketua_majelis: $('#ketua_majelis').val(),
                                    sekretaris_majelis: $('#sekretaris_majelis')
                                        .val()
                                };

                                // Validasi semua input, pastikan tidak ada yang kosong
                                for (const key in data) {
                                    if (!data[key]) {
                                        Swal.showValidationMessage(
                                            `Harap isi kolom ${key.replace('_', ' ')} terlebih dahulu!`
                                        );
                                        return false;
                                    }
                                }

                                return data;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ route('api.update.baptisdewasa') }}",
                                    type: "POST",
                                    data: {
                                        ...result.value,
                                        old_id_bd: old_id_bd,
                                        id_jemaat: response.rows[0].id_jemaat,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function() {
                                        alert.fire({
                                            icon: 'success',
                                            title: 'Data baptis dewasa berhasil diupdate!'
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function() {
                                        alert.fire({
                                            icon: 'error',
                                            title: 'Data baptis dewasa gagal diupdate!'
                                        });
                                    }
                                });
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        reject('Terjadi kesalahan saat memuat data baptis anak.');
                    }
                });
            });
        });

        $(document).on('click', '.btn-delete', function() {
            event.preventDefault();
            var id_bd = $(this).data('id');

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
                        url: `{{ route('api.delete.baptisdewasa') }}`,
                        type: 'POST',
                        data: {
                            id_bd: id_bd,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data baptis dewasa berhasil dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data baptis dewasa gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        function ApiGetBaptisDewasa(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.baptisdewasa') }}",
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
