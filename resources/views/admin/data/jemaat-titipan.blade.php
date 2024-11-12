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
                    field: 'kelamin',
                    title: 'Kelamin',
                    align: 'center'
                },{
                    field: 'nama_gereja',
                    title: 'Gereja Asal',
                    align: 'center'
                }, {
                    field: 'alamat_jemaat',
                    title: 'Alamat',
                    align: 'center'
                }, {
                    field: 'titipan',
                    title: 'Titipan',
                    align: 'center'
                }, {
                    field: 'surat',
                    title: 'Surat',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-surat" data-id="${row.id_titipan}">Surat</button>`;
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
                        title: 'nama',
                        align: 'center'
                    }, {
                        field: 'kelamin',
                        title: 'Kelamin',
                        align: 'center'
                    },{
                        field: 'nama_gereja',
                        title: 'Gereja Asal',
                        align: 'center'
                    }, {
                        field: 'alamat_jemaat',
                        title: 'Alamat',
                        align: 'center'
                    }, {
                        field: 'titipan',
                        title: 'Titipan',
                        align: 'center'
                    }, {
                    field: 'surat',
                    title: 'Surat',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-primary btn-surat" data-id="${row.id_titipan}">Surat</button>`;
                    },
                    align: 'center'
                    },{
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_titipan}" data-name="${row.name}">Edit</button>`;
                    },
                    align: 'center'
                    },{
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_titipan}">Delete</button>`;
                        },
                        align: 'center'
                    }]
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
                            <label for="titipan">Titipan</label>
                            <select id="titipan" class="form-control">
                                <option value="Keluar">Keluar</option>
                                <option value="Masuk">Masuk</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_jemaat">Nama Jemaat</label>
                            <div  id="nama_keluar">
                                <select id="nama_jemaat" class="form-control" required style="width: 100%;">
                                    <option value="">Pilih Nama Jemaat</option>
                                </select>
                            </div>
                            <div id="nama_masuk" style="display: none;">
                                <input type="text" id="nama_jemaat" class="form-control" placeholder="Masukkan Nama Jemaat">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kelamin">Kelamin</label>
                            <select id="kelamin" class="form-control">
                                <option value="">Pilih Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_gereja">Nama Gereja</label>
                            <select id="nama_gereja" class="form-control" required>
                                <option value="">Pilih Nama Gereja</option>
                                <!-- AJAX -->
                            </select>
                            <div id="new-gereja-container" style="margin-top: 10px; display: none;">
                                <input type="text" id="new_gereja" class="form-control" placeholder="Masukkan Gereja Baru">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat_jemaat">Alamat Jemaat</label>
                            <textarea id="alamat_jemaat" class="form-control" placeholder="Alamat Jemaat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="surat">Surat</label>
                            <input type="file" id="surat" class="form-control">
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

                        $('#titipan').on('change', function() {
                            const status = $(this).val();
                            if (status == 'Masuk') {
                                $('#nama_keluar').hide();
                                $('#nama_masuk').show();
                            } else {
                                $('#nama_keluar').show();
                                $('#nama_masuk').hide();
                            }
                        });

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
                                    $jemaatSelect.append(new Option(value.nama_jemaat,value.id_jemaat));
                                });
                            }
                        });
                },
                preConfirm: () => {
                // Define titipanStatus correctly
                const titipanStatus = $('#titipan').val();  // Make sure this is declared before use

                // Get the value of nama_jemaat based on titipan status
                const namaJemaat = titipanStatus === 'Masuk' ? $('#nama_jemaat').val() : $('#nama_jemaat').val();

                const data = {
                    nama_jemaat: namaJemaat,
                    kelamin: $('#kelamin').val(),
                    nama_gereja: $('#nama_gereja').val(),
                    alamat_jemaat: $('#alamat_jemaat').val(),
                    titipan: $('#titipan').val(),
                    surat: $('#surat')[0].files[0],
                };

                // Validasi form
                if (!data.nama_jemaat || !data.kelamin || !data.nama_gereja || !data.alamat_jemaat || !data.titipan || !data.surat) {
                    Swal.showValidationMessage('Semua kolom harus diisi!');
                    return false;
                }

                // Validasi jenis file surat (opsional)
                if (data.surat && !['application/pdf', 'image/jpeg', 'image/png'].includes(data.surat.type)) {
                    Swal.showValidationMessage('Hanya file PDF, JPG, atau PNG yang diizinkan!');
                    return false;
                }

                return data;
            }

            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('nama_jemaat', $('#nama_jemaat').val());
                    formData.append('kelamin', $('#kelamin').val());
                    formData.append('nama_gereja', $('#nama_gereja').val());
                    formData.append('alamat_jemaat', $('#alamat_jemaat').val());
                    formData.append('titipan', $('#titipan').val());
                    formData.append('surat', $('#surat')[0].files[0]);

                    $.ajax({
                        url: "{{ route('api.post.jemaattitipan') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Jemaat Titipan berhasil ditambahkan!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function() {
                            Swal.fire({
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

            const id_titipan = $(this).data('id'); // Ambil ID dari tombol yang diklik

            // Ambil data Jemaat Titipan berdasarkan ID
            $.ajax({
                url: "{{ route('api.get.jemaattitipan') }}",  // Ganti dengan route yang sesuai untuk mendapatkan data berdasarkan ID
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_titipan: id_titipan
                },
                dataType: "json",
                success: function(response) {
                    const data = response.data;  // Asumsi server mengembalikan data dalam format { data: {...} }

                    // Menampilkan SweetAlert untuk Edit Jemaat Titipan
                    Swal.fire({
                        title: 'Edit Jemaat Titipan',
                        html: `
                            <form id="editJemaatTitipanForm">
                                <div class="form-group">
                                    <label for="titipan">Titipan</label>
                                    <select id="titipan" class="form-control">
                                        <option value="1" ${data.titipan == 1 ? 'selected' : ''}>Keluar</option>
                                        <option value="2" ${data.titipan == 2 ? 'selected' : ''}>Masuk</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_jemaat">Nama Jemaat</label>
                                    <div id="nama_keluar">
                                        <select id="nama_jemaat" class="form-control" required style="width: 100%;">
                                            <option value="">Pilih Nama Jemaat</option>
                                        </select>
                                    </div>
                                    <div id="nama_masuk" style="display: none;">
                                        <input type="text" id="nama_jemaat" class="form-control" value="${data.nama_jemaat}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kelamin">Kelamin</label>
                                    <select id="kelamin" class="form-control">
                                        <option value="">Pilih Kelamin</option>
                                        <option value="Laki-laki" ${data.kelamin === 'Laki-laki' ? 'selected' : ''}>Laki-laki</option>
                                        <option value="Perempuan" ${data.kelamin === 'Perempuan' ? 'selected' : ''}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_gereja">Nama Gereja</label>
                                    <select id="nama_gereja" class="form-control" required>
                                        <option value="">Pilih Nama Gereja</option>
                                        <!-- AJAX -->
                                    </select>
                                    <div id="new-gereja-container" style="margin-top: 10px; display: none;">
                                        <input type="text" id="new_gereja" class="form-control" value="${data.nama_gereja}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_jemaat">Alamat Jemaat</label>
                                    <textarea id="alamat_jemaat" class="form-control" placeholder="Alamat Jemaat">${data.alamat_jemaat}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="surat">Surat</label>
                                    <input type="file" id="surat" class="form-control">
                                </div>
                            </form>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Update',
                        cancelButtonText: 'Batal',
                        didOpen: () => {
                            // Set select2, handle change event for titipan, etc.
                            $('#nama_jemaat').select2({
                                placeholder: "Pilih atau cari",
                                allowClear: true,
                                dropdownParent: $('.swal2-container')
                            });

                            // Fetch Gereja options using AJAX
                            $.ajax({
                                url: "{{ route('api.get.gereja') }}",
                                type: "POST",
                                data: { _token: '{{ csrf_token() }}' },
                                dataType: "json",
                                success: function(response) {
                                    const $gerejaSelect = $('#nama_gereja');
                                    Object.entries(response).forEach(function([key, value]) {
                                        $gerejaSelect.append(
                                            `<option value="${value.nama_gereja}" ${data.nama_gereja === value.nama_gereja ? 'selected' : ''}>${value.nama_gereja}</option>`
                                        );
                                    });
                                    $gerejaSelect.append('<option value="add-new-gereja">+ Tambah Gereja Baru</option>');
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
                        const titipanStatus = $('#titipan').val();

                        const nama_jemaat = $('#nama_jemaat').val();

                        const data = {
                            nama_jemaat: nama_jemaat,
                            kelamin: $('#kelamin').val(),
                            nama_gereja: $('#nama_gereja').val(),
                            alamat_jemaat: $('#alamat_jemaat').val(),
                            titipan: $('#titipan').val(),
                            surat: $('#surat')[0].files[0],
                        };

                        if (!data.nama_jemaat || !data.kelamin || !data.nama_gereja || !data.alamat_jemaat || !data.titipan || !data.surat) {
                            Swal.showValidationMessage('Semua kolom harus diisi!');
                            return false;
                        }

                        // Validate surat file type (optional)
                        if (data.surat && !['application/pdf', 'image/jpeg', 'image/png'].includes(data.surat.type)) {
                            Swal.showValidationMessage('Hanya file PDF, JPG, atau PNG yang diizinkan!');
                            return false;
                        }

                        return data;
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
