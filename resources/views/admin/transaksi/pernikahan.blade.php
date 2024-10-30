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
                },{
                    field: 'tanggal_nikah',
                    title: 'Tgl Pernikahan',
                    align: 'center'
                }, {
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
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id}" data-name="${row.name}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id}">Hapus</button>`;
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
                        field: 'nomor',
                        title: 'Nomor Pernikahan',
                        align: 'center'
                    },{
                        field: 'tanggal_nikah',
                        title: 'Tgl Pernikahan',
                        align: 'center'
                    }, {
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
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id}" data-name="${row.name}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id}">Hapus</button>`;
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
                        ignoreColumn: [7, 8, 9]
                    }
                });
            }).trigger('change');

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
                        </div>
                        <div class="form-group">
                            <label for="tanggal_nikah">Tanggal Menikah *</label>
                            <input type="date" id="tanggal_nikah" class="form-control" required>
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
                            <label for="warga">Jenis Warga *</label>
                            <select id="warga" class="form-control" required>
                                <option value="">Pilih Jenis Warga</option>
                                <option value="Warga Jemaat">Warga Jemaat</option>
                                <option value="Bukan Warga">Bukan Warga</option>
                            </select>
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
                            Object.entries(response.rows).forEach(function([key, value]) {
                                $gerejaSelect.append(
                                    `<option value="${value.id_gereja}">${value.nama_gereja}</option>`
                                );
                            });

                            $gerejaSelect.append(
                                '<option value="add-new-gereja">+ Tambah Gereja Baru</option>'
                            );
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
                },
                preConfirm: () => {


                    // Validasi input
                    if (!id_jabatan || !jabatan_majelis || !periode) {
                        Swal.showValidationMessage(
                            'Terdapat bagian yang tidak valid atau belum diisi!');
                        return false;
                    }

                    return new Promise((resolve, reject) => {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('api.get.jabatan-majelis') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id_jabatan
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.total > 0) {
                                    reject(
                                        'ID jabatan majelis sudah ada, silahkan gunakan ID jabatan majelis lain!'
                                    );
                                } else {
                                    resolve({
                                        id_jabatan: id_jabatan,
                                        jabatan_majelis: jabatan_majelis,
                                        periode: periode
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
                        id_jabatan,
                        jabatan_majelis,
                        periode
                    } = result.value;

                    $.ajax({
                        url: "{{ route('api.post.jabatan-majelis') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id_jabatan,
                            jabatan_majelis: jabatan_majelis,
                            periode: periode
                        },
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data jabatan majelis berhasil ditambahkan!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data jabatan majelis gagal ditambahkan!'
                            });
                        }
                    });
                }
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
