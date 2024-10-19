@extends('layouts.admin-main-data')

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
                <li class="breadcrumb-item" aria-current="page"><a href="#">Daftar Jemaat</a></li>
                <li class="breadcrumb-item active">Detail Jemaat (xxxx)</li>
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
                        return `<button class="btn btn-success btn-view" data-id_jemaat="${row.id_jemaat}">View</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-edit" data-id_jemaat="${row.id_jemaat}" data-name="${row.name}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id_jemaat="${row.id_jemaat}">Delete</button>`;
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
                    },  {
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
                            return `<button class="btn btn-success btn-view" data-id_jemaat="${row.id_jemaat}">View</button>`;
                        },
                        align: 'center'

                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-primary btn-edit" data-id_jemaat="${row.id_jemaat}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id_jemaat="${row.id_jemaat}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumn: [6, 7, 8]
                    }
                });
            }).trigger('change');

            $(document).on('click', '.btn-view', function() {
                var id_jemaat = $(this).data('id_jemaat');

                ApiGetJemaatById(id_jemaat, {
                    success: function(data) {
                        // Membuat form untuk menampilkan detail jemaat
                        var formHtml = `
                <form id="jemaatDetailForm">
                    <div class="form-group">
                        <label for="id_jemaat">ID Jemaat:</label>
                        <input type="text" id="id_jemaat" class="form-control" value="${data.id_jemaat}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_jemaat">Nama Jemaat:</label>
                        <input type="text" id="nama_jemaat" class="form-control" value="${data.nama_jemaat}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_wilayah">Wilayah:</label>
                        <input type="text" id="nama_wilayah" class="form-control" value="${data.nama_wilayah || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_status">Status:</label>
                        <input type="text" id="keterangan_status" class="form-control" value="${data.keterangan_status || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nomor">Nomor Nikah:</label>
                        <input type="text" id="nomor" class="form-control" value="${data.nomor || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="stamboek">Stamboek:</label>
                        <input type="text" id="stamboek" class="form-control" value="${data.stamboek}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_baptis">Tanggal Baptis:</label>
                        <input type="text" id="tanggal_baptis" class="form-control" value="${data.tanggal_baptis}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir:</label>
                        <input type="text" id="tempat_lahir" class="form-control" value="${data.tempat_lahir}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir:</label>
                        <input type="text" id="tanggal_lahir" class="form-control" value="${data.tanggal_lahir}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kelamin">Kelamin:</label>
                        <input type="text" id="kelamin" class="form-control" value="${data.kelamin}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat:</label>
                        <input type="text" id="alamat" class="form-control" value="${data.alamat_jemaat}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_kelurahan">Kelurahan:</label>
                        <input type="text" id="nama_kelurahan" class="form-control" value="${data.nama_kelurahan || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_kecamatan">Kecamatan:</label>
                        <input type="text" id="nama_kecamatan" class="form-control" value="${data.nama_kecamatan || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_kabupaten">Kabupaten:</label>
                        <input type="text" id="nama_kabupaten" class="form-control" value="${data.nama_kabupaten || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_provinsi">Provinsi:</label>
                        <input type="text" id="nama_provinsi" class="form-control" value="${data.nama_provinsi || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kode_pos">Kode Pos:</label>
                        <input type="text" id="kode_pos" class="form-control" value="${data.kodepos || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon:</label>
                        <input type="text" id="telepon" class="form-control" value="${data.telepon}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="hp">HP:</label>
                        <input type="text" id="hp" class="form-control" value="${data.hp}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" class="form-control" value="${data.email}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK:</label>
                        <input type="text" id="nik" class="form-control" value="${data.nik}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="no_kk">No KK:</label>
                        <input type="text" id="no_kk" class="form-control" value="${data.no_kk}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="golongan_darah">Golongan Darah:</label>
                        <input type="text" id="golongan_darah" class="form-control" value="${data.golongan_darah}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pendidikan">Pendidikan:</label>
                        <input type="text" id="nama_pendidikan" class="form-control" value="${data.nama_pendidikan}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="bidangilmu">Bidang Ilmu:</label>
                        <input type="text" id="ilmu" class="form-control" value="${data.bidang_ilmu || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan:</label>
                        <input type="text" id="pekerjaan" class="form-control" value="${data.pekerjaan || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="instansi">Instansi:</label>
                        <input type="text" id="instansi" class="form-control" value="${data.instansi}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="penghasilan">Penghasilan:</label>
                        <input type="text" id="penghasilan" class="form-control" value="${data.penghasilan}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="gereja_baptis">Gereja Baptis:</label>
                        <input type="text" id="gereja_baptis" class="form-control" value="${data.gereja_baptis || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="alat_transportasi">Alat Transportasi:</label>
                        <input type="text" id="alat_transportasi" class="form-control" value="${data.alat_transportasi || 'N/A'}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="photo">Foto:</label>
                        <br>
                        <img src="${data.photo}" alt="Jemaat Photo" style="width: 300px; margin-top: 10px;">
                    </div>
                </form>
            `;

                        Swal.fire({
                            title: `${data.nama_jemaat}`,
                            html: formHtml,
                            showCloseButton: true,
                            confirmButtonText: 'Tutup'
                        });
                    }
                });
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
                            <label for="id_wilayah">Wilayah *</label>
                            <input type="text" id="id_wilayah" class="form-control" placeholder="Masukkan ID Wilayah" required>
                        </div>
                        <div class="form-group">
                            <label for="kelamin">Kelamin *</label>
                            <select id="kelamin" class="form-control" required>
                                <option value="" disabled selected>Pilih Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
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
                            <label for="golongan_darah">Golongan Darah *</label>
                            <select id="golongan_darah" class="form-control" required>
                                <option value="" disabled selected>Pilih Golongan Darah</option>
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
                            <label for="penghasilan">Penghasilan *</label>
                            <input type="number" id="penghasilan" class="form-control" placeholder="Masukkan Penghasilan" min="0" step="any" required>
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
                    preConfirm: () => {
                        const data = {
                            _token: '{{ csrf_token() }}',
                            nama_jemaat: $('#nama_jemaat').val(),
                            id_wilayah: $('#id_wilayah').val(),
                            kelamin: $('#kelamin').val(),
                            tanggal_lahir: $('#tanggal_lahir').val(),
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

                        // Validate required fields
                        for (const key in data) {
                            if (data[key] === '' && key !== 'photo') {
                                Swal.showValidationMessage(
                                    `${key.replace(/_/g, ' ')} tidak boleh kosong!`);
                                return false;
                            }
                        }

                        return data;
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value) {
                        $.ajax({
                            url: "{{ route('api.post.jemaat') }}",
                            type: 'POST',
                            data: result.value,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.message) {
                                    Swal.fire('Gagal!', response.message, 'error');
                                } else {
                                    Swal.fire('Berhasil!',
                                        'Jemaat berhasil ditambahkan!', 'success');
                                    $table.bootstrapTable('refresh');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', 'Jemaat gagal ditambahkan!',
                                    'error');
                            }
                        });
                    }
                });
            });



            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function(event) {
                event.preventDefault();
                var id_jemaat = $(this).data('id_jemaat');
                ApiGetJemaatById(id_jemaat, {
                    success: function(data) {
                        Swal.fire({
                            title: 'Edit Jemaat',
                            html: `
                                <form id="editForm">
                                    <div class="form-group">
                                        <label for="id_jemaat">ID Jemaat:</label>
                                        <input type="text" id="id_jemaat" class="form-control" value="${data.id_jemaat}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_jemaat">Nama Jemaat:</label>
                                        <input type="text" id="nama_jemaat" class="form-control" value="${data.nama_jemaat}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="wilayah">Wilayah:</label>
                                        <input type="text" id="wilayah" class="form-control" value="${data.nama_wilayah || 'N/A'}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status:</label>
                                        <input type="text" id="status" class="form-control" value="${data.keterangan_status || 'N/A'}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="stamboek">Stamboek:</label>
                                        <input type="text" id="stamboek" class="form-control" value="${data.stamboek}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir:</label>
                                        <input type="text" id="tempat_lahir" class="form-control" value="${data.tempat_lahir}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir:</label>
                                        <input type="text" id="tanggal_lahir" class="form-control" value="${data.tanggal_lahir}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="kelamin">Kelamin:</label>
                                        <input type="text" id="kelamin" class="form-control" value="${data.kelamin}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat:</label>
                                        <input type="text" id="alamat" class="form-control" value="${data.alamat_jemaat}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan:</label>
                                        <input type="text" id="kecamatan" class="form-control" value="${data.nama_kecamatan || 'N/A'}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="kabupaten">Kabupaten:</label>
                                        <input type="text" id="kabupaten" class="form-control" value="${data.nama_kabupaten || 'N/A'}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi:</label>
                                        <input type="text" id="provinsi" class="form-control" value="${data.nama_provinsi || 'N/A'}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="kode_pos">Kode Pos:</label>
                                        <input type="text" id="kode_pos" class="form-control" value="${data.kodepos || 'N/A'}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" id="email" class="form-control" value="${data.email}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="telepon">Telepon:</label>
                                        <input type="text" id="telepon" class="form-control" value="${data.telepon}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Foto:</label>
                                        <br>
                                        <img src="${data.photo}" alt="Jemaat Photo" style="width: 300px; margin-top: 10px;">
                                    </div>
                        </form>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            preConfirm: () => {

                                const nama_jemaat = $('#nama_jemaat').val();
                                const id_wilayah = $('#id_wilayah').val();
                                const kelamin = $('#kelamin').val();
                                const tanggal_lahir = $('#tanggal_lahir').val();
                                const alamat_jemaat = $('#alamat_jemaat').val();
                                const telepon = $('#telepon').val();
                                const hp = $('#hp').val();
                                const email = $('#email').val();
                                const nik = $('#nik').val();
                                const no_kk = $('#no_kk').val();
                                const stamboek = $('#stamboek').val();
                                const tempat_lahir = $('#tempat_lahir').val();
                                const tanggal_baptis = $('#tanggal_baptis').val();
                                const golongan_darah = $('#golongan_darah').val();
                                const instansi = $('#instansi').val();
                                const penghasilan = $('#penghasilan').val();
                                const gereja_baptis = $('#gereja_baptis').val();
                                const alat_transportasi = $('#alat_transportasi')
                                    .val();


                                return {
                                    id_jemaat: id_jemaat,
                                    nama_jemaat: nama_jemaat,
                                    id_wilayah: id_wilayah,
                                    kelamin: kelamin,
                                    tanggal_lahir: tanggal_lahir,
                                    alamat_jemaat: alamat_jemaat,
                                    telepon: telepon,
                                    hp: hp,
                                    email: email,
                                    nik: nik,
                                    no_kk: no_kk,
                                    stamboek: stamboek,
                                    tempat_lahir: tempat_lahir,
                                    tanggal_baptis: tanggal_baptis,
                                    golongan_darah: golongan_darah,
                                    instansi: instansi,
                                    penghasilan: penghasilan,
                                    gereja_baptis: gereja_baptis,
                                    alat_transportasi: alat_transportasi
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Mengupdate data menggunakan AJAX
                                $.ajax({
                                    url: "{{ route('api.update.jemaat') }}", // Ganti dengan endpoint yang sesuai
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id_jemaat: id_jemaat,
                                        nama_jemaat: result.value.nama_jemaat,
                                        id_wilayah: result.value.id_wilayah,
                                        kelamin: result.value.kelamin,
                                        tanggal_lahir: result.value
                                            .tanggal_lahir,
                                        alamat_jemaat: result.value
                                            .alamat_jemaat,
                                        telepon: result.value.telepon,
                                        hp: result.value.hp,
                                        email: result.value.email,
                                        nik: result.value.nik,
                                        no_kk: result.value.no_kk,
                                        stamboek: result.value.stamboek,
                                        tempat_lahir: result.value.tempat_lahir,
                                        tanggal_baptis: result.value
                                            .tanggal_baptis,
                                        golongan_darah: result.value
                                            .golongan_darah,
                                        instansi: result.value.instansi,
                                        penghasilan: result.value.penghasilan,
                                        gereja_baptis: result.value
                                            .gereja_baptis,
                                        alat_transportasi: result.value
                                            .alat_transportasi
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Data jemaat berhasil diubah!'
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function(xhr, status, error) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Data jemaat gagal diupdate!',
                                            text: xhr.responseText
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });

        $(document).on('click', '.btn-delete', function(event) {
            event.preventDefault();
            var id_jemaat = $(this).data('id_jemaat'); // Mengambil ID jemaat dari data atribut

            console.log("ID Jemaat yang akan dihapus:", id_jemaat); // Memastikan ID jemaat yang akan dihapus

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
                        url: "{{ route('api.delete.jemaat') }}", // Pastikan ini adalah rute yang benar untuk menghapus jemaat
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_jemaat: id_jemaat
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Jemaat berhasil dihapus!'
                            });
                            $table.bootstrapTable(
                            'refresh'); // Segarkan tabel setelah penghapusan
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
