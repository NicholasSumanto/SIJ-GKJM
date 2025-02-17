@extends('layouts.admin-main-data')

@section('title', 'Jemaat Titipan')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">
    <style>
        th {
            vertical-align: top !important;
        }
    </style>
@endpush

@section('content')
    <div class="card-body">
        <a href="" class="btn btn-success tambah-titipan">Tambah Jemaat Titipan</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-filter-control="true" data-ajax="ApiGetJemaatTitipan">
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
                    field: 'alamat_jemaat',
                    title: 'Alamat Jemaat',
                    align: 'center'
                },{
                    field: 'titipan',
                    title: 'Titipan',
                    align: 'center'
                },{
                    field: 'kelamin',
                    title: 'Kelamin',
                    align: 'center'
                }, {
                    field: 'nama_gereja_asal',
                    title: 'Gereja Asal',
                    align: 'center'
                }, {
                    field: 'nama_gereja_tujuan',
                    title: 'Gereja Tujuan',
                    align: 'center'
                },{
                    field: 'tanggal_titipan',
                    title: 'Tanggal Titipan',
                    align: 'center'
                },{
                    field: 'status_titipan',
                    title: 'Status Titipan',
                    align: 'center'
                },{
                    field: 'tanggal_selesai',
                    title: 'Tanggal Selesai',
                    align: 'center'
                },{
                    field: 'alamat_jemaat',
                    title: 'Alamat',
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
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_titipan}" data-name="${row.name}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_titipan}">Delete</button>`;
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
                    },  {
                        field: 'alamat_jemaat',
                        title: 'Alamat Jemaat',
                        align: 'center'
                    },{
                        field: 'titipan',
                        title: 'Titipan',
                        align: 'center'
                    },{
                        field: 'kelamin',
                        title: 'Kelamin',
                        align: 'center'
                    }, {
                        field: 'nama_gereja_asal',
                        title: 'Gereja Asal',
                        align: 'center'
                    }, {
                        field: 'nama_gereja_tujuan',
                        title: 'Gereja Tujuan',
                        align: 'center'
                    },{
                        field: 'tanggal_titipan',
                        title: 'Tanggal Titipan',
                        align: 'center'
                    },{
                        field: 'status_titipan',
                        title: 'Status Titipan',
                        align: 'center'
                    },{
                        field: 'tanggal_selesai',
                        title: 'Tanggal Selesai',
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
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id_titipan}" data-name="${row.name}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_titipan}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                });
            }).trigger('change');

            // Event listener untuk tombol tambah wilayah
            $('.tambah-titipan').on('click', function(event) {
                event.preventDefault();

                // Menampilkan SweetAlert untuk tambah Jemaat Titipan
                Swal.fire({
                    title: 'Tambah Jemaat Titipan',
                    html: `
                    <form id="addJemaatTitipanForm">
                        <div class="form-group">
                            <label for="titipan">Titipan *</label>
                            <select id="titipan" class="form-control">
                                <option value="Keluar">Keluar</option>
                                <option value="Masuk">Masuk</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Jemaat *</label>
                            <div id="nama_keluar_container">
                                <select id="nama_keluar" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Jemaat</option>
                                </select>
                            </div>
                            <div id="nama_masuk_container" style="display: none;">
                                <input type="text" id="nama_masuk" class="form-control" placeholder="Masukkan Nama Jemaat *">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kelamin">Kelamin *</label>
                            <select id="kelamin" class="form-control">
                                <option value="">Pilih Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <!-- Container Gereja Asal -->
                            <div id="gereja_asal_container">
                                <label for="nama_gereja_asal">Nama Gereja Asal*</label>
                                <select id="nama_gereja_asal" class="form-control" required>
                                    <option value="">Pilih Nama Gereja Asal</option>
                                    <!-- Opsi diisi melalui AJAX -->
                                </select>
                                <div id="new-gereja-container-asal" style="margin-top: 10px; display: none;">
                                    <input type="text" id="new_gereja_asal" class="form-control" placeholder="Masukkan Gereja Baru *">
                                </div>
                            </div>

                            <!-- Container Gereja Tujuan -->
                            <div id="gereja_tujuan_container" style="margin-top: 20px;">
                                <label for="nama_gereja_tujuan">Nama Gereja Tujuan*</label>
                                <select id="nama_gereja_tujuan" class="form-control" required>
                                    <option value="">Pilih Nama Gereja Tujuan</option>
                                    <!-- Opsi diisi melalui AJAX -->
                                </select>
                                <div id="new-gereja-container-tujuan" style="margin-top: 10px; display: none;">
                                    <input type="text" id="new_gereja_tujuan" class="form-control" placeholder="Masukkan Gereja Baru *">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_titipan">Tanggal Titipan *</label>
                            <input type="date" id="tanggal_titipan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" id="tanggal_selesai" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="alamat_jemaat">Alamat Jemaat *</label>
                            <textarea id="alamat_jemaat" class="form-control" placeholder="Alamat Jemaat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status_titipan">Status Titipan *</label>
                            <select id="status_titipan" class="form-control">
                                <option value="Berproses">Berproses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="surat">Surat *</label>
                            <input type="file" id="surat" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                        </div>
                    </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $('#nama_keluar').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $(
                                '.swal2-container')
                        });

                        $('#titipan').on('change', function() {
                            const status = $(this).val();
                            if (status == 'Masuk') {
                                $('#nama_keluar_container').hide();
                                $('#nama_masuk_container').show();
                                $('#nama_masuk').val('');
                            } else {
                                $('#nama_keluar_container').show();
                                $('#nama_masuk_container').hide();
                                $('#nama_keluar').val('');
                            }
                        });

                        function setFormVisibility(status) {
                            if (status == 'Masuk') {
                                $('#gereja_asal_container').show();
                                $('#gereja_tujuan_container').hide();
                                $('#nama_gereja_tujuan').val('');
                                $('#new-gereja-container-tujuan').hide();
                            } else if (status == 'Keluar') {
                                $('#gereja_asal_container').hide();
                                $('#gereja_tujuan_container').show();
                                $('#nama_gereja_asal').val('');
                                $('#new-gereja-container-asal').hide();
                            }
                        }

                        $('#titipan').on('change', function() {
                            const status = $(this).val();
                            setFormVisibility(status);
                        });

                        $(document).ready(function() {
                            const initialStatus = $('#titipan').val();
                            setFormVisibility(initialStatus);
                        });


                        $.ajax({
                            url: "{{ route('api.get.gereja') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $gerejaAsalSelect = $('#nama_gereja_asal');
                                const $gerejaTujuanSelect = $('#nama_gereja_tujuan');

                                $gerejaAsalSelect.empty();
                                $gerejaTujuanSelect.empty();

                                $gerejaAsalSelect.append('<option value="">Pilih Nama Gereja Asal</option>');
                                $gerejaTujuanSelect.append('<option value="">Pilih Nama Gereja Tujuan</option>');

                                Object.entries(response).forEach(function([key, value]) {
                                    const option = `<option value="${value.nama_gereja}">${value.nama_gereja}</option>`;
                                    $gerejaAsalSelect.append(option);
                                    $gerejaTujuanSelect.append(option);
                                });

                                const addNewOption = '<option value="add-new-gereja">+ Tambah Gereja Baru</option>';
                                $gerejaAsalSelect.append(addNewOption);
                                $gerejaTujuanSelect.append(addNewOption);
                            }
                        });

                        $('#nama_gereja_asal').change(function() {
                            const selectedValue = $(this).val();
                            if (selectedValue === 'add-new-gereja') {
                                $('#new-gereja-container-asal').show();
                                $('#new_gereja_asal').val('');
                            } else {
                                $('#new-gereja-container-asal').hide();
                                $('#new_gereja_asal').val('');
                            }
                        });

                        $('#nama_gereja_tujuan').change(function() {
                            const selectedValue = $(this).val();
                            if (selectedValue === 'add-new-gereja') {
                                $('#new-gereja-container-tujuan').show();
                                $('#new_gereja_tujuan').val('');
                            } else {
                                $('#new-gereja-container-tujuan').hide();
                                $('#new_gereja_tujuan').val('');
                            }
                        });



                        $.ajax({
                            url: "{{ route('api.get.jemaat') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                onlyName: true
                            },
                            dataType: "json",
                            success: function(response) {
                                const $jemaatSelect = $('#nama_keluar');
                                $jemaatSelect.empty().append(
                                    '<option value="">Pilih Nama Jemaat</option>'
                                );
                                $.each(response.rows, function(key, value) {
                                    $jemaatSelect.append(new Option(value
                                        .nama_jemaat, value
                                        .id_jemaat));
                                });
                            }
                        });
                    },
                    preConfirm: () => {
                        // Define titipanStatus correctly
                        const data = {
                            nama_keluar: $('#nama_keluar').val(),
                            nama_masuk: $('#nama_masuk').val(),
                            kelamin: $('#kelamin').val(),
                            nama_gereja_asal: $('#nama_gereja_asal').val(),
                            tanggal_titipan: $('#tanggal_titipan').val(),
                            tanggal_selesai: $('#tanggal_selesai').val(),
                            new_gereja_asal: $('#new_gereja_asal').val(),
                            nama_gereja_tujuan: $('#nama_gereja_tujuan').val(),
                            new_gereja_tujuan: $('#new_gereja_tujuan').val(),
                            alamat_jemaat: $('#alamat_jemaat').val(),
                            status_titipan: $('#status_titipan').val(),
                            titipan: $('#titipan').val(),
                            surat: $('#surat')[0].files[0],
                        };

                        // Validasi form
                        if (data.titipan == 'Masuk' && !data.nama_masuk) {
                            Swal.showValidationMessage('Nama Jemaat Masuk harus diisi!');
                            return false;
                        } else {
                            data.nama_jemaat = data.nama_masuk;
                        }

                        if (data.titipan == 'Keluar' && !data.nama_keluar) {
                            Swal.showValidationMessage('Nama Jemaat Keluar harus diisi!');
                            return false;
                        } else  {
                            data.id_jemaat = data.nama_keluar;
                        }

                        if (data.nama_gereja_asal === 'add-new-gereja' && !data.new_gereja_asal) {
                            Swal.showValidationMessage('Masukkan nama gereja baru untuk Gereja Asal');
                            return false;
                        } else if (data.nama_gereja_asal === 'add-new-gereja') {
                            data.nama_gereja_asal = data.new_gereja_asal;
                        }

                        // Validasi untuk nama gereja tujuan
                        if (data.nama_gereja_tujuan === 'add-new-gereja' && !data.new_gereja_tujuan) {
                            Swal.showValidationMessage('Masukkan nama gereja baru untuk Gereja Tujuan');
                            return false;
                        } else if (data.nama_gereja_tujuan === 'add-new-gereja') {
                            data.nama_gereja_tujuan = data.new_gereja_tujuan;
                        }


                        if (!data.kelamin  || !data.titipan || !data.surat) {
                            Swal.showValidationMessage('Semua kolom harus diisi!');
                            return false;
                        }

                        return data;
                    }

                }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');

                    if (result.value.titipan === 'Keluar') {
                        formData.append('id_jemaat', result.value.id_jemaat);
                        formData.append('nama_gereja_tujuan', result.value.nama_gereja_tujuan);
                        formData.append('new_gereja_tujuan', result.value.new_gereja_tujuan);
                    } else if (result.value.titipan === 'Masuk') {
                        formData.append('nama_jemaat', result.value.nama_jemaat);
                        formData.append('nama_gereja_asal', result.value.nama_gereja_asal);
                        formData.append('new_gereja_asal', result.value.new_gereja_asal);
                    }

                    formData.append('titipan', result.value.titipan);
                    formData.append('tanggal_titipan', result.value.tanggal_titipan);
                    formData.append('kelamin', result.value.kelamin);
                    formData.append('alamat_jemaat', result.value.alamat_jemaat);
                    formData.append('status_titipan', result.value.status_titipan);
                    formData.append('surat', result.value.surat);
                    console.log (result.value.status_titipan);

                    if (result.value.tanggal_selesai) {
                        formData.append('tanggal_selesai', result.value.tanggal_selesai);
                    }

                    if (result.value.keterangan) {
                        formData.append('keterangan', result.value.keterangan);
                    }


                        $.ajax({
                            url: "{{ route('api.post.jemaattitipan') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function() {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data Jemaat Titipan berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function() {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data Jemaat Titipan gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });


            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function(event) {
                event.preventDefault();
                const id_titipan = $(this).data('id');

                $.ajax({
                    url: "{{ route('api.get.jemaattitipan') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id_titipan
                    },
                    dataType: "json",
                    success: function(response) {
                        const data = response.rows[0];
                        // Menampilkan SweetAlert untuk Edit Jemaat Titipan
                        Swal.fire({
                            title: 'Edit Jemaat Titipan',
                            html:`
                            <form id="editJemaatTitipanForm">
                        <div class="form-group">
                            <label for="titipan">Titipan *</label>
                            <select id="titipan" class="form-control">
                                <option value="Keluar" ${data.titipan === 'Keluar' ? 'selected' : ''}>Keluar</option>
                                <option value="Masuk" ${data.titipan === 'Masuk' ? 'selected' : ''}>Masuk</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Jemaat *</label>
                            <div id="nama_keluar_container">
                                <select id="nama_keluar" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Jemaat</option>
                                    <!-- Options will be populated by AJAX -->
                                </select>
                            </div>
                            <div id="nama_masuk_container" style="display: none;">
                                <input type="text" id="nama_masuk" class="form-control" placeholder="Masukkan Nama Jemaat *" value="${data.nama_jemaat}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kelamin">Kelamin *</label>
                            <select id="kelamin" class="form-control">
                                <option value="">Pilih Kelamin</option>
                                <option value="Laki-laki" ${data.kelamin === 'Laki-laki' ? 'selected' : ''}>Laki-laki</option>
                                <option value="Perempuan" ${data.kelamin === 'Perempuan' ? 'selected' : ''}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div id="gereja_asal_container">
                                <label for="nama_gereja_asal">Nama Gereja Asal*</label>
                                <select id="nama_gereja_asal" class="form-control" required>
                                    <option value="">Pilih Nama Gereja Asal</option>
                                    <!-- Options will be populated by AJAX -->
                                </select>
                            </div>
                            <div id="gereja_tujuan_container" style="margin-top: 20px;">
                                <label for="nama_gereja_tujuan">Nama Gereja Tujuan*</label>
                                <select id="nama_gereja_tujuan" class="form-control" required>
                                    <option value="">Pilih Nama Gereja Tujuan</option>
                                    <!-- Options will be populated by AJAX -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_titipan">Tanggal Titipan *</label>
                            <input type="date" id="tanggal_titipan" class="form-control" value="${data.tanggal_titipan}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" id="tanggal_selesai" class="form-control" value="${data.tanggal_selesai}">
                        </div>
                        <div class="form-group">
                            <label for="alamat_jemaat">Alamat Jemaat *</label>
                            <textarea id="alamat_jemaat" class="form-control" placeholder="Alamat Jemaat">${data.alamat_jemaat}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="status_titipan">Status Titipan *</label>
                            <select id="status_titipan" class="form-control">
                                <option value="Berproses" ${data.status_titipan === 'Berproses' ? 'selected' : ''}>Berproses</option>
                                <option value="Selesai" ${data.status_titipan === 'Selesai' ? 'selected' : ''}>Selesai</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="surat">Surat *</label>
                            <input type="file" id="surat" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                        </div>
                    </form>
                    `,
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            cancelButtonText: 'Batal',
                            didOpen: () => {
                                $('#nama_keluar').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $(
                                '.swal2-container')
                        });

                        $('#titipan').on('change', function() {
                            const status = $(this).val();
                            if (status == 'Masuk') {
                                $('#nama_keluar_container').hide();
                                $('#nama_masuk_container').show();
                                $('#nama_masuk').val('');
                            } else {
                                $('#nama_keluar_container').show();
                                $('#nama_masuk_container').hide();
                                $('#nama_keluar').val('');
                            }
                        });

                        function setFormVisibility(status) {
                            if (status == 'Masuk') {
                                $('#gereja_asal_container').show();
                                $('#gereja_tujuan_container').hide();
                                $('#nama_gereja_tujuan').val('');
                                $('#new-gereja-container-tujuan').hide();
                            } else if (status == 'Keluar') {
                                $('#gereja_asal_container').hide();
                                $('#gereja_tujuan_container').show();
                                $('#nama_gereja_asal').val('');
                                $('#new-gereja-container-asal').hide();
                            }
                        }

                        $('#titipan').on('change', function() {
                            const status = $(this).val();
                            setFormVisibility(status);
                        });

                        $(document).ready(function() {
                            const initialStatus = $('#titipan').val();
                            setFormVisibility(initialStatus);
                        });


                        $.ajax({
                            url: "{{ route('api.get.gereja') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $gerejaAsalSelect = $('#nama_gereja_asal');
                                const $gerejaTujuanSelect = $('#nama_gereja_tujuan');

                                $gerejaAsalSelect.empty();
                                $gerejaTujuanSelect.empty();

                                $gerejaAsalSelect.append('<option value="">Pilih Nama Gereja Asal</option>');
                                $gerejaTujuanSelect.append('<option value="">Pilih Nama Gereja Tujuan</option>');

                                Object.entries(response).forEach(function([key, value]) {
                                    const option = `<option value="${value.nama_gereja}">${value.nama_gereja}</option>`;
                                    $gerejaAsalSelect.append(option);
                                    $gerejaTujuanSelect.append(option);
                                });

                                const addNewOption = '<option value="add-new-gereja">+ Tambah Gereja Baru</option>';
                                $gerejaAsalSelect.append(addNewOption);
                                $gerejaTujuanSelect.append(addNewOption);
                            }
                        });

                        $('#nama_gereja_asal').change(function() {
                            const selectedValue = $(this).val();
                            if (selectedValue === 'add-new-gereja') {
                                $('#new-gereja-container-asal').show();
                                $('#new_gereja_asal').val('');
                            } else {
                                $('#new-gereja-container-asal').hide();
                                $('#new_gereja_asal').val('');
                            }
                        });

                        $('#nama_gereja_tujuan').change(function() {
                            const selectedValue = $(this).val();
                            if (selectedValue === 'add-new-gereja') {
                                $('#new-gereja-container-tujuan').show();
                                $('#new_gereja_tujuan').val('');
                            } else {
                                $('#new-gereja-container-tujuan').hide();
                                $('#new_gereja_tujuan').val('');
                            }
                        });



                        $.ajax({
                            url: "{{ route('api.get.jemaat') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                onlyName: true
                            },
                            dataType: "json",
                            success: function(response) {
                                const $jemaatSelect = $('#nama_keluar');
                                $jemaatSelect.empty().append(
                                    '<option value="">Pilih Nama Jemaat</option>'
                                );
                                $.each(response.rows, function(key, value) {
                                    $jemaatSelect.append(new Option(value
                                        .nama_jemaat, value
                                        .id_jemaat));
                                });
                            }
                        });
                    },
                    preConfirm: () => {
                        // Define titipanStatus correctly
                        const data = {
                            nama_keluar: $('#nama_keluar').val(),
                            nama_masuk: $('#nama_masuk').val(),
                            kelamin: $('#kelamin').val(),
                            nama_gereja_asal: $('#nama_gereja_asal').val(),
                            tanggal_titipan: $('#tanggal_titipan').val(),
                            tanggal_selesai: $('#tanggal_selesai').val(),
                            new_gereja_asal: $('#new_gereja_asal').val(),
                            nama_gereja_tujuan: $('#nama_gereja_tujuan').val(),
                            new_gereja_tujuan: $('#new_gereja_tujuan').val(),
                            alamat_jemaat: $('#alamat_jemaat').val(),
                            status_titipan: $('#status_titipan').val(),
                            titipan: $('#titipan').val(),
                            surat: $('#surat')[0].files[0],
                        };

                        // Validasi form
                        if (data.titipan == 'Masuk' && !data.nama_masuk) {
                            Swal.showValidationMessage('Nama Jemaat Masuk harus diisi!');
                            return false;
                        } else {
                            data.nama_jemaat = data.nama_masuk;
                        }

                        if (data.titipan == 'Keluar' && !data.nama_keluar) {
                            Swal.showValidationMessage('Nama Jemaat Keluar harus diisi!');
                            return false;
                        } else  {
                            data.id_jemaat = data.nama_keluar;
                        }

                        if (data.nama_gereja_asal === 'add-new-gereja' && !data.new_gereja_asal) {
                            Swal.showValidationMessage('Masukkan nama gereja baru untuk Gereja Asal');
                            return false;
                        } else if (data.nama_gereja_asal === 'add-new-gereja') {
                            data.nama_gereja_asal = data.new_gereja_asal;
                        }

                        // Validasi untuk nama gereja tujuan
                        if (data.nama_gereja_tujuan === 'add-new-gereja' && !data.new_gereja_tujuan) {
                            Swal.showValidationMessage('Masukkan nama gereja baru untuk Gereja Tujuan');
                            return false;
                        } else if (data.nama_gereja_tujuan === 'add-new-gereja') {
                            data.nama_gereja_tujuan = data.new_gereja_tujuan;
                        }


                        if (!data.kelamin  || !data.titipan || !data.surat) {
                            Swal.showValidationMessage('Semua kolom harus diisi!');
                            return false;
                        }

                        return data;
                    }

                        }).then((result) => {
                            if (result.isConfirmed) {
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');

                            if (result.value.titipan === 'Keluar') {
                                formData.append('id_jemaat', result.value.id_jemaat);
                                formData.append('nama_gereja_tujuan', result.value.nama_gereja_tujuan);
                                formData.append('new_gereja_tujuan', result.value.new_gereja_tujuan);
                            } else if (result.value.titipan === 'Masuk') {
                                formData.append('nama_jemaat', result.value.nama_jemaat);
                                formData.append('nama_gereja_asal', result.value.nama_gereja_asal);
                                formData.append('new_gereja_asal', result.value.new_gereja_asal);
                            }

                            formData.append('titipan', result.value.titipan);
                            formData.append('tanggal_titipan', result.value.tanggal_titipan);
                            formData.append('kelamin', result.value.kelamin);
                            formData.append('alamat_jemaat', result.value.alamat_jemaat);
                            formData.append('status_titipan', result.value.status_titipan);
                            formData.append('surat', result.value.surat);
                            console.log (result.value.status_titipan);

                            if (result.value.tanggal_selesai) {
                                formData.append('tanggal_selesai', result.value.tanggal_selesai);
                            }

                            if (result.value.keterangan) {
                                formData.append('keterangan', result.value.keterangan);
                            }


                                $.ajax({
                                    url: "{{ route('api.update.jemaattitipan') }}",
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function() {
                                        alert.fire({
                                            icon: 'success',
                                            title: 'Data Jemaat Titipan berhasil ditambahkan!'
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function() {
                                        alert.fire({
                                            icon: 'error',
                                            title: 'Data Jemaat Titipan gagal ditambahkan!'
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });


        $(document).on('click', '.btn-delete', function() {
            event.preventDefault();
            var id_titipan = $(this).data('id');

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
                        url: `{{ route('api.delete.jemaattitipan') }}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_titipan: id_titipan
                        },
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data jemaat titipan berhasil dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data jemaat titipan gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        function ApiGetJemaatTitipan(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.jemaattitipan') }}",
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
