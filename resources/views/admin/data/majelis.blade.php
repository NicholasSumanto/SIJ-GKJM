@extends('layouts.admin-main-data')

@section('title', 'Majelis')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        <a href="" class="btn btn-success tambah-majelis">Tambah Majelis</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-filter-control="true" data-ajax="ApiGetMajelis">
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
                    field: 'no',
                    title: 'No',
                    align: 'center',
                    formatter: function(value, row, index) {
                        return index + 1;
                    }
                }, {
                    field: 'nama_majelis',
                    title: 'Nama',
                    align: 'center'
                }, {
                    field: 'jabatan_majelis',
                    title: 'Jabatan',
                    filterControl: 'select',
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
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_majelis}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_majelis}">Delete</button>`;
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
                        field: 'nama_majelis',
                        title: 'Nama',
                        align: 'center'
                    }, {
                        field: 'jabatan_majelis',
                        title: 'Jabatan',
                        filterControl: 'select',
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
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id_majelis}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_majelis}">Delete</button>`;
                        },
                        align: 'center'
                    }]
                });
            }).trigger('change');

            // Event listener untuk tombol tambah Majelis
            $('.tambah-majelis').on('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tambah Majelis Baru',
                    html: `
                    <form id="addMajelisForm">
                        <div class="form-group">
                            <label for="nama_majelis">Nama Majelis</label>
                            <select id="nama_majelis" class="form-control">
                                <option value="">Pilih Nama Majelis</option>
                                <!-- Dinamis, dimuat menggunakan AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jabatan_majelis">Jabatan Majelis</label>
                            <select id="jabatan_majelis" class="form-control">
                                <option value="">Pilih Jabatan Majelis</option>
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
                            <label for="no_sk">No. SK *</label>
                            <input type="text" id="no_sk" class="form-control" placeholder="Masukkan No. SK">
                        </div>
                        <div class="form-group">
                            <label for="berkas">File SK *</label>
                            <input type="file" id="berkas" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                        </div>
                        <div class="form-group">
                            <label for="keterangan_status">Status Majelis *</label>
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
                        $('#nama_majelis, #jabatan_majelis, #keterangan_status').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $('.swal2-container')
                        });

                        // Load Jabatan Majelis
                        $.ajax({
                            url: "{{ route('api.get.jabatan-majelis') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $JabatanMajelis = $('#jabatan_majelis');
                                $JabatanMajelis.empty().append(
                                    '<option value="">Pilih Jabatan Majelis</option>'
                                );
                                response.forEach(value => {
                                    $JabatanMajelis.append(
                                        `<option value="${value.id_jabatan}">${value.jabatan_majelis}</option>`
                                    );
                                });
                            },
                        });

                        // Load Status Majelis
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


                        // Load and autofill Nama Majelis from Jemaat
                        $.ajax({
                            url: "{{ route('api.get.jemaat') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                onlyName: true
                            },
                            dataType: "json",
                            success: function(response) {
                                const $namaMajelis = $('#nama_majelis');
                                $namaMajelis.empty().append(
                                    '<option value="">Pilih Nama Majelis</option>'
                                );
                                $.each(response.rows, function(key, value) {
                                    $namaMajelis.append(new Option(value
                                        .nama_jemaat, value
                                        .id_jemaat));
                                });
                            },
                        });
                    },
                    preConfirm: () => {
                        const data = {
                            nama_majelis: $('#nama_majelis').val(),
                            jabatan_majelis: $('#jabatan_majelis').val(),
                            tanggal_mulai: $('#tanggal_mulai').val(),
                            tanggal_selesai: $('#tanggal_selesai').val(),
                            no_sk: $('#no_sk').val(),
                            berkas: $('#berkas')[0].files[0],
                            keterangan_status: $('#keterangan_status').val()
                        };

                        // Validasi form
                        if (!data.nama_majelis || !data.tanggal_mulai || !data
                            .tanggal_selesai ||
                            !data.no_sk || !data.berkas || !data.keterangan_status) {
                            Swal.showValidationMessage('Semua kolom harus diisi!');
                            return false;
                        }

                        if (new Date(data.tanggal_mulai) >= new Date(data.tanggal_selesai)) {
                            Swal.showValidationMessage(
                                'Tanggal mulai harus lebih kecil dari tanggal selesai!');
                            return false;
                        }

                        return data;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gunakan FormData untuk mengirim data
                        let formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('id_jemaat', result.value.nama_majelis);
                        formData.append('id_jabatan', result.value.jabatan_majelis);
                        formData.append('tanggal_mulai', result.value.tanggal_mulai);
                        formData.append('tanggal_selesai', result.value.tanggal_selesai);
                        formData.append('no_sk', result.value.no_sk);
                        formData.append('berkas', result.value.berkas);
                        formData.append('id_status', result.value.keterangan_status);

                        $.ajax({
                            url: "{{ route('api.post.majelis') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function() {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data majelis berhasil ditambahkan!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function() {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data majelis gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function(event) {
                event.preventDefault();

                const id_majelis = $(this).data('id');
                $.ajax({
                    url: "{{ route('api.get.majelis') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id_majelis
                    },
                    success: function(majelis) {
                        var majelis = majelis.rows[0];
                        Swal.fire({
                    title: 'Edit Majelis',
                    html: `
                    <form id="addMajelisForm">
                        <div class="form-group">
                            <label for="nama_majelis">Nama Majelis</label>
                            <select id="nama_majelis" class="form-control">
                                <option value="">Pilih Nama Majelis</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jabatan_majelis">Jabatan Majelis</label>
                            <select id="jabatan_majelis" class="form-control">
                                <option value="">Pilih Jabatan Majelis</option>
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai *</label>
                            <input type="date" id="tanggal_mulai" class="form-control" value="${majelis.tanggal_mulai}" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai *</label>
                            <input type="date" id="tanggal_selesai" class="form-control" value="${majelis.tanggal_selesai}" required>
                        </div>
                        <div class="form-group">
                            <label for="no_sk">No. SK *</label>
                            <input type="text" id="no_sk" class="form-control" placeholder="Masukkan No. SK"value="${majelis.no_sk}" required>
                        </div>
                        <div class="form-group">
                            <label for="berkas">File SK *</label>
                            ${majelis.berkas_url ? `<a href="${majelis.berkas_url}" target="_blank" class="btn btn-secondary mb-2 btn-sm">Lihat File SK yang Sudah Ada</a>` : ''}
                            <input type="file" id="berkas" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                        </div>
                        <div class="form-group">
                            <label for="keterangan_status">Status Majelis *</label>
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
                        $('#nama_majelis, #jabatan_majelis, #keterangan_status').select2({
                            placeholder: "Pilih atau cari",
                            allowClear: true,
                            dropdownParent: $('.swal2-container')
                        });

                        // Load Jabatan Majelis
                        $.ajax({
                            url: "{{ route('api.get.jabatan-majelis') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(response) {
                                const $JabatanMajelis = $('#jabatan_majelis');
                                $JabatanMajelis.empty().append(
                                    '<option value="">Pilih Jabatan Majelis</option>'
                                );
                                response.forEach(value => {
                                    $JabatanMajelis.append(
                                        `<option value="${value.id_jabatan}">${value.jabatan_majelis}</option>`
                                    );
                                });
                                $('#jabatan_majelis').val(majelis.id_jabatan);
                            },
                        });

                        // Load Status Majelis
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

                                (response.rows || response).forEach(item => {
                                    $statusDropdown.append(
                                        `<option value="${item.id_status}">${item.keterangan_status}</option>`
                                    );
                                });
                                $('#keterangan_status').val(majelis.id_status);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error loading status data:", error);
                            }
                        });


                        // Load and autofill Nama Majelis from Jemaat
                        $.ajax({
                            url: "{{ route('api.get.jemaat') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                onlyName: true
                            },
                            dataType: "json",
                            success: function(response) {
                                const $namaMajelis = $('#nama_majelis');
                                $namaMajelis.empty().append(
                                    '<option value="">Pilih Nama Majelis</option>'
                                );
                                $.each(response.rows, function(key, value) {
                                    $namaMajelis.append(new Option(value
                                        .nama_jemaat, value
                                        .id_jemaat));
                                });
                                $('#nama_majelis').val(majelis.id_jemaat);
                            },
                        });
                    },
                    preConfirm: () => {
                        const data = {
                            nama_majelis: $('#nama_majelis').val(),
                            jabatan_majelis: $('#jabatan_majelis').val(),
                            tanggal_mulai: $('#tanggal_mulai').val(),
                            tanggal_selesai: $('#tanggal_selesai').val(),
                            no_sk: $('#no_sk').val(),
                            berkas: $('#berkas')[0].files[0],
                            keterangan_status: $('#keterangan_status').val()
                        };

                        // Validasi form
                        if (!data.nama_majelis || !data.tanggal_mulai || !data
                            .tanggal_selesai ||
                            !data.no_sk || !data.keterangan_status) {
                            Swal.showValidationMessage('Semua kolom harus diisi!');
                            return false;
                        }

                        if (new Date(data.tanggal_mulai) >= new Date(data.tanggal_selesai)) {
                            Swal.showValidationMessage(
                                'Tanggal mulai harus lebih kecil dari tanggal selesai!');
                            return false;
                        }

                        return data;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Gunakan FormData untuk mengirim data
                        let formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('id_majelis', id_majelis);
                        formData.append('id_jemaat', result.value.nama_majelis);
                        formData.append('id_jabatan', result.value.jabatan_majelis);
                        formData.append('tanggal_mulai', result.value.tanggal_mulai);
                        formData.append('tanggal_selesai', result.value.tanggal_selesai);
                        formData.append('no_sk', result.value.no_sk);
                        formData.append('berkas', result.value.berkas);
                        formData.append('id_status', result.value.keterangan_status);

                        $.ajax({
                            url: "{{ route('api.update.majelis') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function() {
                                alert.fire({
                                    icon: 'success',
                                    title: 'Data majelis berhasil diupdate!'
                                });
                                $table.bootstrapTable('refresh');
                            },
                            error: function() {
                                alert.fire({
                                    icon: 'error',
                                    title: 'Data majelis gagal diupdate!'
                                });
                            }
                        });
                    }
                });
                    },
                    error: function() {
                        alert.fire({
                            icon: 'error',
                            title: 'Gagal memuat data majelis!'
                        });
                    }
                });
            });

        });

        $(document).on('click', '.btn-delete', function(event) {
            event.preventDefault();
            var id_majelis = $(this).data('id');

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
                        url: `{{ route('api.delete.majelis') }}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_majelis: id_majelis
                        },
                        dataType: "json",
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data Majelis berhasil Dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data Majelis gagal dihapus!',
                                text: error
                            });
                        }
                    });
                }
            });
        });


        function ApiGetMajelis(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.majelis') }}",
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
