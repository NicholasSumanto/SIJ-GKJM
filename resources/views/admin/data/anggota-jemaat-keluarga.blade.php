@extends('layouts.admin-main-data')

@section('title', 'Anggota Jemaat Keluarga')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
    <style>
        .btn-keluarga {
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="card-body">
        <a href="" class="btn btn-success tambah-keluarga">Tambah Keluarga</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-ajax="ApiGetKeluarga">
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
                    field: 'id_keluarga',
                    title: 'ID Keluarga',
                    align: 'center'
                }, {
                    field: 'kepala_keluarga.nama_jemaat',
                    title: 'Nama Kepala Keluarga',
                    align: 'center'
                }, {
                    field: 'keterangan_hubungan',
                    title: 'Keterangan Hubungan',
                    align: 'center'
                }, {
                    field: 'nama_wilayah',
                    title: 'Wilayah',
                    align: 'center'
                }, {
                    field: 'Keluarga',
                    title: 'Lihat Keluarga',
                    formatter: function(value, row, index) {
                        return `
                                <button class="btn btn-success btn-keluarga" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${row.id_keluarga}" aria-expanded="false" aria-controls="collapse-${row.id_keluarga}" data-id="${row.id_keluarga}">
                                    Lihat Keluarga
                                </button>

                                <div class="collapse" id="collapse-${row.id_keluarga}">
                                    <div class="card card-body mt-2">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama Anggota</th>
                                                    <th>Hubgunan</th>
                                                    <th>Keterangan Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="anggota-keluarga-body-${row.id_keluarga}">
                                                <!-- Data anggota keluarga akan dimuat di sini -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            `;
                    },
                    align: 'center'
                }, {
                    field: 'edit_kepala_keluarga',
                    title: 'Edit Kepala Keluarga',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" type="button" data-id="${row.id_keluarga}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'edit_keluarga',
                    title: 'Tambah Anggota Keluarga',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-succes btn-tambah-anggota" type="button" data-id="${row.id_keluarga}">Tambah</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_keluarga}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColumn: [4, 5]
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
                        field: 'id_keluarga',
                        title: 'ID Keluarga',
                        align: 'center'
                    }, {
                        field: 'kepala_keluarga.nama_jemaat',
                        title: 'Nama Kepala Keluarga',
                        align: 'center'
                    }, {
                        field: 'keterangan_hubungan',
                        title: 'Keterangan Hubungan',
                        align: 'center'
                    }, {
                        field: 'nama_wilayah',
                        title: 'Wilayah',
                        align: 'center'
                    }, {
                        field: 'Keluarga',
                        title: 'Lihat Keluarga',
                        formatter: function(value, row, index) {
                            return `
                                <button class="btn btn-success btn-keluarga" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${row.id_keluarga}" aria-expanded="false" aria-controls="collapse-${row.id_keluarga}" data-id="${row.id_keluarga}">
                                    Lihat Keluarga
                                </button>

                                <div class="collapse" id="collapse-${row.id_keluarga}">
                                    <div class="card card-body mt-2">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama Anggota</th>
                                                    <th>Hubgunan</th>
                                                    <th>Keterangan Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="anggota-keluarga-body-${row.id_keluarga}">
                                                <!-- Data anggota keluarga akan dimuat di sini -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            `;
                        },
                        align: 'center'
                    }, {
                        field: 'edit_kepala_keluarga',
                        title: 'Edit Kepala Keluarga',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" type="button" data-id="${row.id_keluarga}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'edit_keluarga',
                        title: 'Tambah Anggota Keluarga',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-success btn-tambah-anggota" type="button" data-id="${row.id_keluarga}">Tambah</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_keluarga}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [4, 5]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol keluarga
            $(document).on('click', '.btn-keluarga', function() {
                const idKeluarga = $(this).data('id');
                const tbody = $(`#anggota-keluarga-body-${idKeluarga}`);
                if (tbody.children().length > 0) return;

                $.ajax({
                    url: "{{ route('api.get.anggotakeluarga') }}",
                    method: 'POST',
                    data: {
                        id_keluarga: idKeluarga
                    },
                    success: function(anggotaKeluarga) {
                        console.log(anggotaKeluarga);
                        anggotaKeluarga.forEach(anggota => {
                            tbody.append(`
                            <tr>
                                <td>${anggota.nama_anggota.nama_jemaat || 'N/A'}</td>
                                <td>${anggota.keterangan_hubungan || 'N/A'}</td>
                                <td>${anggota.keterangan_status?.keterangan_status ?? 'Bukan Jemaat'}</td>
                                <td>
                                    <button class="btn btn-warning btn-edit-anggota" data-id="${anggota.id_anggota_keluarga}" style="display: none;"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-danger btn-delete-anggota" data-id="${anggota.id_anggota_keluarga}"><i class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                        `);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching anggota keluarga:", error);
                        tbody.append(`
                        <tr>
                            <td colspan="3" class="text-center">Gagal memuat data anggota keluarga</td>
                        </tr>
                    `);
                    }
                });
            });

            // Event listener untuk tombol tambah anggota keluarga
            $(document).on('click', '.btn-tambah-anggota', function() {
                event.preventDefault();
                const id_keluarga = $(this).data('id');

                Swal.fire({
                    title: 'Tambah Anggota Keluarga Baru',
                    html: `
                        <form id="addKeluargaForm">
                            <div class="form-group">
                                <label for="status">Status Anggota</label>
                                <select id="status" class="form-control" >
                                    <option value="">Pilih Status</option>
                                    <option value="1">Jemaat</option>
                                    <option value="3">Bukan Jemaat</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_jemaat">Nama Anggota Keluarga *</label>
                                <div  id="nama-anggota-select-container">
                                    <select id="nama_jemaat" class="form-control" required style="width: 100%;">
                                        <option value="">Pilih Nama Anggota Keluarga</option>
                                    </select>
                                </div>
                                <div id="nama-anggota-container" style="display: none;">
                                    <input type="text" id="nama_anggota" class="form-control" placeholder="Masukkan Nama Anggota Bukan Jemaat *">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hubunganKeluarga">Hubungan Anggota Keluarga</label>
                                <select id="hubunganKeluarga" class="form-control" >
                                    <option value="Suami">Suami</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak">Anak</option>
                                </select>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $('#nama_jemaat').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $(
                                '.swal2-container')
                        });

                        // Event listener ketika status dipilih
                        $('#status').on('change', function() {
                            const status = $(this).val();
                            if (status == 3) {
                                $('#nama-anggota-select-container').hide();
                                $('#nama-anggota-container').show();
                            } else {
                                $('#nama-anggota-select-container').show();
                                $('#nama-anggota-container').hide();
                            }
                        });

                        // Fungsi untuk memuat jemaat berdasarkan status
                        $.ajax({
                            url: "{{ route('api.get.jemaat') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: 1,
                                onlyName: true
                            },
                            dataType: "json",
                            success: function(response) {
                                const $jemaatSelect = $('#nama_jemaat');
                                $jemaatSelect.empty().append(
                                    '<option value="">Pilih Nama Anggota Keluarga</option>'
                                );

                                if (response.rows && response.rows.length > 0) {
                                    $.each(response.rows, function(key, value) {
                                        $jemaatSelect.append(new Option(
                                            value.nama_jemaat,
                                            value.id_jemaat));
                                    });
                                }
                                $jemaatSelect.trigger('change');
                            }
                        });
                    },
                    preConfirm: async () => {
                        const data = {
                            id_keluarga: id_keluarga,
                            id_jemaat: $('#nama_jemaat').val(),
                            nama_anggota: $('#nama_anggota').val(),
                            keterangan_hubungan: $('#hubunganKeluarga').val()
                        };

                        // Validasi input wajib diisi
                        if (!data.id_keluarga) {
                            Swal.showValidationMessage(
                                'Harap isi kolom id keluarga terlebih dahulu!');
                            return false;
                        }

                        if ($('#status').val() == 1 && !data.id_jemaat) {
                            Swal.showValidationMessage(
                                'Harap pilih Nama Jemaat terlebih dahulu!');
                            return false;
                        }

                        if ($('#status').val() == 3 && !data.nama_anggota) {
                            Swal.showValidationMessage(
                                'Harap masukkan Nama Anggota Bukan Jemaat terlebih dahulu!');
                            return false;
                        }

                        if (!data.keterangan_hubungan) {
                            Swal.showValidationMessage(
                                'Harap isi kolom Hubungan Keluarga terlebih dahulu!');
                            return false;
                        }

                        // Validasi 1: Cek apakah anggota keluarga sama dengan kepala keluarga
                        const kepalaResponse = await $.ajax({
                            type: "POST",
                            url: "{{ route('api.get.keluarga') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id_keluarga
                            },
                            dataType: "json"
                        });

                        const keluargaData = kepalaResponse[0];
                        if (keluargaData && keluargaData.kepala_keluarga && keluargaData
                            .kepala_keluarga.id_jemaat == data.id_jemaat) {
                            Swal.showValidationMessage(
                                'Anggota keluarga tidak boleh sama dengan kepala keluarga!');
                            return false;
                        }

                        // Validasi 2: Cek apakah anggota keluarga sudah ada atau hubungan duplikat
                        const anggotaResponse = await $.ajax({
                            type: "POST",
                            url: "{{ route('api.get.anggotakeluarga') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_keluarga: id_keluarga
                            },
                            dataType: "json"
                        });

                        for (const anggota of anggotaResponse) {
                            if (anggota.id_jemaat == data.id_jemaat) {
                                Swal.showValidationMessage('Anggota keluarga sudah ada!');
                                return false;
                            }
                            if (anggota.keterangan_hubungan == data.keterangan_hubungan && data
                                .keterangan_hubungan != 'Anak') {
                                Swal.showValidationMessage(
                                    'Anggota keluarga sudah memiliki hubungan yang sama!');
                                return false;
                            }
                        }

                        return data;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('api.post.anggotakeluarga') }}",
                            type: "POST",
                            data: {
                                ...result.value,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data anggota keluarga berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function() {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data anggota keluarga gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol edit keluarga
            $(document).on('click', '.btn-edit', function(event) {
                event.preventDefault();
                var id = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.get.keluarga') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        const data = response.rows[0];
                        console.log(data);
                        Swal.fire({
                            title: 'Tambah Keluarga Baru',
                            html: `
                                <form id="addKeluargaForm">
                                    <div class="form-group">
                                        <label for="nama_jemaat">Nama Kepala Keluarga *</label>
                                        <select id="nama_jemaat" class="form-control" required style="width: 100%;">
                                            <option value="">Pilih Nama Kepala Keluarga</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="hubunganKeluarga">Hubungan Keluarga</label>
                                        <select id="hubunganKeluarga" class="form-control" >
                                            <option value="Suami">Suami</option>
                                            <option value="Istri">Istri</option>
                                            <option value="Anak">Anak</option>
                                        </select>
                                    </div>
                                <div class="form-group">
                                        <label for="nama_wilayah">Nama Wilayah *</label>
                                        <select id="nama_wilayah" class="form-control" required style="width: 100%;">
                                            <option value="">Pilih Nama Wilayah</option>
                                        </select>
                                    </div>
                                </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            didOpen: () => {
                                $('#nama_wilayah, #nama_jemaat').select2({
                                    placeholder: "Pilih atau cari",
                                    allowClear: true,
                                    dropdownParent: $(
                                        '.swal2-container')
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
                                        $jemaatSelect.empty().append('<option value="">Pilih Nama Jemaat</option>');
                                        $.each(response.rows, function(key, value) {
                                            $jemaatSelect.append(
                                                    new Option(value.nama_jemaat,value.id_jemaat));
                                        });

                                        $jemaatSelect.val(data.id_jemaat);
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
                                            value) {$wilayahSelect.append(new Option(value.nama_wilayah,value.id_wilayah));
                                        });
                                        $wilayahSelect.val(data.id_wilayah);
                                    }
                                });

                                $("#hubunganKeluarga").val(data.keterangan_hubungan);

                            },
                            preConfirm: () => {
                                const data = {
                                    id_wilayah: $('#nama_wilayah').val(),
                                    id_jemaat: $('#nama_jemaat').val(),
                                    keterangan_hubungan: $('#hubunganKeluarga')
                                        .val()
                                };

                                // Validasi input
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
                                    url: "{{ route('api.update.keluarga') }}",
                                    type: "POST",
                                    data: {
                                        ...result.value,
                                        old_id_keluarga: id,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function() {
                                        alert.fire({
                                            icon: 'success',
                                            title: 'Data keluarga berhasil ditambahkan!'
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function() {
                                        alert.fire({
                                            icon: 'error',
                                            title: 'Data keluarga gagal ditambahkan!'
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol tambah keluarga
            $('.tambah-keluarga').on('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tambah Keluarga Baru',
                    html: `
                        <form id="addKeluargaForm">
                            <div class="form-group">
                                <label for="nama_jemaat">Nama Kepala Keluarga *</label>
                                <select id="nama_jemaat" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Kepala Keluarga</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hubunganKeluarga">Hubungan Keluarga</label>
                                <select id="hubunganKeluarga" class="form-control" >
                                    <option value="Suami">Suami</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak">Anak</option>
                                </select>
                            </div>
                           <div class="form-group">
                                <label for="nama_wilayah">Nama Wilayah *</label>
                                <select id="nama_wilayah" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Wilayah</option>
                                </select>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $('#nama_wilayah, #nama_jemaat').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $(
                                '.swal2-container')
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
                                    '<option value="">Pilih Nama Jemaat</option>'
                                );
                                $.each(response.rows, function(key, value) {
                                    $jemaatSelect.append(new Option(value
                                        .nama_jemaat,
                                        value.id_jemaat));
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
                            id_jemaat: $('#nama_jemaat').val(),
                            keterangan_hubungan: $('#hubunganKeluarga').val()
                        };

                        // Validasi input
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
                            url: "{{ route('api.post.keluarga') }}",
                            type: "POST",
                            data: {
                                ...result.value,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data keluarga berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function() {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data keluarga gagal ditambahkan!'
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
                html: `<div class="text-delete">You won't be able to revert this!</div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route('api.delete.keluarga') }}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_keluarga: id
                        },
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data keluarga berhasil dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data keluarga gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        // Event listener untuk tombol delete anggota keluarga
        $(document).on('click', '.btn-delete-anggota', function() {
            event.preventDefault();
            var id_anggota_keluarga = $(this).data('id');

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
                        url: `{{ route('api.delete.anggotakeluarga') }}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_anggota_keluarga: id_anggota_keluarga
                        },
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data anggota keluarga berhasil dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data anggota keluarga gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        function ApiGetKeluarga(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.keluarga') }}",
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
