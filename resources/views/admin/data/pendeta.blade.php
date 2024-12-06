@extends('layouts.admin-main-data')

@section('title', 'Pendeta')

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
        <a href="" class="btn btn-success tambah-pendeta">Tambah Pendeta</a>
        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-filter-control="true" data-ajax="ApiGetPendeta">
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
                    field: 'nama_pendeta',
                    title: 'Nama Pendeta',
                    align: 'center'
                }, {
                    field: 'jenjang',
                    title: 'Jenjang',
                    align: 'center'
                }, {
                    field: 'sekolah',
                    title: 'Sekolah',
                    align: 'center'
                }, {
                    field: 'tahun_lulus',
                    title: 'Tahun Lulus',
                    filterControl: 'select',
                    align: 'center'
                }, {
                    field: 'keterangan',
                    title: 'Keterangan',
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
                    field: 'ijazah',
                    title: 'Ijazah',
                    formatter: function(value, row, index) {
                        const fileUrl = `/storage/${value}`;

                        return `
                            <button class="btn btn-primary">
                                <a href="${fileUrl}" target="_blank" style="color:white; text-decoration:none;">Lihat Ijazah</a>
                            </button>
                        `;
                    },
                    align: 'center'
                }, {
                    field: 'keterangan_status',
                    title: 'Status',
                    align: 'center'
                }, {
                    field: 'edit',
                    title: 'Edit',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-warning btn-edit" data-id="${row.id_pendeta}" data-name="${row.name}">Edit</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'delete',
                    title: 'Delete',
                    formatter: function(value, row, index) {
                        return `<button class="btn btn-danger btn-delete" data-id="${row.id_pendeta}">Delete</button>`;
                    },
                    align: 'center'
                }],
                exportOptions: {
                    ignoreColumns: [6, 7]
                }
            });

            // Handle perubahan toolbar select
            $('#toolbar').find('select').change(function() {
                var exportDataType = $(this).val();
                $table.bootstrapTable('refreshOptions', {
                    exportDataType: exportDataType,
                    exportTypes: ['excel', 'pdf'],
                    columns: [{
                        field: 'nama_pendeta',
                        title: 'Nama Pendeta',
                        align: 'center'
                    }, {
                        field: 'jenjang',
                        title: 'Jenjang',
                        align: 'center'
                    }, {
                        field: 'sekolah',
                        title: 'Sekolah',
                        align: 'center'
                    }, {
                        field: 'tahun_lulus',
                        title: 'Tahun Lulus',
                        align: 'center'
                    }, {
                        field: 'keterangan',
                        title: 'Keterangan',
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
                        field: 'ijazah',
                        title: 'Ijazah',
                        formatter: function(value, row, index) {
                            const fileUrl = `/storage/${value}`;

                            return `
                                <button class="btn btn-primary">
                                    <a href="${fileUrl}" target="_blank" style="color:white; text-decoration:none;">Lihat Ijazah</a>
                                </button>
                            `;
                        },
                        align: 'center'
                    }, {
                        field: 'keterangan_status',
                        title: 'Status',
                        align: 'center'
                    }, {
                        field: 'edit',
                        title: 'Edit',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-warning btn-edit" data-id="${row.id_pendeta}" data-name="${row.name}">Edit</button>`;
                        },
                        align: 'center'
                    }, {
                        field: 'delete',
                        title: 'Delete',
                        formatter: function(value, row, index) {
                            return `<button class="btn btn-danger btn-delete" data-id="${row.id_pendeta}">Delete</button>`;
                        },
                        align: 'center'
                    }],
                    exportOptions: {
                        ignoreColumns: [6, 7]
                    }
                });
            }).trigger('change');

            // Event listener untuk tombol tambah Pendeta
            $('.tambah-pendeta').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Tambah Pendeta Baru',
                    html: `
                        <form id="addPendetaForm">
                            <div class="form-group">
                                <label for="namaPendeta">Nama Pendeta *</label>
                                <input type="text" id="namaPendeta" class="form-control" placeholder="Masukkan Nama Pendeta">
                            </div>
                            <div class="form-group">
                                <label for="jenjang">Jenjang *</label>
                                <input type="text" id="jenjang" class="form-control" placeholder="Masukkan Jenjang">
                            </div>
                            <div class="form-group">
                                <label for="sekolah">Sekolah *</label>
                                <input type="text" id="sekolah" class="form-control" placeholder="Masukkan Sekolah">
                            </div>
                            <div class="form-group">
                                <label for="tahunLulus">Tahun Lulus</label>
                                <input type="number" id="tahunLulus" class="form-control" placeholder="Masukkan Tahun Lulus">
                            </div>
                            <div class="form-group">
                                <label for="ijazah">Ijazah</label>
                                <input type="file" id="ijazah" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                            </div>
                            <div class="form-group mb-0">
                                <label for="keterangan">Keterangan</label>
                                <textarea id="keterangan" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai *</label>
                                <input type="date" id="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" id="tanggal_selesai" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="keterangan_status">Status Pendeta *</label>
                                <select id="keterangan_status" class="form-control" required>
                                    <option value="">Pilih status</option>
                                    <!-- Status will be loaded via AJAX -->
                                </select>
                            </div>
                        </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        // Load status options via AJAX
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
                    },
                    preConfirm: () => {
                        const data = {
                            namaPendeta: $('#namaPendeta').val(),
                            jenjang: $('#jenjang').val(),
                            sekolah: $('#sekolah').val(),
                            tahunLulus: $('#tahunLulus').val(),
                            ijazah: $('#ijazah')[0].files[0],
                            tanggal_mulai: $('#tanggal_mulai').val(),
                            tanggal_selesai: $('#tanggal_selesai').val(),
                            keterangan_status: $('#keterangan_status').val(),
                            keterangan: $('#keterangan').val()
                        };

                        // Validate required fields
                        if (
                            !data.namaPendeta ||
                            !data.jenjang ||
                            !data.sekolah ||
                            !data.tanggal_mulai ||
                            !data.keterangan_status
                        ) {
                            Swal.showValidationMessage('Semua field yang wajib harus diisi!');
                            return false;
                        }

                        return data;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Prepare FormData
                        let formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('nama_pendeta', result.value.namaPendeta);
                        formData.append('jenjang', result.value.jenjang);
                        formData.append('sekolah', result.value.sekolah);
                        formData.append('tahun_lulus', result.value.tahunLulus);
                        formData.append('id_status', result.value.keterangan_status);
                        formData.append('tanggal_mulai', result.value.tanggal_mulai);
                        formData.append('tanggal_selesai', result.value.tanggal_selesai);
                        formData.append('ijazah', result.value.ijazah);
                        formData.append('keterangan', result.value.keterangan);

                        // AJAX request to add Pendeta
                        $.ajax({
                            url: "{{ route('api.post.pendeta') }}",
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.message === 'Data already exists') {
                                    alert.fire({
                                        icon: 'error',
                                        title: 'Data pendeta sudah ada!'
                                    });
                                } else {

                                    alert.fire({
                                        icon: 'success',
                                        title: 'Pendeta berhasil ditambahkan!'
                                    });
                                    $table.bootstrapTable('refresh');
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Data pendeta gagal ditambahkan!'
                                });
                            }
                        });
                    }
                });
            });

            // Event listener untuk tombol edit
            $(document).on('click', '.btn-edit', function() {
                event.preventDefault();
                var id_pendeta = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.get.pendeta') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id_pendeta
                    },
                    dataType: "json",
                    success: function(response) {
                        var pendeta = response.rows[0];

                        Swal.fire({
                            title: 'Edit Pendeta',
                            html: `
                        <form id="addPendetaForm">
                            <div class="form-group">
                                <label for="namaPendeta">Nama Pendeta *</label>
                                <input type="text" id="namaPendeta" class="form-control" value="${pendeta.nama_pendeta}" placeholder="Masukkan Nama Pendeta">
                            </div>
                            <div class="form-group">
                                <label for="jenjang">Jenjang *</label>
                                <input type="text" id="jenjang" class="form-control" value="${pendeta.jenjang}" placeholder="Masukkan Jenjang">
                            </div>
                            <div class="form-group">
                                <label for="sekolah">Sekolah *</label>
                                <input type="text" id="sekolah" class="form-control" value="${pendeta.sekolah}" placeholder="Masukkan Sekolah">
                            </div>
                            <div class="form-group">
                                <label for="tahunLulus">Tahun Lulus</label>
                                <input type="number" id="tahunLulus" class="form-control" value="${pendeta.tahun_lulus}" placeholder="Masukkan Tahun Lulus">
                            </div>
                            <div class="form-group">
                                <label for="ijazah">Ijazah</label>
                                 ${pendeta.ijazah_url ? `<a href="${pendeta.ijazah_url}" target="_blank" class="btn btn-secondary mb-2 btn-sm">Lihat File ijazah yang Sudah Ada</a>` : ''}
                                <input type="file" id="ijazah" class="form-control" accept=".pdf, .jpg, .jpeg, .png">
                            </div>
                            <div class="form-group mb-0">
                                <label for="keterangan">Keterangan</label>
                                <textarea id="keterangan" class="form-control" placeholder="Masukkan Keterangan">${pendeta.keterangan}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai *</label>
                                <input type="date" id="tanggal_mulai" class="form-control" value="${pendeta.tanggal_mulai}" >
                            </div>
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" id="tanggal_selesai" class="form-control" value="${pendeta.tanggal_selesai}">
                            </div>
                            <div class="form-group">
                                <label for="keterangan_status">Status Pendeta *</label>
                                <select id="keterangan_status" class="form-control" value="${pendeta.keterangan_status}" >
                                    <option value="">Pilih status</option>
                                    <!-- Status will be loaded via AJAX -->
                                </select>
                            </div>
                        </form>
                    `,
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                            cancelButtonText: 'Cancel',
                            didOpen: () => {
                                // Load status options via AJAX
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
                                        $('#keterangan_status').val(
                                            pendeta.id_status);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(
                                            "Error loading status data:",
                                            error);
                                    }
                                });
                            },
                            preConfirm: () => {
                                const data = {
                                    nama_pendeta: $('#namaPendeta').val(),
                                    id_pendeta: id_pendeta,
                                    jenjang: $('#jenjang').val(),
                                    sekolah: $('#sekolah').val(),
                                    tahun_lulus: $('#tahunLulus').val(),
                                    ijazah: $('#ijazah')[0].files[0],
                                    tanggal_mulai: $('#tanggal_mulai').val(),
                                    tanggal_selesai: $('#tanggal_selesai')
                                    .val(),
                                    keterangan_status: $('#keterangan_status')
                                        .val(),
                                    keterangan: $('#keterangan').val()
                                };

                                // Validate required fields
                                if (
                                    !data.nama_pendeta ||
                                    !data.jenjang ||
                                    !data.sekolah ||
                                    !data.tanggal_mulai ||
                                    !data.keterangan_status
                                ) {
                                    Swal.showValidationMessage(
                                        'Semua field yang wajib harus diisi!');
                                    return false;
                                }

                                return data;
                            }
                        }).then((result) => {
                            if (result.isConfirmed && result.value) {
                                const {
                                    id_pendeta,
                                    nama_pendeta,
                                    jenjang,
                                    sekolah,
                                    tahun_lulus,
                                    ijazah,
                                    tanggal_mulai,
                                    tanggal_selesai,
                                    keterangan_status,
                                    keterangan
                                } = result.value;

                                const formData = new FormData();
                                formData.append('_token', '{{ csrf_token() }}');
                                formData.append('id_pendeta', id_pendeta);
                                formData.append('nama_pendeta', nama_pendeta);
                                formData.append('jenjang', jenjang);
                                formData.append('sekolah', sekolah);
                                formData.append('tahun_lulus', tahun_lulus);
                                if(ijazah) formData.append('ijazah', ijazah);
                                formData.append('tanggal_mulai', tanggal_mulai);
                                formData.append('tanggal_selesai', tanggal_selesai);
                                formData.append('id_status', keterangan_status);
                                formData.append('keterangan', keterangan);

                                // Send AJAX request to update the Pendeta
                                $.ajax({
                                    url: "{{ route('api.update.pendeta') }}",
                                    type: 'POST',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        alert.fire({
                                            icon: 'success',
                                            title: 'Pendeta berhasil diubah!',
                                        });
                                        $table.bootstrapTable('refresh');
                                    },
                                    error: function(xhr, status, error) {
                                        alert.fire({
                                            icon: 'error',
                                            title: 'Pendeta gagal diubah!',
                                        });
                                    }
                                });
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                        console.error("Status: " + status);
                        console.dir(xhr);
                    }
                });
            });
        });

        $(document).on('click', '.btn-delete', function() {
            event.preventDefault();
            var id_pendeta = $(this).data('id');

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
                        url: "{{ route('api.delete.pendeta') }}",
                        type: 'POST',
                        data: {
                            id: id_pendeta,
                            _token: '{{ csrf_token() }}'

                        },
                        dataType: "json",
                        success: function(response) {
                            alert.fire({
                                icon: 'success',
                                title: 'Data Pendeta berhasil dihapus!'
                            });
                            $table.bootstrapTable('refresh');
                        },
                        error: function(xhr, status, error) {
                            alert.fire({
                                icon: 'error',
                                title: 'Data Pendeta gagal dihapus!'
                            });
                        }
                    });
                }
            });
        });

        function ApiGetPendeta(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.pendeta') }}",
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
