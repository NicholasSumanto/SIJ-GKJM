@extends('layouts.admin-main-transaksi')

@section('title', 'Transaksi Pernikahan')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
        <a href="" class="btn btn-success tambah-pernikahan">Tambah Pernikahan</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-filter-control="true" data-ajax="ApiGetPernikahan">
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
                    field: 'nomor',
                    title: 'Nomor Pernikahan',
                    align: 'center'
                }, {
                    field: 'tanggal_nikah',
                    title: 'Tgl Pernikahan',
                    align: 'center'
                }, {
                    field: 'nama_wilayah',
                    title: 'Wilayah',
                    filterControl: 'select',
                    align: 'center'
                },{
                    field: 'pengantin_pria',
                    title: 'Pria',
                    align: 'center'
                }, {
                    field: 'pengantin_wanita',
                    title: 'Wanita',
                    align: 'center'
                }, {
                    field: 'ayah_pria + ibu_pria',
                    title: 'Ortu Pria',
                    align: 'center'
                }, {
                    field: 'ibu_pria + ibu_wanita',
                    title: 'Ortu Wanita',
                    align: 'center'
                }, {
                    field: 'pendeta',
                    title: 'Pendeta',
                    align: 'center'
                }, {
                    field: 'tempat',
                    title: 'Tempat',
                    align: 'center'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-nomor="${row.nomor}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-nomor="${row.nomor}">Hapus</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'cetak',
                    title: 'Cetak',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-view" data-nomor="${row.nomor}">Cetak</button>`;
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
                        field: 'nomor',
                        title: 'Nomor Pernikahan',
                        align: 'center'
                    }, {
                        field: 'tanggal_nikah',
                        title: 'Tgl Pernikahan',
                        align: 'center'
                    }, {
                        field: 'nama_wilayah',
                        title: 'Wilayah',
                        filterControl: 'select',
                        align: 'center'
                    },{
                        field: 'pengantin_pria',
                        title: 'Pria',
                        align: 'center'
                    }, {
                        field: 'pengantin_wanita',
                        title: 'Wanita',
                        align: 'center'
                    }, {
                        title: 'Ortu Pria',
                        align: 'center',
                        formatter: function(value, row, index) {
                            return 'Ayah : ' + row.ayah_pria + '<br>Ibu : ' + row
                                .ibu_pria;
                        }
                    }, {
                        title: 'Ortu Wanita',
                        align: 'center',
                        formatter: function(value, row, index) {
                            return 'Ayah : ' + row.ibu_pria + '<br>Ibu : ' + row
                                .ibu_wanita;
                        }
                    }, {
                        field: 'pendeta',
                        title: 'Pendeta',
                        align: 'center'
                    }, {
                        field: 'tempat',
                        title: 'Tempat',
                        align: 'center'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-nomor="${row.nomor}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-nomor="${row.nomor}">Hapus</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'cetak',
                        title: 'Cetak',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-primary btn-view" data-nomor="${row.nomor}">Cetak</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [7, 8, 9]
                    }
                });
            }).trigger('change');
        });

        // Event listener untuk tombol tambah Pernikahan
        $('.tambah-pernikahan').on('click', function() {
            event.preventDefault();
            Swal.fire({
                title: 'Tambah Pernikahan Baru',
                html: `
                    <form id="addJabatanMajelisForm">
                        <div class="form-group">
                            <label for="nomor">Nomor Pernikahan *</label>
                            <input type="text" id="nomor" class="form-control" placeholder="Masukkan Nomor Pernikahan" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_gereja">Nama Gereja *</label>
                            <select id="nama_gereja" class="form-control" required>
                                <option value="">Pilih Nama Gereja</option>
                                <!-- AJAX -->
                            </select>
                            <div id="new-gereja-container" style="margin-top: 10px; display: none;">
                                <input type="text" id="new_gereja" class="form-control" placeholder="Masukkan Gereja Baru">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_nikah">Tanggal Menikah *</label>
                            <input type="date" id="tanggal_nikah" class="form-control" required>
                        </div>
                         <div class="form-group">
                            <label for="id_wilayah">Warga Wilayah *</label>
                            <select id="id_wilayah" class="form-control" required>
                                <option value="">Pilih Wilayah</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_pendeta">Nama Pendeta *</label>
                            <select id="nama_pendeta" class="form-control" required>
                                <option value="">Pilih Nama Pendeta</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pengantin_pria">Nama Pengantin Pria *</label>
                            <input type="text" id="pengantin_pria" class="form-control" placeholder="Masukkan Nama Pengantin Pria" required>
                        </div>
                        <div class="form-group">
                            <label for="pengantin_wanita">Nama Pengantin Wanita *</label>
                            <input type="text" id="pengantin_wanita" class="form-control" placeholder="Masukkan Nama Pengantin Wanita" required>
                        </div>
                        <div class="form-group">
                            <label for="ayah_pria">Nama Ayah Pengantin Pria *</label>
                            <input type="text" id="ayah_pria" class="form-control" placeholder="MasukkanNama Ayah Pengantin Pria" required>
                        </div>
                        <div class="form-group">
                            <label for="ibu_pria">Nama Ibu Pengantin Pria *</label>
                            <input type="text" id="ibu_pria" class="form-control" placeholder="Masukkan Nama Ibu Pengantin Pria" required>
                        </div>
                        <div class="form-group">
                            <label for="ayah_wanita">Nama Ayah Pengantin Wanita *</label>
                            <input type="text" id="ayah_wanita" class="form-control" placeholder="Masukkan Nama Ayah Pengantin Wanita" required>
                        </div>
                        <div class="form-group">
                            <label for="ibu_wanita">Nama Ibu Pengantin Wanita *</label>
                            <input type="text" id="ibu_wanita" class="form-control" placeholder="Masukkan Nama Ibu Pengantin Wanita" required>
                        </div>
                        <div class="form-group">
                            <label for="saksi1">Nama Saksi 1 *</label>
                            <input type="text" id="saksi1" class="form-control" placeholder="Masukkan Nama Saksi 1" required>
                        </div>
                        <div class="form-group">
                            <label for="saksi2">Nama Saksi 2 *</label>
                            <input type="text" id="saksi2" class="form-control" placeholder="Masukkan Nama Saksi 2" required>
                        </div>
                        <div class="form-group">
                            <label for="tempat">Nama Lokasi *</label>
                            <input type="text" id="tempat" class="form-control" placeholder="Masukkan Nama Lokasi" required>
                        </div>
                        <div class="form-group">
                            <label for="ketua_majelis">Nama Ketua Majelis *</label>
                            <input type="text" id="ketua_majelis" class="form-control" placeholder="Masukkan Nama Ketua Majelis" required>
                        </div>
                        <div class="form-group">
                            <label for="sekretaris_majelis">Nama Sekretaris Majelis *</label>
                            <input type="text" id="sekretaris_majelis" class="form-control" placeholder="Masukkan Nama Sekretaris Majelis" required>
                        </div>
                    </form>
                    `,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                didOpen: () => {
                    $.ajax({
                        url: "{{ route('api.get.gereja') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            const $gerejaSelect = $('#nama_gereja');
                            Object.entries(response).forEach(function([key, value]) {
                                $gerejaSelect.append(
                                    `<option value="${value.nama_gereja}">${value.nama_gereja}</option>`
                                );
                            });

                            $gerejaSelect.append(
                                '<option value="add-new-gereja">+ Tambah Gereja Baru</option>'
                            );
                        }
                    });

                    $.ajax({
                            url: "{{ route('api.get.wilayah') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $idWilayah = $('#id_wilayah');
                                Object.entries(response).forEach(([key, value]) => {
                                    $idWilayah.append(
                                        `<option value="${value.id_wilayah}">${value.nama_wilayah}</option>`
                                    );
                                });
                            }
                        });

                    $.ajax({
                        url: "{{ route('api.get.pendeta') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            const $pendetaSelect = $('#nama_pendeta');
                            Object.entries(response.rows).forEach(function([key, value]) {
                                $pendetaSelect.append(
                                    `<option value="${value.id_pendeta}">${value.nama_pendeta}</option>`
                                );
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Gagal memuat data pendeta',
                                'error');
                        }
                    });

                    $('#nama_gereja').change(function() {
                        const selectedValue = $(this).val();
                        if (selectedValue === 'add-new-gereja') {
                            $('#new-gereja-container').show();
                            $('#new_gereja').val('');
                        } else {
                            $('#new-gereja-container').hide();
                            $('#new_gereja').val('');
                        }
                    });
                },
                preConfirm: () => {
                    const nomor = $('#nomor').val();
                    const nama_gereja = $('#nama_gereja').val();
                    const nama_wilayah = $('#id_wilayah').val();
                    const new_gereja = $('#new_gereja').val();
                    const tanggal_nikah = $('#tanggal_nikah').val();
                    const nama_pendeta = $('#nama_pendeta').val();
                    const pengantin_pria = $('#pengantin_pria').val();
                    const pengantin_wanita = $('#pengantin_wanita').val();
                    const ayah_pria = $('#ayah_pria').val();
                    const ibu_pria = $('#ibu_pria').val();
                    const ayah_wanita = $('#ayah_wanita').val();
                    const ibu_wanita = $('#ibu_wanita').val();
                    const saksi1 = $('#saksi1').val();
                    const saksi2 = $('#saksi2').val();
                    const tempat = $('#tempat').val();
                    const ketua_majelis = $('#ketua_majelis').val();
                    const sekretaris_majelis = $('#sekretaris_majelis').val();

                    if (nomor === '' || nama_wilayah === ''|| nama_gereja === '' || tanggal_nikah === '' || nama_pendeta ===
                        '' || pengantin_pria === '' || pengantin_wanita === '' || ayah_pria === '' ||
                        ibu_pria === '' || ayah_wanita === '' || ibu_wanita === '' || saksi1 === '' ||
                        saksi2 === '' || tempat === '' || ketua_majelis === '' ||
                        sekretaris_majelis === '') {
                        Swal.showValidationMessage('Data tidak boleh kosong!');
                    }

                    return new Promise((resolve, reject) => {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('api.get.pernikahan') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                nomor: nomor
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.total > 0) {
                                    reject(
                                        'Nomor pernikahan sudah ada, silahkan gunakan nomor pernikahan lain!'
                                    );
                                } else {
                                    resolve({
                                        nomor: nomor,
                                        nama_gereja: nama_gereja ===
                                            'add-new-gereja' ? '' :
                                            nama_gereja,
                                        new_gereja: new_gereja === '' ? '' :
                                            new_gereja,
                                        tanggal_nikah: tanggal_nikah,
                                        nama_wilayah: nama_wilayah,
                                        nama_pendeta: nama_pendeta,
                                        pengantin_pria: pengantin_pria,
                                        pengantin_wanita: pengantin_wanita,
                                        ayah_pria: ayah_pria,
                                        ibu_pria: ibu_pria,
                                        ayah_wanita: ayah_wanita,
                                        ibu_wanita: ibu_wanita,
                                        saksi1: saksi1,
                                        saksi2: saksi2,
                                        tempat: tempat,
                                        ketua_majelis: ketua_majelis,
                                        sekretaris_majelis: sekretaris_majelis
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
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
                        nomor,
                        nama_gereja,
                        new_gereja,
                        nama_wilayah,
                        tanggal_nikah,
                        nama_pendeta,
                        pengantin_pria,
                        pengantin_wanita,
                        ayah_pria,
                        ibu_pria,
                        ayah_wanita,
                        ibu_wanita,
                        saksi1,
                        saksi2,
                        tempat,
                        ketua_majelis,
                        sekretaris_majelis
                    } = result.value;

                    $.ajax({
                        url: "{{ route('api.post.pernikahan') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            nomor: nomor,
                            nama_gereja: nama_gereja,
                            new_gereja: new_gereja,
                            id_wilayah: nama_wilayah,
                            tanggal_nikah: tanggal_nikah,
                            id_pendeta: nama_pendeta,
                            pengantin_pria: pengantin_pria,
                            pengantin_wanita: pengantin_wanita,
                            ayah_pria: ayah_pria,
                            ibu_pria: ibu_pria,
                            ayah_wanita: ayah_wanita,
                            ibu_wanita: ibu_wanita,
                            saksi1: saksi1,
                            saksi2: saksi2,
                            tempat: tempat,
                            ketua_majelis: ketua_majelis,
                            sekretaris_majelis: sekretaris_majelis
                        },
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data pernikahan berhasil ditambahkan!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data pernikahan gagal ditambahkan!'
                            });
                        }
                    });
                }
            });
        });

        // Event listener untuk tombol edit
        $(document).on('click', '.btn-edit', function() {
            event.preventDefault();
            var old_nomor = $(this).data('nomor');

            $.ajax({
                type: "POST",
                url: "{{ route('api.get.pernikahan') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    nomor: old_nomor
                },
                dataType: "json",
                success: function(response) {
                    var nomor = response.rows[0].nomor;
                    var id_wilayah = response.rows[0].id_wilayah;
                    var nama_gereja = response.rows[0].nama_gereja;
                    var tanggal_nikah = response.rows[0].tanggal_nikah;
                    var id_pendeta = response.rows[0].id_pendeta;
                    var pengantin_pria = response.rows[0].pengantin_pria;
                    var pengantin_wanita = response.rows[0].pengantin_wanita;
                    var ayah_pria = response.rows[0].ayah_pria;
                    var ibu_pria = response.rows[0].ibu_pria;
                    var ayah_wanita = response.rows[0].ayah_wanita;
                    var ibu_wanita = response.rows[0].ibu_wanita;
                    var saksi1 = response.rows[0].saksi1;
                    var saksi2 = response.rows[0].saksi2;
                    var tempat = response.rows[0].tempat;
                    var ketua_majelis = response.rows[0].ketua_majelis;
                    var sekretaris_majelis = response.rows[0].sekretaris_majelis;

                    Swal.fire({
                        title: 'Tambah Pernikahan Baru',
                        html: `
                        <form id="addJabatanMajelisForm">
                            <div class="form-group">
                                <label for="nomor">Nomor Pernikahan *</label>
                                <input type="text" id="nomor" class="form-control" placeholder="Masukkan Nomor Pernikahan" value="${nomor}" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_gereja">Nama Gereja *</label>
                                <select id="nama_gereja" class="form-control" required>
                                    <option value="">Pilih Nama Gereja</option>
                                    <!-- AJAX -->
                                </select>
                                <div id="new-gereja-container" style="margin-top: 10px; display: none;">
                                    <input type="text" id="new_gereja" class="form-control" placeholder="Masukkan Gereja Baru">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="id_wilayah">Warga Wilayah *</label>
                                <select id="id_wilayah" class="form-control" required>
                                    <option value="">Pilih Wilayah</option>
                                    <!-- AJAX -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_nikah">Tanggal Menikah *</label>
                                <input type="date" id="tanggal_nikah" class="form-control" value="${tanggal_nikah}" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_pendeta">Nama Pendeta *</label>
                                <select id="nama_pendeta" class="form-control" required>
                                    <option value="">Pilih Nama Pendeta</option>
                                    <!-- AJAX -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pengantin_pria">Nama Pengantin Pria *</label>
                                <input type="text" id="pengantin_pria" class="form-control" placeholder="Masukkan Nama Pengantin Pria" value="${pengantin_pria}" required>
                            </div>
                            <div class="form-group">
                                <label for="pengantin_wanita">Nama Pengantin Wanita *</label>
                                <input type="text" id="pengantin_wanita" class="form-control" placeholder="Masukkan Nama Pengantin Wanita" value="${pengantin_wanita}" required>
                            </div>
                            <div class="form-group">
                                <label for="ayah_pria">Nama Ayah Pengantin Pria *</label>
                                <input type="text" id="ayah_pria" class="form-control" placeholder="MasukkanNama Ayah Pengantin Pria" value="${ayah_pria}" required>
                            </div>
                            <div class="form-group">
                                <label for="ibu_pria">Nama Ibu Pengantin Pria *</label>
                                <input type="text" id="ibu_pria" class="form-control" placeholder="Masukkan Nama Ibu Pengantin Pria" value="${ibu_pria}" required>
                            </div>
                            <div class="form-group">
                                <label for="ayah_wanita">Nama Ayah Pengantin Wanita *</label>
                                <input type="text" id="ayah_wanita" class="form-control" placeholder="Masukkan Nama Ayah Pengantin Wanita" value="${ayah_wanita}" required>
                            </div>
                            <div class="form-group">
                                <label for="ibu_wanita">Nama Ibu Pengantin Wanita *</label>
                                <input type="text" id="ibu_wanita" class="form-control" placeholder="Masukkan Nama Ibu Pengantin Wanita" value="${ibu_wanita}" required>
                            </div>
                            <div class="form-group">
                                <label for="saksi1">Nama Saksi 1 *</label>
                                <input type="text" id="saksi1" class="form-control" placeholder="Masukkan Nama Saksi 1" value="${saksi1}" required>
                            </div>
                            <div class="form-group">
                                <label for="saksi2">Nama Saksi 2 *</label>
                                <input type="text" id="saksi2" class="form-control" placeholder="Masukkan Nama Saksi 2" value="${saksi2}" required>
                            </div>
                            <div class="form-group">
                                <label for="tempat">Nama Lokasi *</label>
                                <input type="text" id="tempat" class="form-control" placeholder="Masukkan Nama Lokasi" value="${tempat}" required>
                            </div>
                            <div class="form-group">
                                <label for="ketua_majelis">Nama Ketua Majelis *</label>
                                <input type="text" id="ketua_majelis" class="form-control" placeholder="Masukkan Nama Ketua Majelis" value="${ketua_majelis}" required>
                            </div>
                            <div class="form-group">
                                <label for="sekretaris_majelis">Nama Sekretaris Majelis *</label>
                                <input type="text" id="sekretaris_majelis" class="form-control" placeholder="Masukkan Nama Sekretaris Majelis" value="${sekretaris_majelis}" required>
                            </div>
                        </form>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Batal',
                        didOpen: () => {
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
                                    Object.entries(response)
                                        .forEach(function([
                                            key, value
                                        ]) {
                                            $gerejaSelect
                                                .append(
                                                    `<option value="${value.nama_gereja}">${value.nama_gereja}</option>`
                                                );
                                        });

                                    $gerejaSelect.append(
                                        '<option value="add-new-gereja">+ Tambah Gereja Baru</option>'
                                    );

                                    $gerejaSelect.val(nama_gereja);
                                }
                            });

                            $.ajax({
                            url: "{{ route('api.get.wilayah') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $idWilayah = $('#id_wilayah');
                                Object.entries(response).forEach(([key, value]) => {
                                    $idWilayah.append(
                                        `<option value="${value.id_wilayah}">${value.nama_wilayah}</option>`
                                    );
                                });
                                $idWilayah.val(id_wilayah);
                            }
                        });

                            $.ajax({
                                url: "{{ route('api.get.pendeta') }}",
                                type: "POST",
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                dataType: "json",
                                success: function(response) {
                                    const $pendetaSelect = $(
                                        '#nama_pendeta');
                                    Object.entries(response.rows)
                                        .forEach(
                                            function([key, value]) {
                                                $pendetaSelect
                                                    .append(
                                                        `<option value="${value.id_pendeta}">${value.nama_pendeta}</option>`
                                                    );
                                            });

                                    $pendetaSelect.val(id_pendeta);
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire('Error',
                                        'Gagal memuat data pendeta',
                                        'error');
                                }
                            });

                            $('#nama_gereja').change(function() {
                                const selectedValue = $(this).val();
                                if (selectedValue ===
                                    'add-new-gereja') {
                                    $('#new-gereja-container').show();
                                    $('#new_gereja').val('');
                                } else {
                                    $('#new-gereja-container').hide();
                                    $('#new_gereja').val('');
                                }
                            });
                        },
                        preConfirm: () => {
                            const nomor = $('#nomor').val();
                            const nama_gereja = $('#nama_gereja').val();
                            const nama_wilayah = $('#id_wilayah').val();
                            const new_gereja = $('#new_gereja').val();
                            const tanggal_nikah = $('#tanggal_nikah').val();
                            const nama_pendeta = $('#nama_pendeta').val();
                            const pengantin_pria = $('#pengantin_pria').val();
                            const pengantin_wanita = $('#pengantin_wanita').val();
                            const ayah_pria = $('#ayah_pria').val();
                            const ibu_pria = $('#ibu_pria').val();
                            const ayah_wanita = $('#ayah_wanita').val();
                            const ibu_wanita = $('#ibu_wanita').val();
                            const saksi1 = $('#saksi1').val();
                            const saksi2 = $('#saksi2').val();
                            const tempat = $('#tempat').val();
                            const ketua_majelis = $('#ketua_majelis').val();
                            const sekretaris_majelis = $('#sekretaris_majelis').val();

                            if (nomor === '' || nama_gereja === '' || tanggal_nikah ===
                                '' || nama_pendeta === '' || pengantin_pria === '' ||
                                pengantin_wanita === '' || ayah_pria === '' || ibu_pria ===
                                '' || ayah_wanita === '' || ibu_wanita === '' || saksi1 ===
                                '' || saksi2 === '' || tempat === '' ||
                                ketua_majelis === '' || sekretaris_majelis === '') {
                                Swal.showValidationMessage('Data tidak boleh kosong!');
                            }

                            return new Promise((resolve, reject) => {
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('api.get.pernikahan') }}",
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        nomor: nomor
                                    },
                                    dataType: "json",
                                    success: function(
                                        response) {
                                        if (old_nomor != nomor &&
                                            response.total >
                                            0) {
                                            reject(
                                                'Nomor pernikahan sudah ada, silahkan gunakan nomor pernikahan lain!'
                                            );
                                        } else {
                                            resolve({
                                                nomor: nomor,
                                                nama_gereja: nama_gereja ===
                                                    'add-new-gereja' ?
                                                    new_gereja :
                                                    nama_gereja,
                                                new_gereja: new_gereja ===
                                                    '' ?
                                                    '' :
                                                    new_gereja,
                                                nama_wilayah: nama_wilayah,
                                                tanggal_nikah: tanggal_nikah,
                                                nama_pendeta: nama_pendeta,
                                                pengantin_pria: pengantin_pria,
                                                pengantin_wanita: pengantin_wanita,
                                                ayah_pria: ayah_pria,
                                                ibu_pria: ibu_pria,
                                                ayah_wanita: ayah_wanita,
                                                ibu_wanita: ibu_wanita,
                                                saksi1: saksi1,
                                                saksi2: saksi2,
                                                tempat: tempat,
                                                ketua_majelis: ketua_majelis,
                                                sekretaris_majelis: sekretaris_majelis
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
                                nomor,
                                nama_gereja,
                                new_gereja,
                                tanggal_nikah,
                                nama_wilayah,
                                nama_pendeta,
                                pengantin_pria,
                                pengantin_wanita,
                                ayah_pria,
                                ibu_pria,
                                ayah_wanita,
                                ibu_wanita,
                                saksi1,
                                saksi2,
                                tempat,
                                ketua_majelis,
                                sekretaris_majelis
                            } = result.value;

                            $.ajax({
                                url: "{{ route('api.update.pernikahan') }}",
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    nomor: nomor,
                                    old_nomor: old_nomor,
                                    nama_gereja: nama_gereja,
                                    id_wilayah: nama_wilayah,
                                    new_gereja: new_gereja,
                                    tanggal_nikah: tanggal_nikah,
                                    id_pendeta: nama_pendeta,
                                    pengantin_pria: pengantin_pria,
                                    pengantin_wanita: pengantin_wanita,
                                    ayah_pria: ayah_pria,
                                    ibu_pria: ibu_pria,
                                    ayah_wanita: ayah_wanita,
                                    ibu_wanita: ibu_wanita,
                                    saksi1: saksi1,
                                    saksi2: saksi2,
                                    tempat: tempat,
                                    ketua_majelis: ketua_majelis,
                                    sekretaris_majelis: sekretaris_majelis
                                },
                                success: function(response) {
                                    alert.fire({
                                        icon: 'success',
                                        title: 'Data pernikahan berhasil diubah!'
                                    });
                                    $table.bootstrapTable('refresh');
                                },
                                error: function(xhr, status, error) {
                                    alert.fire({
                                        icon: 'error',
                                        title: 'Data pernikahan gagal diubah!'
                                    });
                                }
                            });
                        }
                    });
                },
                error: function(xhr, status, error) {
                    reject('Terjadi kesalahan saat memuat data pernikahan.');
                }
            });
        });

        $(document).on('click', '.btn-delete', function() {
            event.preventDefault();
            var nomor = $(this).data('nomor');

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
                        url: `{{ route('api.delete.pernikahan') }}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            nomor: nomor
                        },
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data pernikahan berhasil dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data pernikahan gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        function ApiGetPernikahan(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.pernikahan') }}",
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
