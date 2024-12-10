@extends('layouts.admin-main-transaksi')

@section('title', 'Transaksi Atestasi Masuk')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table-filter-control.css') }}">
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
            data-filter-control="true" data-ajax="ApiGetAtestasiMasuk">
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
                    field: 'id_masuk',
                    title: 'ID Masuk',
                    align: 'center'
                }, {
                    field: 'nama_jemaat',
                    title: 'Nama',
                    align: 'center'
                }, {
                    field: 'no_surat',
                    title: 'Nomor Surat',
                    align: 'center'
                }, {
                    field: 'nama_wilayah',
                    title: 'Nama Wilayah',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'nama_gereja',
                    title: 'Nama Gereja Asal',
                    align: 'center'
                }, {
                    field: 'tanggal_masuk',
                    title: 'Tanggal Masuk',
                    align: 'center'
                }, {
                    field: 'surat',
                    title: 'Surat',
                    formatter: function(value, row, index) {
                        const fileUrl = `/storage/${value}`;

                        return `
                            <button class="btn btn-primary">
                                <a href="${fileUrl}" target="_blank" style="color:white; text-decoration:none;">Lihat Surat</a>
                            </button>
                        `;
                    },
                    align: 'center'
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
                        title: 'ID Masuk',
                        align: 'center'
                    }, {
                        field: 'nama_jemaat',
                        title: 'Nama',
                        align: 'center'
                    }, {
                        field: 'no_surat',
                        title: 'Nomor Surat',
                        align: 'center'
                    }, {
                        field: 'nama_wilayah',
                        title: 'Nama Wilayah',
                        filterControl: 'select',
                        align: 'center'
                    }, {
                        field: 'nama_gereja',
                        title: 'Nama Gereja Asal',
                        align: 'center'
                    }, {
                        field: 'tanggal_masuk',
                        title: 'Tanggal Masuk',
                        align: 'center'
                    }, {
                        field: 'surat',
                        title: 'Surat',
                        formatter: function(value, row, index) {
                            const fileUrl = `/storage/${value}`;

                            return `
                                <button class="btn btn-primary">
                                    <a href="${fileUrl}" target="_blank" style="color:white; text-decoration:none;">Lihat Surat</a>
                                </button>
                            `;
                        },
                        align: 'center'
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

            // Event listener untuk tombol tambah atestasi masuk
            $('.tambah-atestasi-masuk').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Atestasi Baru',
                    html: `
                <form id="addAtestasiForm">
                    <div class="form-group">
                        <label for="nomor_surat">Nomor Surat *</label>
                        <input type="text" id="nomor_surat" class="form-control" placeholder="Masukkan Nomor Surat" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_masuk">Tanggal Masuk *</label>
                        <input type="date" id="tanggal_masuk" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_gereja">Nama Gereja Asal *</label>
                        <select id="nama_gereja" class="form-control" required>
                            <option value="">Pilih Nama Gereja</option>
                            <!-- AJAX -->
                        </select>
                        <div id="new-gereja-container" style="margin-top: 10px; display: none;">
                            <input type="text" id="new_gereja" class="form-control" placeholder="Masukkan Gereja Baru *">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="surat">Surat *</label>
                        <input type="file" id="surat" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                    </div>
                    <hr>
                    <h3 align="center">Data Jemaat</h3>
                    <div class="form-group">
                        <label for="nama_jemaat">Nama Jemaat *</label>
                        <input type="text" id="nama_jemaat" class="form-control" placeholder="Masukkan Nama Jemaat" required>
                    </div>
                    <div class="form-group">
                            <label for="id_wilayah">Nama Wilayah *</label>
                            <select id="id_wilayah" class="form-control" required>
                                <option value="">Pilih Wilayah</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelamin">Kelamin *</label>
                            <select id="kelamin" class="form-control" required>
                                <option value="" disabled selected>Pilih Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir *</label>
                            <input type="text" id="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir"  required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir *</label>
                            <input type="date" id="tanggal_lahir" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat_jemaat">Alamat *</label>
                            <input type="text" id="alamat_jemaat" class="form-control" placeholder="Masukkan Alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="kodepos">Kode pos</label>
                            <input type="text" id="kodepos" class="form-control" placeholder="Masukkan Kodepos">
                        </div>
                        <div class="form-group">
                            <label for="id_provinsi">Provinsi</label>
                            <select id="id_provinsi" class="form-control">
                                 <option value="">Pilih Nama Provinsi</option>
                                        <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group kabupaten_container" style="display: none;">
                            <label for="id_kabupaten">Kabupaten</label>
                            <select id="id_kabupaten" class="form-control">
                                 <option value="">Pilih Nama Kabupaten</option>
                                        <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group kecamatan_container" style="display: none;">
                            <label for="id_kecamatan">Kecamatan</label>
                            <select id="id_kecamatan" class="form-control">
                                 <option value="">Pilih Nama Kecamatan</option>
                                        <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group kelurahan_container" style="display: none;">
                            <label for="id_kelurahan">Kelurahan</label>
                            <select id="id_kelurahan" class="form-control">
                                 <option value="">Pilih Nama Kelurahan</option>
                                        <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="tel" id="telepon" class="form-control" placeholder="Masukkan Nomor Telepon">
                        </div>
                        <div class="form-group">
                            <label for="hp">HP</label>
                            <input type="tel" id="hp" class="form-control" placeholder="Masukkan Nomor HP">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" placeholder="Masukkan Email">
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" id="nik" class="form-control" placeholder="Masukkan NIK">
                        </div>
                        <div class="form-group">
                            <label for="no_kk">Nomor KK</label>
                            <input type="text" id="no_kk" class="form-control" placeholder="Masukkan Nomor KK">
                        </div>
                        <div class="form-group">
                            <label for="golongan_darah">Golongan Darah</label>
                            <select id="golongan_darah" class="form-control">
                                <option value="-"selected>Pilih Golongan Darah</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pendidikan">Pendidikan Terakhir</label>
                            <select id="pendidikan" class="form-control">
                                <option value="-"selected>Pilih Pendidikan</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ilmu">Bidang Ilmu</label>
                            <input type="text" id="ilmu" class="form-control" placeholder="Masukkan Bidang Ilmu">
                        </div>
                        <div class="form-group">
                            <label for="instansi">Instansi</label>
                            <input type="text" id="instansi" class="form-control" placeholder="Masukkan Instansi">
                        </div>
                         <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" id="pekerjaan" class="form-control" placeholder="Masukkan Pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="penghasilan">Penghasilan</label>
                            <input type="number" id="penghasilan" class="form-control" placeholder="Masukkan Penghasilan" min="0" step="any">
                        </div>
                        <div class="form-group">
                            <label for="alat_transportasi">Alat Transportasi</label>
                            <input type="text" id="alat_transportasi" class="form-control" placeholder="Masukkan Alat Transportasi">
                        </div>
                        <div class="form-group">
                            <label for="stamboek">Stamboek</label>
                            <input type="text" id="stamboek" class="form-control" placeholder="Masukkan Stamboek">
                        </div>
                        <div class="form-group">
                            <label for="gereja_baptis">Gereja Baptis</label>
                            <input type="text" id="gereja_baptis" class="form-control" placeholder="Masukkan Gereja Baptis">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_baptis">Tanggal Baptis</label>
                            <input type="date" id="tanggal_baptis" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="keterangan_status">Status Jemaat *</label>
                            <select id="keterangan_status" class="form-control" required>
                                <option value="">Pilih status</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photo">Foto</label>
                            <input type="file" id="photo" class="form-control" accept="image/jpeg, image/png">
                        </div>
                    </form>
                `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $('#nama_gereja, #id_wilayah').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $('.swal2-container')
                        });

                        $.ajax({
                            url: "{{ route('api.get.status') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $statusDropdown = $('#keterangan_status');
                                $statusDropdown.empty().append(
                                    '<option value="" disabled selected>Pilih Status</option>'
                                    );

                                (response.rows || response).forEach(item => {
                                    $statusDropdown.append(
                                        `<option value="${item.id_status}">${item.keterangan_status}</option>`
                                    );
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error("Error loading status data:", error);
                            }
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
                                Object.entries(response)
                                    .forEach(function([key,
                                        value
                                    ]) {
                                        $gerejaSelect
                                            .append(
                                                `<option value="${value.nama_gereja}">${value.nama_gereja}</option>`
                                            );
                                    });

                                $gerejaSelect.append(
                                    '<option value="add-new-gereja">+ Tambah Gereja Baru</option>'
                                );
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

                        // Load Nama Wilayah
                        $.ajax({
                            url: "{{ route('api.get.wilayah') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $wilayahSelect = $('#id_wilayah');
                                $wilayahSelect.empty().append(
                                    '<option value="">Pilih Nama Wilayah</option>'
                                    );
                                $.each(response, function(key, value) {
                                    $wilayahSelect.append(new Option(value
                                        .nama_wilayah, value
                                        .id_wilayah));
                                });
                            }
                        });

                        $.ajax({
                            url: "{{ route('api.get.daerah') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $idProvinsi = $('#id_provinsi');
                                Object.entries(response.rows).forEach(([key,
                                    value
                                ]) => {
                                    $idProvinsi.append(
                                        `<option value="${value.id_provinsi}">${value.nama_provinsi}</option>`
                                    );
                                });
                            }
                        });

                        $('#id_kecamatan').on('change', function() {
                            const idKecamatan = $('#id_kecamatan').val();
                            const $idKelurahan = $('#id_kelurahan');
                            const $idKabupaten = $('#id_kabupaten');
                            const $idProvinsi = $('#id_provinsi');
                            $('.kelurahan_container').show();

                            if (idKecamatan === '') {
                                $idKelurahan.empty();
                                $('.kelurahan_container').hide();
                                return;
                            }

                            $.ajax({
                                url: "{{ route('api.get.daerah') }}",
                                type: "POST",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id_kecamatan: idKecamatan,
                                    id_kabupaten: $idKabupaten.val(),
                                    id_provinsi: $idProvinsi.val()
                                },
                                dataType: "json",
                                success: function(response) {
                                    $idKelurahan.empty();
                                    $idKelurahan.append(
                                        `<option value="">Pilih Nama Kelurahan</option>`
                                    );
                                    Object.entries(response.rows).forEach(([
                                        key,
                                        value
                                    ]) => {
                                        $idKelurahan.append(
                                            `<option value="${value.id_kelurahan}">${value.kelurahan}</option>`
                                        );
                                    });
                                }
                            });
                        });

                        $('#id_kabupaten').on('change', function() {
                            const idKabupaten = $('#id_kabupaten').val();
                            const idProvinsi = $('#id_provinsi').val();
                            const $idKecamatan = $('#id_kecamatan');
                            $('.kecamatan_container').show();

                            if (idKabupaten === '') {
                                $idKecamatan.empty();
                                $('.kecamatan_container').hide();
                                return;
                            }

                            $.ajax({
                                url: "{{ route('api.get.daerah') }}",
                                type: "POST",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id_kabupaten: idKabupaten,
                                    id_provinsi: idProvinsi
                                },
                                dataType: "json",
                                success: function(response) {
                                    $idKecamatan.empty();
                                    $idKecamatan.append(
                                        `<option value="">Pilih Nama Kecamatan</option>`
                                    );
                                    Object.entries(response.rows).forEach(([
                                        key, value
                                    ]) => {
                                        $idKecamatan.append(
                                            `<option value="${value.id_kecamatan}">${value.kecamatan}</option>`
                                        );
                                    });
                                }
                            });
                        });

                        $('#id_provinsi').on('change', function() {
                            const idProvinsi = $(this).val();
                            const $idKabupaten = $('#id_kabupaten');
                            $('.kabupaten_container').show();

                            if (idProvinsi === '') {
                                $idKabupaten.empty();
                                $('.kabupaten_container').hide();
                                return;
                            }

                            $.ajax({
                                url: "{{ route('api.get.daerah') }}",
                                type: "POST",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id_provinsi: idProvinsi
                                },
                                dataType: "json",
                                success: function(response) {
                                    $idKabupaten.empty();
                                    $idKabupaten.append(
                                        `<option value="">Pilih Nama Kabupaten</option>`
                                    );
                                    Object.entries(response.rows).forEach(([
                                        key, value
                                    ]) => {
                                        $idKabupaten.append(
                                            `<option value="${value.id_kabupaten}">${value.kabupaten}</option>`
                                        );
                                    });
                                }
                            });
                        });

                    },
                    preConfirm: () => {
                        const data = {
                            nomor_surat: $('#nomor_surat').val(),
                            tanggal_masuk: $('#tanggal_masuk').val(),
                            nama_gereja: $('#nama_gereja').val(),
                            new_gereja: $('#new_gereja').val(),
                            nama_jemaat: $('#nama_jemaat').val(),
                            id_wilayah: $('#id_wilayah').val(),
                            surat: $('#surat')[0].files[0],
                            // Jemaat
                            nama_jemaat: $('#nama_jemaat').val(),
                            id_wilayah: $('#id_wilayah').val(),
                            kelamin: $('#kelamin').val(),
                            tanggal_lahir: $('#tanggal_lahir').val(),
                            id_kelurahan: $('#id_kelurahan').val(),
                            id_kecamatan: $('#id_kecamatan').val(),
                            id_kabupaten: $('#id_kabupaten').val(),
                            id_provinsi: $('#id_provinsi').val(),
                            alamat_jemaat: $('#alamat_jemaat').val(),
                            telepon: $('#telepon').val(),
                            hp: $('#hp').val(),
                            email: $('#email').val(),
                            nik: $('#nik').val(),
                            no_kk: $('#no_kk').val(),
                            stamboek: $('#stamboek').val(),
                            kodepos: $('#kodepos').val(),
                            pekerjaan: $('#pekerjaan').val(),
                            ilmu: $('#ilmu').val(),
                            pendidikan: $('#pendidikan').val(),
                            tempat_lahir: $('#tempat_lahir').val(),
                            tanggal_baptis: $('#tanggal_baptis').val(),
                            golongan_darah: $('#golongan_darah').val(),
                            instansi: $('#instansi').val(),
                            penghasilan: $('#penghasilan').val(),
                            gereja_baptis: $('#gereja_baptis').val(),
                            alat_transportasi: $('#alat_transportasi').val(),
                            keterangan_status: $('#keterangan_status').val()
                        };

                        // Validate input
                        if (data.nama_gereja === 'add-new-gereja' && !data.new_gereja) {
                            Swal.showValidationMessage('Masukkan nama gereja baru');
                            return false;
                        }

                        if (!data.nomor_surat || !data.tanggal_masuk || !data.nama_gereja || !
                            data.nama_jemaat || !data.id_wilayah || !data.surat) {
                            Swal.showValidationMessage('Data tidak boleh kosong!');
                            return false;
                        }

                        // Replace `nama_gereja` with `new_gereja` if needed
                        if (data.nama_gereja === 'add-new-gereja') {
                            data.nama_gereja = data.new_gereja;
                        }

                        // Validasi Jemaat
                        const photo = $('#photo')[0].files[0];
                        if (photo) {
                            data.photo = photo;
                        }


                        if (data['nik'].length > 16) {
                            Swal.showValidationMessage(
                                'NIK tidak boleh lebih dari 16 karakter!');
                            return false;
                        }

                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        for (const key in data) {
                            if (data[key] === '' && key !== 'photo' && key !== 'telepon' &&
                                key !== 'hp' && key !== 'email' && key !== 'nik' && key !==
                                'no_kk' && key !== 'stamboek' && key !== 'tempat_lahir' &&
                                key !== 'tanggal_baptis' && key !== 'instansi' && key !==
                                'gereja_baptis' && key !== 'alat_transportasi' && key !==
                                'penghasilan' && key !== 'golongan_darah' && key !==
                                'pekerjaan' &&
                                key !== 'pendidikan' && key !== 'ilmu' && key !== 'kodepos' &&
                                key !== 'id_kelurahan' &&
                                key !== 'id_kecamatan' && key !== 'id_kabupaten' && key !==
                                'id_provinsi' && key !== 'new_gereja') {
                                Swal.showValidationMessage(
                                    `${key.replace(/_/g, ' ')} tidak boleh kosong!`);
                                return false;
                            }
                            if (key === 'email' && data[key] !== '' && !emailRegex.test(data[
                                    key])) {
                                Swal.showValidationMessage('Format email tidak valid!');
                                return false;
                            }
                        }

                        return new Promise((resolve, reject) => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.get.jemaat') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    nama_jemaat: data.nama_jemaat,
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.total > 0) {
                                        reject(
                                            'Nama Jemaat sudah ada, silahkan gunakan Nama lain!'
                                        );
                                    } else {
                                        resolve(data);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    reject(
                                        'Terjadi kesalahan saat memvalidasi Nama.'
                                    );
                                }
                            });
                        }).catch(error => {
                            Swal.showValidationMessage(error);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formdata = new FormData();
                        formdata.append('nomor_surat', result.value.nomor_surat);
                        formdata.append('tanggal_masuk', result.value.tanggal_masuk);
                        formdata.append('nama_gereja', result.value.nama_gereja);
                        formdata.append('new_gereja', result.value.new_gereja)
                        formdata.append('surat', result.value.surat);
                        formdata.append('nama_jemaat', result.value.nama_jemaat);
                        formdata.append('id_wilayah', result.value.id_wilayah);
                        formdata.append('kelamin', result.value.kelamin);
                        formdata.append('tanggal_lahir', result.value.tanggal_lahir);
                        formdata.append('id_kelurahan', result.value.id_kelurahan);
                        formdata.append('id_kecamatan', result.value.id_kecamatan);
                        formdata.append('id_kabupaten', result.value.id_kabupaten);
                        formdata.append('id_provinsi', result.value.id_provinsi);
                        formdata.append('alamat_jemaat', result.value.alamat_jemaat);
                        formdata.append('telepon', result.value.telepon);
                        formdata.append('hp', result.value.hp);
                        formdata.append('email', result.value.email);
                        formdata.append('nik', result.value.nik);
                        formdata.append('no_kk', result.value.no_kk);
                        formdata.append('stamboek', result.value.stamboek);
                        formdata.append('kodepos', result.value.kodepos);
                        formdata.append('pekerjaan', result.value.pekerjaan);
                        formdata.append('ilmu', result.value.ilmu);
                        formdata.append('pendidikan', result.value.pendidikan);
                        formdata.append('tempat_lahir', result.value.tempat_lahir);
                        formdata.append('tanggal_baptis', result.value.tanggal_baptis);
                        formdata.append('golongan_darah', result.value.golongan_darah);
                        formdata.append('instansi', result.value.instansi);
                        formdata.append('penghasilan', result.value.penghasilan);
                        formdata.append('gereja_baptis', result.value.gereja_baptis);
                        formdata.append('alat_transportasi', result.value.alat_transportasi);
                        formdata.append('keterangan_status', result.value.keterangan_status);
                        if (result.value.photo) formdata.append('photo', result.value.photo);
                        formdata.append('_token', '{{ csrf_token() }}');
                        $.ajax({
                            url: "{{ route('api.post.atestasimasuk') }}",
                            type: "POST",
                            data: formdata,
                            contentType: false,
                            processData: false,
                            success: function() {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data atestasi masuk berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function() {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data atestasi masuk gagal ditambahkan!'
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
                        var nama_jemaat = response.rows[0].nama_jemaat;


                        Swal.fire({
                            title: 'Edit Atestasi Masuk',
                            html: `
                                <form id="addAtestasiMasukForm">
                                    <div class="form-group">
                                        <label for="no_surat">Nomor Surat *</label>
                                        <input type="text" id="no_surat" class="form-control" placeholder="Masukkan Nomor Surat *" value="${response.rows[0].no_surat}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_jemaat">Nama Jemaat Baru *</label>
                                        <input type="text" id="nama_jemaat" class="form-control" placeholder="Masukkan Nama Jemaat Baru *" value="${response.rows[0].nama_jemaat}" required>
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
                                        <label for="tanggal_masuk">Tanggal *</label>
                                        <input type="date" id="tanggal_masuk" class="form-control" value="${response.rows[0].tanggal}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="surat">Surat</label>
                                        ${response.surat_url ? `<a href="${response.surat_url}" target="_blank" class="btn btn-secondary mb-2 btn-sm">Lihat File surat yang Sudah Ada</a>` : ''}
                                        <input type="file" id="surat" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
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
                                    nama_jemaat: $('#nama_jemaat').val(),
                                    id_wilayah: $('#nama_wilayah').val(),
                                    nama_gereja: $('#nama_gereja').val(),
                                    new_gereja: $('#new_gereja').val(),
                                    tanggal_masuk: $('#tanggal_masuk').val(),
                                    surat: $('#surat')[0].files[0]
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
                                if (!data.no_surat || !data.nama_gereja || !data.id_wilayah || !data.tanggal_masuk) {
                                    Swal.showValidationMessage('Data tidak boleh kosong!');
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
