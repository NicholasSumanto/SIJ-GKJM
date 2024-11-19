@extends('layouts.admin-main-data')

@section('title', 'Non Majelis')

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
        <a href="" class="btn btn-success tambah-nonmajelis">Tambah Non Majelis</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-filter-control="true" data-ajax="ApiGetNonMajelis">
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
                    field: 'nama_majelis_non',
                    title: 'Nama',
                    align: 'center'
                }, {
                    field: 'jabatan_non',
                    title: 'Jabatan',
                    align: 'center'
                }, {
                    field: 'tanggal_mulai',
                    title: 'Tanggal Mulai',
                    align: 'center'
                }, {
                    field: 'tanggal_selesai',
                    title: 'Tanggal Selesai',
                    align: 'center'
                }, {
                    field: 'no_sk',
                    title: 'No. SK',
                    align: 'center'
                }, {
                    field: 'berkas',
                    title: 'File SK',
                    formatter: function(value, row, index) {
                        const fileUrl = `/storage/${value}`;

                        return `
                                <button class="btn btn-primary">
                                    <a href="${fileUrl}" target="_blank" style="color:white; text-decoration:none;">Lihat File SK</a>
                                </button>
                            `;
                    },
                    align: 'center'
                }, {
                    field: 'keterangan_status',
                    title: 'Status',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_nonmajelis}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_nonmajelis}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    columns: [0, 1]
                }
            });

            // Event listener for "Tambah Non Majelis"
            $('.tambah-nonmajelis').on('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tambah Non Majelis Baru',
                    html: `
                    <form id="addNonMajelisForm">
                        <div class="form-group">
                            <label for="nama_majelis_non">Nama Non Majelis *</label>
                            <select id="nama_majelis_non" class="form-control">
                                <option value="">Pilih Nama Jemaat</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jabatan_non">Jabatan Non Majelis *</label>
                            <select id="jabatan_non" class="form-control">
                                <option value="">Pilih Jabatan Non Majelis</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai *</label>
                            <input type="date" id="tanggal_mulai" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai *</label>
                            <input type="date" id="tanggal_selesai" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="noSK">No. SK *</label>
                            <input type="text" id="noSK" class="form-control" placeholder="Masukkan No. SK *">
                        </div>
                        <div class="form-group">
                            <label for="berkas">File SK *</label>
                            <input type="file" id="berkas" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                        </div>
                        <div class="form-group">
                            <label for="keterangan_status">Status Non Majelis *</label>
                            <select id="keterangan_status" class="form-control">
                                <option value="">Pilih status</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                    </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $('#nama_majelis_non, #jabatan_non, #keterangan_status').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $('.swal2-container')
                        });

                        // Load Jabatan Non Majelis
                        $.ajax({
                            url: "{{ route('api.get.jabatan-non-majelis') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $jabatanNonMajelis = $('#jabatan_non');
                                $jabatanNonMajelis.empty().append(
                                    '<option value="">Pilih Jabatan Non Majelis</option>'
                                );
                                response.forEach(value => {
                                    $jabatanNonMajelis.append(
                                        `<option value="${value.id_jabatan_non}">${value.jabatan_nonmajelis}</option>`
                                    );
                                });
                            },
                        });

                        // Load Status Non Majelis
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
                                    '<option value="">Pilih Status</option>');
                                response.rows.forEach(item => {
                                    $statusDropdown.append(
                                        `<option value="${item.id_status}">${item.keterangan_status}</option>`
                                    );
                                });
                            },
                        });

                        // Load Nama Jemaat for Non Majelis
                        $.ajax({
                            url: "{{ route('api.get.jemaat') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                onlyName: true
                            },
                            dataType: "json",
                            success: function(response) {
                                const $namaNonMajelis = $('#nama_majelis_non');
                                $namaNonMajelis.empty().append(
                                    '<option value="">Pilih Nama Jemaat</option>'
                                );
                                $.each(response.rows, function(key, value) {
                                    $namaNonMajelis.append(new Option(value
                                        .nama_jemaat, value
                                        .id_jemaat));
                                });
                            },
                        });
                    },

                    preConfirm: () => {
                        const nama_majelis_non = $('#nama_majelis_non').val();
                        const id_jabatan_non = $('#jabatan_non').val();
                        const tanggal_mulai = $('#tanggal_mulai').val();
                        const tanggal_selesai = $('#tanggal_selesai').val();
                        const no_sk = $('#noSK').val();
                        const berkas = $('#berkas')[0].files[0];
                        const id_status = $('#keterangan_status').val();

                        // Validate form fields
                        if (!nama_majelis_non || !id_jabatan_non || !tanggal_mulai || !
                            tanggal_selesai || !no_sk || !id_status || !berkas) {
                            Swal.showValidationMessage('Semua kolom harus diisi!');
                            return false;
                        }

                        // Validate date range
                        if (new Date(tanggal_mulai) >= new Date(tanggal_selesai)) {
                            Swal.showValidationMessage(
                                'Tanggal mulai harus lebih kecil dari tanggal selesai!');
                            return false;
                        }

                        return {
                            nama_majelis_non,
                            id_jabatan_non,
                            tanggal_mulai,
                            tanggal_selesai,
                            no_sk,
                            berkas,
                            id_status
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const {
                            nama_majelis_non,
                            id_jabatan_non,
                            tanggal_mulai,
                            tanggal_selesai,
                            no_sk,
                            berkas,
                            id_status
                        } = result.value;

                        // Prepare FormData for AJAX request
                        const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('id_jemaat', nama_majelis_non);
                        formData.append('id_jabatan_non', id_jabatan_non);
                        formData.append('tanggal_mulai', tanggal_mulai);
                        formData.append('tanggal_selesai', tanggal_selesai);
                        formData.append('no_sk', no_sk);
                        formData.append('berkas', berkas);
                        formData.append('id_status', id_status);

                        // Send data to the server via AJAX
                        $.ajax({
                            url: "{{ route('api.post.nonmajelis') }}",
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data non majelis berhasil ditambahkan'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data  non majelis gagal ditambahkan'
                                });
                            }
                        });
                    }
                });
            });
        });


        // Event listener untuk tombol edit
        $(document).on('click', '.btn-edit', function() {
            event.preventDefault();
            var id_nonmajelis = $(this).data('id');

           $.ajax({
            type: "POST",
            url: "{{ route('api.get.nonmajelis') }}",
            data: {
                _token: '{{ csrf_token() }}',
                id: id_nonmajelis
            },
            dataType: "json",
            success: function (response) {
                const data = response.rows[0];

                Swal.fire({
                    title: 'Edit Non Majelis',
                    html: `
                    <form id="addNonMajelisForm">
                        <div class="form-group">
                            <label for="nama_majelis_non">Nama Non Majelis *</label>
                            <select id="nama_majelis_non" class="form-control">
                                <option value="">Pilih Nama Jemaat</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jabatan_non">Jabatan Non Majelis *</label>
                            <select id="jabatan_non" class="form-control">
                                <option value="">Pilih Jabatan Non Majelis</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai *</label>
                            <input type="date" id="tanggal_mulai" class="form-control" value="${data.tanggal_mulai}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai *</label>
                            <input type="date" id="tanggal_selesai" class="form-control" value="${data.tanggal_selesai}">
                        </div>
                        <div class="form-group">
                            <label for="noSK">No. SK *</label>
                            <input type="text" id="noSK" class="form-control" placeholder="Masukkan No. SK *" value="${data.no_sk}">
                        </div>
                        <div class="form-group">
                            <label for="berkas">File SK *</label>
                            ${data.berkas_url ? `<a href="${data.berkas_url}" target="_blank" class="btn btn-secondary mb-2 btn-sm">Lihat File SK yang Sudah Ada</a>` : ''}
                            <input type="file" id="berkas" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                        </div>
                        <div class="form-group">
                            <label for="keterangan_status">Status Non Majelis *</label>
                            <select id="keterangan_status" class="form-control">
                                <option value="">Pilih status</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                    </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        $('#nama_majelis_non, #jabatan_non, #keterangan_status').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $('.swal2-container')
                        });

                        // Load Jabatan Non Majelis
                        $.ajax({
                            url: "{{ route('api.get.jabatan-non-majelis') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $jabatanNonMajelis = $('#jabatan_non');
                                $jabatanNonMajelis.empty().append(
                                    '<option value="">Pilih Jabatan Non Majelis</option>'
                                );
                                response.forEach(value => {
                                    $jabatanNonMajelis.append(
                                        `<option value="${value.id_jabatan_non}">${value.jabatan_nonmajelis}</option>`
                                    );
                                });
                                $jabatanNonMajelis.val(data.id_jabatan_non);
                            },
                        });

                        // Load Status Non Majelis
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
                                    '<option value="">Pilih Status</option>');
                                response.rows.forEach(item => {
                                    $statusDropdown.append(
                                        `<option value="${item.id_status}">${item.keterangan_status}</option>`
                                    );
                                });
                                $statusDropdown.val(data.id_status);
                            },
                        });

                        // Load Nama Jemaat for Non Majelis
                        $.ajax({
                            url: "{{ route('api.get.jemaat') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                onlyName: true
                            },
                            dataType: "json",
                            success: function(response) {
                                const $namaNonMajelis = $('#nama_majelis_non');
                                $namaNonMajelis.empty().append(
                                    '<option value="">Pilih Nama Jemaat</option>'
                                );
                                $.each(response.rows, function(key, value) {
                                    $namaNonMajelis.append(new Option(value
                                        .nama_jemaat, value
                                        .id_jemaat));
                                });
                                $namaNonMajelis.val(data.id_jemaat);
                            },
                        });
                    },

                    preConfirm: () => {
                        const nama_majelis_non = $('#nama_majelis_non').val();
                        const id_jabatan_non = $('#jabatan_non').val();
                        const tanggal_mulai = $('#tanggal_mulai').val();
                        const tanggal_selesai = $('#tanggal_selesai').val();
                        const no_sk = $('#noSK').val();
                        const berkas = $('#berkas')[0].files[0];
                        const id_status = $('#keterangan_status').val();

                        // Validate form fields
                        if (!nama_majelis_non || !id_jabatan_non || !tanggal_mulai || !
                            tanggal_selesai || !no_sk || !id_status) {
                            Swal.showValidationMessage('Semua kolom harus diisi!');
                            return false;
                        }

                        // Validate date range
                        if (new Date(tanggal_mulai) >= new Date(tanggal_selesai)) {
                            Swal.showValidationMessage(
                                'Tanggal mulai harus lebih kecil dari tanggal selesai!');
                            return false;
                        }

                        return {
                            nama_majelis_non,
                            id_jabatan_non,
                            tanggal_mulai,
                            tanggal_selesai,
                            no_sk,
                            berkas,
                            id_status
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const {
                            nama_majelis_non,
                            id_jabatan_non,
                            tanggal_mulai,
                            tanggal_selesai,
                            no_sk,
                            berkas,
                            id_status
                        } = result.value;

                        // Prepare FormData for AJAX request
                        const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('id_nonmajelis', id_nonmajelis);
                        formData.append('id_jemaat', nama_majelis_non);
                        formData.append('id_jabatan_non', id_jabatan_non);
                        formData.append('tanggal_mulai', tanggal_mulai);
                        formData.append('tanggal_selesai', tanggal_selesai);
                        formData.append('no_sk', no_sk);
                        formData.append('berkas', berkas);
                        formData.append('id_status', id_status);

                        // Send data to the server via AJAX
                        $.ajax({
                            url: "{{ route('api.update.nonmajelis') }}",
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data non majelis berhasil diubah'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function(xhr, status, error) {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data  non majelis gagal diubah'
                                });
                            }
                        });
                    }
                });
            }
           });
        });

        $(document).on('click', '.btn-delete', function(event) {
            event.preventDefault();
            var id_nonmajelis = $(this).data('id');

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
                        url: `{{ route('api.delete.nonmajelis') }}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_nonmajelis: id_nonmajelis
                        },
                        dataType: "json",
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data Non Majelis berhasil Dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data Non Majelis gagal dihapus!',
                                text: error
                            });
                        }
                    });
                }
            });
        });

        function ApiGetNonMajelis(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.nonmajelis') }}",
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
