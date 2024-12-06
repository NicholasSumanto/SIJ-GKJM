@extends('layouts.admin-main-data')

@section('title', 'Detail Jemaat')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
    <style>
        .biodata-title {
            background-color: #d9edf7;
            padding: 10px;
            font-weight: bold;
        }

        th {
            font-weight: normal;
        }
    </style>
@endpush

@section('content')
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.data.anggota-jemaat') }}">Daftar
                        Jemaat</a></li>
                <li class="breadcrumb-item active">Detail Jemaat ({{ $jemaat->nama_jemaat }})</li>
            </ol>
        </nav>
        <a href="" class="btn btn-success tambah-jemaat">Eksport Jemaat</a>
        <button class="btn btn-warning btn-edit" style="color: white;" data-id="{{ $jemaat->id_jemaat }}">Edit
            Jemaat</button>

        <div class="biodata-title mt-4">Biodata</div>
        <div style="overflow-x: auto; width: 100%;">
            <table class="table table-bordered table-striped" style="width: 100%;">
                <tr>
                    <th>ID Jemaat</th>
                    <td>{{ $jemaat->id_jemaat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nama Jemaat</th>
                    <td>{{ $jemaat->nama_jemaat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Wilayah</th>
                    <td>{{ $jemaat->wilayah['nama_wilayah'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $jemaat->kelamin ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tempat Lahir</th>
                    <td>{{ $jemaat->tempat_lahir ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>{{ $jemaat->tanggal_lahir ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $jemaat->alamat_jemaat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kodepos</th>
                    <td>{{ $jemaat->kodepos ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Provinsi</th>
                    <td>{{ $jemaat->nama_provinsi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kabupaten</th>
                    <td>{{ $jemaat->nama_kabupaten ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kecamatan</th>
                    <td>{{ $jemaat->nama_kecamatan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kelurahan</th>
                    <td>{{ $jemaat->nama_kelurahan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No. Telepon</th>
                    <td>{{ $jemaat->telepon ?? '-' }}</td>
                </tr>
                <tr>
                    <th>HP</th>
                    <td>{{ $jemaat->hp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $jemaat->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>NIK</th>
                    <td>{{ $jemaat->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No KK</th>
                    <td>{{ $jemaat->no_kk ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Golongan Darah</th>
                    <td>{{ $jemaat->golongan_darah ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Pendidikan</th>
                    <td>{{ $jemaat->pendidikan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Bidang Ilmu</th>
                    <td>{{ $jemaat->ilmu ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Instansi</th>
                    <td>{{ $jemaat->instansi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Pekerjaan</th>
                    <td>{{ $jemaat->pekerjaan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Penghasilan</th>
                    <td>{{ $jemaat->penghasilan !== null ? number_format($jemaat->penghasilan, 0, ',', '.') : '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Alat Transportasi</th>
                    <td>{{ $jemaat->alat_transportasi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Stamboek</th>
                    <td>{{ $jemaat->stamboek ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Gereja Baptis</th>
                    <td>{{ $jemaat->gereja_baptis ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Baptis</th>
                    <td>{{ $jemaat->tanggal_baptis ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $jemaat->status['keterangan_status'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>
                        Photo <br>
                        @if ($jemaat->photo_url !== null)
                            <a href="{{ $jemaat->photo_url }}" target="_blank" class="btn btn-secondary mb-2 btn-sm">Lihat
                                Detail Foto</a>
                        @endif
                    </th>
                    <td>
                        @if ($jemaat->photo_url !== null)
                            <img src="{{ $jemaat->photo_url }}" alt="Foto Jemaat" width="200">
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </table>
        </div>
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
        $(document).ready(function() {
            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function(event) {
                event.preventDefault();
                var id_jemaat = $(this).data('id');
                ApiGetJemaatById(id_jemaat, {
                    success: function(data) {
                        var old_nama_jemaat = data.nama_jemaat;
                        Swal.fire({
                            title: 'Edit Jemaat ',
                            html: `
                                <form id="addJemaatForm">
                                <div class="form-group">
                                    <label for="nama_jemaat">Nama Jemaat *</label>
                                    <input type="text" id="nama_jemaat" class="form-control" placeholder="Masukkan Nama Jemaat" required value="${data.nama_jemaat}">
                                </div>
                                <div class="form-group">
                                    <label for="id_wilayah">Nama Wilayah *</label>
                                    <select id="id_wilayah" class="form-control" required>
                                        <option value="">Pilih Wilayah</option>
                                        <!-- AJAX -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kelamin">Jenis Kelamin *</label>
                                    <select id="kelamin" class="form-control" required>
                                        <option value="" disabled selected>Pilih Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" id="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir" value="${data.tempat_lahir ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir *</label>
                                    <input type="date" id="tanggal_lahir" class="form-control" value="${data.tanggal_lahir ?? ''}" required>
                                </div>
                                 <div class="form-group">
                                    <label for="alamat_jemaat">Alamat</label>
                                    <input type="text" id="alamat_jemaat" class="form-control" placeholder="Masukkan Alamat" value="${data.alamat_jemaat ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="kodepos">Kode pos</label>
                                    <input type="text" id="kodepos" class="form-control" placeholder="Masukkan Kodepos" value="${data.kodepos ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat_jemaat">Alamat</label>
                                    <input type="text" id="alamat_jemaat" class="form-control" placeholder="Masukkan Alamat" value="${data.alamat_jemaat ?? ''}">
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
                                    <input type="tel" id="telepon" class="form-control" placeholder="Masukkan Nomor Telepon" value="${data.telepon ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="hp">HP</label>
                                    <input type="tel" id="hp" class="form-control" placeholder="Masukkan Nomor HP" value="${data.hp ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" class="form-control" placeholder="Masukkan Email" value="${data.email ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" id="nik" class="form-control" placeholder="Masukkan NIK" value="${data.nik ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="no_kk">Nomor KK</label>
                                    <input type="text" id="no_kk" class="form-control" placeholder="Masukkan Nomor KK" value="${data.no_kk ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="golongan_darah">Golongan Darah</label>
                                    <select id="golongan_darah" class="form-control">
                                        <option value="-" selected>Pilih Golongan Darah</option>
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
                                    <input type="text" id="ilmu" class="form-control" placeholder="Masukkan Bidang Ilmu" value="${data.ilmu ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="instansi">Instansi</label>
                                    <input type="text" id="instansi" class="form-control" placeholder="Masukkan Instansi" value="${data.instansi ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" id="pekerjaan" class="form-control" placeholder="Masukkan Pekerjaan" value="${data.pekerjaan ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="penghasilan">Penghasilan</label>
                                    <input type="number" id="penghasilan" class="form-control" placeholder="Masukkan Penghasilan" min="0" step="any" value="${data.penghasilan ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="alat_transportasi">Alat Transportasi</label>
                                    <input type="text" id="alat_transportasi" class="form-control" placeholder="Masukkan Alat Transportasi" value="${data.alat_transportasi ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="stamboek">Stamboek</label>
                                    <input type="text" id="stamboek" class="form-control" placeholder="Masukkan Stamboek" value="${data.stamboek ?? ''}">
                                </div>
                                 <div class="form-group">
                                    <label for="gereja_baptis">Gereja Baptis</label>
                                    <input type="text" id="gereja_baptis" class="form-control" placeholder="Masukkan Gereja Baptis" value="${data.gereja_baptis ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_baptis">Tanggal Baptis</label>
                                    <input type="date" id="tanggal_baptis" class="form-control" value="${data.tanggal_baptis ?? ''}">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan_status">Status Jemaat *</label>
                                    <select id="keterangan_status" class="form-control">
                                        <option value="">Pilih status</option>
                                        <!-- AJAX -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Foto</label>
                                    ${data.photo_url ? `<a href="${data.photo_url}" target="_blank" class="btn btn-secondary mb-2 btn-sm">Lihat Foto yang Sudah Ada</a>` : ''}
                                    <input type="file" id="photo" class="form-control" accept="image/jpeg, image/png">
                                </div>
                            </form>

                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            didOpen: () => {
                                // Mengisi data kelamin dan golongan darah
                                $('#kelamin').val(data.kelamin);
                                $('#golongan_darah').val(data.golongan_darah);
                                $('#pendidikan').val(data.pendidikan);

                                // Load data status
                                $.ajax({
                                    url: "{{ route('api.get.status') }}",
                                    type: "POST",
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        const $statusDropdown = $(
                                            '#keterangan_status');
                                        $statusDropdown.empty().append(
                                            '<option value="">Pilih Status</option>'
                                            );

                                        (response.rows || response)
                                        .forEach(item => {
                                            $statusDropdown
                                                .append(
                                                    `<option value="${item.id_status}">${item.keterangan_status}</option>`
                                                );
                                        });

                                        $('#keterangan_status').val(data
                                            .id_status);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(
                                            "Error loading status data:",
                                            error);
                                    }
                                });

                                // Load data wilayah
                                $.ajax({
                                    url: "{{ route('api.get.wilayah') }}",
                                    type: "POST",
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        const $idWilayah = $(
                                            '#id_wilayah').empty();
                                        $idWilayah.append(
                                            '<option value="">Pilih Wilayah</option>'
                                        );
                                        response.forEach((item) => {
                                            $idWilayah.append(
                                                `<option value="${item.id_wilayah}">${item.nama_wilayah}</option>`
                                            );
                                        });
                                        $idWilayah.val(data.id_wilayah);
                                    }
                                });

                                // Load data provinsi
                                $.ajax({
                                    url: "{{ route('api.get.daerah') }}",
                                    type: "POST",
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        const $idProvinsi = $(
                                            '#id_provinsi').empty();
                                        $idProvinsi.append(
                                            '<option value="">Pilih Provinsi</option>'
                                        );
                                        response.rows.forEach((
                                            item) => {
                                            $idProvinsi.append(
                                                `<option value="${item.id_provinsi}">${item.nama_provinsi}</option>`
                                            );
                                        });
                                        $idProvinsi.val(data
                                            .id_provinsi).trigger(
                                            'change');
                                    }
                                });

                                // Event change untuk provinsi
                                $('#id_provinsi').on('change', function() {
                                    const idProvinsi = $(this).val();
                                    const $idKabupaten = $('#id_kabupaten')
                                        .empty();
                                    $('.kabupaten_container').show();

                                    if (!idProvinsi) {
                                        $('.kabupaten_container, .kabupaten_container, .kelurahan_container')
                                            .hide();
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
                                        success: function(
                                            response) {
                                            $idKabupaten.append(
                                                '<option value="">Pilih Kabupaten</option>'
                                            );
                                            response.rows
                                                .forEach((
                                                    item
                                                ) => {
                                                    $idKabupaten
                                                        .append(
                                                            `<option value="${item.id_kabupaten}">${item.kabupaten}</option>`
                                                        );
                                                });
                                            $idKabupaten.val(
                                                data
                                                .id_kabupaten
                                            ).trigger(
                                                'change');
                                        }
                                    });
                                });

                                // Event change untuk kabupaten
                                $('#id_kabupaten').on('change', function() {
                                    const idKabupaten = $(this).val();
                                    const idProvinsi = $('#id_provinsi')
                                        .val();
                                    const $idKecamatan = $('#id_kecamatan')
                                        .empty();
                                    $('.kecamatan_container').show();

                                    if (!idKabupaten) {
                                        $('.kecamatan_container, .kelurahan_container')
                                            .hide();
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
                                        success: function(
                                            response) {
                                            $idKecamatan.append(
                                                '<option value="">Pilih Kecamatan</option>'
                                            );
                                            response.rows
                                                .forEach((
                                                    item
                                                ) => {
                                                    $idKecamatan
                                                        .append(
                                                            `<option value="${item.id_kecamatan}">${item.kecamatan}</option>`
                                                        );
                                                });
                                            $idKecamatan.val(
                                                data
                                                .id_kecamatan
                                            ).trigger(
                                                'change');
                                        }
                                    });
                                });

                                // Event change untuk kecamatan
                                $('#id_kecamatan').on('change', function() {
                                    const idKecamatan = $(this).val();
                                    const $idKelurahan = $('#id_kelurahan')
                                        .empty();
                                    const $idKabupaten = $('#id_kabupaten');
                                    const $idProvinsi = $('#id_provinsi');
                                    $('.kelurahan_container').show();

                                    if (!idKecamatan) {
                                        $('.kelurahan_container').hide();
                                        return;
                                    }

                                    $.ajax({
                                        url: "{{ route('api.get.daerah') }}",
                                        type: "POST",
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            id_kecamatan: idKecamatan,
                                            id_kabupaten: $idKabupaten
                                                .val(),
                                            id_provinsi: $idProvinsi
                                                .val()
                                        },
                                        dataType: "json",
                                        success: function(
                                            response) {
                                            $idKelurahan.append(
                                                '<option value="">Pilih Kelurahan</option>'
                                            );
                                            response.rows
                                                .forEach((
                                                    item
                                                ) => {
                                                    $idKelurahan
                                                        .append(
                                                            `<option value="${item.id_kelurahan}">${item.kelurahan}</option>`
                                                        );
                                                });
                                            $idKelurahan.val(
                                                data
                                                .id_kelurahan
                                            );
                                        }
                                    });
                                });
                            },
                            preConfirm: () => {
                                const data = {
                                    _token: '{{ csrf_token() }}',
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
                                    alat_transportasi: $('#alat_transportasi')
                                        .val(),
                                    keterangan_status: $('#keterangan_status')
                                        .val(),
                                    photo: $('#photo')[0].files[0]
                                };

                                const photo = $('#photo')[0].files[0];
                                data.photo = photo;


                                // Validasi input
                                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                for (const key in data) {
                                    if (data[key] === '' && key !== 'photo' &&
                                        key !== 'telepon' && key !== 'id_status' &&
                                        key !== 'hp' && key !== 'email' && key !==
                                        'nik' && key !==
                                        'no_kk' && key !== 'stamboek' && key !==
                                        'tempat_lahir' &&
                                        key !== 'kodepos' && key !== 'pendidikan' &&
                                        key !== 'pekerjaan' &&
                                        key !== 'tanggal_baptis' && key !==
                                        'instansi' && key !==
                                        'gereja_baptis' && key !==
                                        'alat_transportasi' && key !==
                                        'penghasilan' && key !== 'golongan_darah' &&
                                        key !== 'id_kelurahan' && key !==
                                        'id_kecamatan' && key !==
                                        'id_kabupaten' && key !== 'id_provinsi' &&
                                        key !== photo) {
                                        Swal.showValidationMessage(
                                            `${key.replace(/_/g, ' ')} tidak boleh kosong!`
                                        );
                                        return false;
                                    }
                                    if (key === 'email' && data[key] !== '' && !
                                        emailRegex.test(data[
                                            key])) {
                                        Swal.showValidationMessage(
                                            'Format email tidak valid!');
                                        return false;
                                    }
                                }

                                return new Promise((resolve, reject) => {
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('api.get.jemaat') }}",
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            nama_jemaat: data
                                                .nama_jemaat,
                                        },
                                        dataType: "json",
                                        success: function(
                                            response) {
                                            if (response.total >
                                                0 && data
                                                .nama_jemaat !=
                                                old_nama_jemaat
                                                ) {
                                                reject(
                                                    'Nama Jemaat sudah ada, silahkan gunakan NIK lain!'
                                                );
                                            } else {
                                                resolve(data);
                                            }
                                        },
                                        error: function(xhr, status,
                                            error) {
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
                                    id_wilayah,
                                    kelamin,
                                    tanggal_lahir,
                                    alamat_jemaat,
                                    id_kelurahan,
                                    id_kecamatan,
                                    id_kabupaten,
                                    id_provinsi,
                                    telepon,
                                    kodepos,
                                    hp,
                                    email,
                                    nik,
                                    no_kk,
                                    stamboek,
                                    tempat_lahir,
                                    tanggal_baptis,
                                    golongan_darah,
                                    instansi,
                                    pekerjaan,
                                    pendidikan,
                                    ilmu,
                                    penghasilan,
                                    gereja_baptis,
                                    alat_transportasi,
                                    keterangan_status,
                                    foto
                                } = result.value;

                                const formData = new FormData();
                                formData.append('_token', '{{ csrf_token() }}');
                                formData.append('id_jemaat', id_jemaat);
                                formData.append('nama_jemaat', nama_jemaat);
                                formData.append('id_wilayah', id_wilayah);
                                formData.append('kelamin', kelamin);
                                formData.append('kodepos', kodepos);
                                formData.append('tanggal_lahir', tanggal_lahir);
                                formData.append('id_kelurahan', id_kelurahan);
                                formData.append('id_kecamatan', id_kecamatan);
                                if (id_kabupaten) formData.append('id_kabupaten',
                                    id_kabupaten);
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
                                formData.append('pekerjaan', pekerjaan);
                                formData.append('ilmu', ilmu);
                                formData.append('pendidikan', pendidikan);
                                formData.append('instansi', instansi);
                                formData.append('penghasilan', penghasilan);
                                formData.append('gereja_baptis', gereja_baptis);
                                formData.append('alat_transportasi', alat_transportasi);
                                formData.append('id_status', result.value.keterangan_status);
                                if (foto) formData.append('photo', foto);

                                $.ajax({
                                    url: "{{ route('api.update.jemaat') }}",
                                    type: 'POST',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        Swal.fire({
                                            toast: true,
                                            icon: 'success',
                                            title: 'Data jemaat berhasil diupdate',
                                            position: 'top-right',
                                            showConfirmButton: false,
                                            timer: 3500,
                                            allowOutsideClick: true,
                                            allowEscapeKey: true,
                                            timerProgressBar: true,
                                            didOpen: (toast) => {
                                                toast
                                                    .addEventListener(
                                                        'mouseenter',
                                                        Swal
                                                        .stopTimer
                                                        )
                                                toast
                                                    .addEventListener(
                                                        'mouseleave',
                                                        Swal
                                                        .resumeTimer
                                                        )
                                            }
                                        }).then(() => {
                                            location
                                        .reload();
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            toast: true,
                                            icon: 'error',
                                            title: 'Data jemaat gagal diupdate',
                                            position: 'top-right',
                                            showConfirmButton: false,
                                            timer: 3500,
                                            allowOutsideClick: true,
                                            allowEscapeKey: true,
                                            timerProgressBar: true,
                                            didOpen: (toast) => {
                                                toast
                                                    .addEventListener(
                                                        'mouseenter',
                                                        Swal
                                                        .stopTimer
                                                        )
                                                toast
                                                    .addEventListener(
                                                        'mouseleave',
                                                        Swal
                                                        .resumeTimer
                                                        )
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            });

            function ApiGetJemaatById(id_jemaat, params) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('api.get.jemaat.by.id', ['id_jemaat' => '__ID__']) }}".replace('__ID__',
                        id_jemaat),
                    data: {
                        _token: '{{ csrf_token() }}',
                        validasi: 'valid'
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
        });
    </script>
@endpush
