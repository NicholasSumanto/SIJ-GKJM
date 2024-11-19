@extends('layouts.admin-wilayah-main-data')

@section('title', 'Anggota Jemaat')

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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Daftar Jemaat</li>
            </ol>
        </nav>
        <a href="" class="btn btn-success tambah-jemaat">Tambah Jemaat</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-filter-control="true" data-ajax="ApiGetJemaat">
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
                    field: 'nama_wilayah',
                    title: 'Wilayah',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'kelamin',
                    title: 'Kelamin',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'keterangan_status',
                    title: 'Status',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'golongan_darah',
                    title: 'Darah',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'nama_pendidikan',
                    title: 'Pendidikan',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'view',
                    title: 'View',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-success btn-view" data-id_jemaat="${row.id_jemaat} data-validasi="${row.validasi}">View</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id_jemaat="${row.id_jemaat} data-validasi="${row.validasi}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColumn: [7, 8, 9]
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
                        field: 'nama_wilayah',
                        title: 'Wilayah',
                        filterControl: 'select',
                        align: 'center'
                    }, {
                        field: 'kelamin',
                        title: 'Kelamin',
                        filterControl: 'select',
                        align: 'center'
                    }, {
                        field: 'keterangan_status',
                        title: 'Status',
                        filterControl: 'select',
                        align: 'center'
                    }, {
                        field: 'golongan_darah',
                        title: 'Darah',
                        filterControl: 'select',
                        align: 'center'
                    }, {
                        field: 'nama_pendidikan',
                        title: 'Pendidikan',
                        filterControl: 'select',
                        align: 'center'
                    }, {
                        field: 'view',
                        title: 'View',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-success btn-view" data-id_jemaat="${row.id_jemaat}" data-validasi="${row.validasi}">View</button>`;
                        },
                        align: 'center'

                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id_jemaat="${row.id_jemaat}" data-validasi="${row.validasi}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [6, 7, 8]
                    }
                });
            }).trigger('change');

            $(document).on('click', '.btn-view', function(event) {
                event.preventDefault();

                var id_jemaat = $(this).data('id_jemaat');
                var validasi = $(this).data('validasi');

                // Membangun URL secara manual
                var url = `/admin-wilayah/data/anggota-jemaat/${id_jemaat}/${validasi}`;
                window.location.href = url;
            });

            // Event listener untuk tombol tambah jemaat
            $('.tambah-jemaat').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Jemaat Baru',
                    html: `
                        <form id="addJemaatForm">
                            <div class="form-group">
                                <label for="nama_jemaat">Nama Jemaat *</label>
                                <input type="text" id="nama_jemaat" class="form-control" placeholder="Masukkan Nama Jemaat" required>
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
                                <label for="tanggal_lahir">Tanggal Lahir *</label>
                                <input type="date" id="tanggal_lahir" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat_jemaat">Alamat *</label>
                                <input type="text" id="alamat_jemaat" class="form-control" placeholder="Masukkan Alamat" required>
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
                                <label for="stamboek">Stamboek</label>
                                <input type="text" id="stamboek" class="form-control" placeholder="Masukkan Stamboek">
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" id="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_baptis">Tanggal Baptis</label>
                                <input type="date" id="tanggal_baptis" class="form-control">
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
                                <label for="instansi">Instansi</label>
                                <input type="text" id="instansi" class="form-control" placeholder="Masukkan Instansi">
                            </div>
                            <div class="form-group">
                                <label for="penghasilan">Penghasilan</label>
                                <input type="number" id="penghasilan" class="form-control" placeholder="Masukkan Penghasilan" min="0" step="any">
                            </div>
                            <div class="form-group">
                                <label for="gereja_baptis">Gereja Baptis</label>
                                <input type="text" id="gereja_baptis" class="form-control" placeholder="Masukkan Gereja Baptis">
                            </div>
                            <div class="form-group">
                                <label for="alat_transportasi">Alat Transportasi</label>
                                <input type="text" id="alat_transportasi" class="form-control" placeholder="Masukkan Alat Transportasi">
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
                            _token: '{{ csrf_token() }}',
                            nama_jemaat: $('#nama_jemaat').val(),
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
                            tempat_lahir: $('#tempat_lahir').val(),
                            tanggal_baptis: $('#tanggal_baptis').val(),
                            golongan_darah: $('#golongan_darah').val(),
                            instansi: $('#instansi').val(),
                            penghasilan: $('#penghasilan').val(),
                            gereja_baptis: $('#gereja_baptis').val(),
                            alat_transportasi: $('#alat_transportasi').val(),

                        };

                        const photo = $('#photo')[0].files[0];
                        if (photo) {
                            data.photo = photo;
                        }

                        // Validasi input
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        for (const key in data) {
                            if (data[key] === '' && key !== 'photo' && key !== 'telepon' &&
                                key !== 'hp' && key !== 'email' && key !== 'nik' && key !==
                                'no_kk' && key !== 'stamboek' && key !== 'tempat_lahir' &&
                                key !== 'tanggal_baptis' && key !== 'instansi' && key !==
                                'gereja_baptis' && key !== 'alat_transportasi' && key !==
                                'penghasilan' && key !== 'golongan_darah' &&
                                key !== 'id_kelurahan' && key !== 'id_kecamatan' && key !==
                                'id_kabupaten' && key !== 'id_provinsi' && key !== 'photo') {
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
                                            'NIK sudah ada, silahkan gunakan NIK lain!'
                                        );
                                    } else {
                                        resolve(data);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    reject(
                                        'Terjadi kesalahan saat memvalidasi NIK.'
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
                            nama_jemaat,
                            kelamin,
                            tanggal_lahir,
                            alamat_jemaat,
                            id_kelurahan,
                            id_kecamatan,
                            id_kabupaten,
                            id_provinsi,
                            telepon,
                            hp,
                            email,
                            nik,
                            no_kk,
                            stamboek,
                            tempat_lahir,
                            tanggal_baptis,
                            golongan_darah,
                            instansi,
                            penghasilan,
                            gereja_baptis,
                            alat_transportasi,
                            photo
                        } = result.value;

                        const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('id_role', {{ Auth::user()->id_role }});
                        formData.append('nama_jemaat', nama_jemaat);
                        formData.append('kelamin', kelamin);
                        formData.append('tanggal_lahir', tanggal_lahir);
                        formData.append('id_kelurahan', id_kelurahan);
                        formData.append('id_kecamatan', id_kecamatan);
                        formData.append('id_kabupaten', id_kabupaten);
                        formData.append('id_provinsi', id_provinsi);
                        formData.append('alamat_jemaat', alamat_jemaat);
                        formData.append('telepon', telepon);
                        formData.append('hp', hp);
                        formData.append('email', email);
                        formData.append('nik', nik);
                        formData.append('no_kk', no_kk);
                        formData.append('stamboek', stamboek);
                        formData.append('tempat_lahir', tempat_lahir);
                        formData.append('tanggal_baptis', tanggal_baptis);
                        formData.append('golongan_darah', golongan_darah);
                        formData.append('instansi', instansi);
                        formData.append('penghasilan', penghasilan);
                        formData.append('gereja_baptis', gereja_baptis);
                        formData.append('alat_transportasi', alat_transportasi);
                        if (photo) {
                            formData.append('photo', photo);
                        }

                        $.ajax({
                            url: "{{ route('api.post.daerah.jemaat') }}",
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data jemaat berhasil ditambahkan'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data jemaat gagal ditambahkan'
                                });
                            }
                        });
                    }
                });
            });
        });

        $(document).on('click', '.btn-delete', function(event) {
            event.preventDefault();
            var id_jemaat = $(this).data('id_jemaat');
            var validasi = $(this).data('validasi');

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
                        type: "POST",
                        url: "{{ route('api.delete.jemaat') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_jemaat: id_jemaat,
                            validasi: validasi
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Jemaat berhasil dihapus!'
                            });
                            $table.bootstrapTable(
                                'refresh');
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Data Jemaat gagal dihapus!',
                                text: xhr.responseJSON.message ||
                                    'Terjadi kesalahan saat menghapus data.' // Menampilkan pesan error dari server jika ada
                            });
                        }
                    });
                }
            });
        });

        function ApiGetJemaat(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.jemaat') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_role: '{{ Auth::user()->id_role }}'
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

        function ApiGetJemaatById(id_jemaat, params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.jemaat.by.id', ['id_jemaat' => '__ID__']) }}".replace('__ID__',
                    id_jemaat), // Ganti __ID__ dengan id_jemaat
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
