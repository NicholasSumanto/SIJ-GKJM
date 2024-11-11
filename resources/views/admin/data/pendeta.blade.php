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
                    field: 'ijazah',
                    title: 'Ijazah',
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
                        field: 'ijazah',
                        title: 'Ijazah',
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
                    <label for="namaPendeta">Nama Pendeta</label>
                    <input type="text" id="namaPendeta" class="form-control" placeholder="Masukkan Nama Pendeta">
                </div>
                <div class="form-group">
                    <label for="jenjang">Jenjang</label>
                    <input type="text" id="jenjang" class="form-control" placeholder="Masukkan Jenjang">
                </div>
                <div class="form-group">
                    <label for="sekolah">Sekolah</label>
                    <input type="text" id="sekolah" class="form-control" placeholder="Masukkan Sekolah">
                </div>
                <div class="form-group">
                    <label for="tahunLulus">Tahun Lulus</label>
                    <input type="number" id="tahunLulus" class="form-control" placeholder="Masukkan Tahun Lulus">
                </div>
                <div class="form-group">
                    <label for="ijazah">Ijazah</label>
                    <input type="text" id="ijazah" class="form-control" placeholder="Masukkan Ijazah">
                </div>
                <div class="form-group mb-0">
                    <label for="keterangan">Keterangan</label>
                    <textarea id="keterangan" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        preConfirm: () => {
            const namaPendeta = $('#namaPendeta').val();
            const jenjang = $('#jenjang').val();
            const sekolah = $('#sekolah').val();
            const tahunLulus = $('#tahunLulus').val();
            const ijazah = $('#ijazah').val();
            const keterangan = $('#keterangan').val();

            // Validate that required fields are filled in
            if (!namaPendeta || !jenjang || !sekolah || !tahunLulus) {
                Swal.showValidationMessage('Semua field yang wajib harus diisi!');
                return false;
            }

            return {
                namaPendeta,
                jenjang,
                sekolah,
                tahunLulus,
                ijazah,
                keterangan
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Extract data from result.value
            const {
                namaPendeta,
                jenjang,
                sekolah,
                tahunLulus,
                ijazah,
                keterangan
            } = result.value;

            // AJAX request to add Pendeta via ApiPostPendeta
            $.ajax({
                url: "{{ route('api.post.pendeta') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nama_pendeta: namaPendeta,
                    jenjang: jenjang,
                    sekolah: sekolah,
                    tahun_lulus: tahunLulus,
                    ijazah: ijazah,
                    keterangan: keterangan
                },
                success: function(response) {
                    if (response.message === 'Data already exists') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Data pendeta sudah ada!'
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Pendeta berhasil ditambahkan!'
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
                            <form id="editPendetaForm">
                                <div class="form-group">
                                    <label for="namaPendeta">Nama Pendeta</label>
                                    <input type="text" id="namaPendeta" class="form-control" value="${pendeta.nama_pendeta}" placeholder="Masukkan Nama Pendeta">
                                </div>
                                <div class="form-group">
                                    <label for="jenjang">Jenjang</label>
                                    <input type="text" id="jenjang" class="form-control" value="${pendeta.jenjang}" placeholder="Masukkan Jenjang">
                                </div>
                                <div class="form-group">
                                    <label for="sekolah">Sekolah</label>
                                    <input type="text" id="sekolah" class="form-control" value="${pendeta.sekolah}" placeholder="Masukkan Sekolah">
                                </div>
                                <div class="form-group">
                                    <label for="tahunLulus">Tahun Lulus</label>
                                    <input type="number" id="tahunLulus" class="form-control" value="${pendeta.tahun_lulus}" placeholder="Masukkan Tahun Lulus">
                                </div>
                                <div class="form-group">
                                    <label for="ijazah">Ijazah</label>
                                    <input type="text" id="ijazah" class="form-control" value="${pendeta.ijazah}" placeholder="Masukkan Ijazah">
                                </div>
                                <div class="form-group mb-0">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea id="keterangan" class="form-control" placeholder="Masukkan Keterangan">${pendeta.keterangan}</textarea>
                                </div>
                            </form>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Save',
                        cancelButtonText: 'Cancel',
                        preConfirm: () => {
                            const namaPendeta = $('#namaPendeta').val();
                            const jenjang = $('#jenjang').val();
                            const sekolah = $('#sekolah').val();
                            const tahunLulus = $('#tahunLulus').val();
                            const ijazah = $('#ijazah').val();
                            const keterangan = $('#keterangan').val();

                            // Validate input
                            if (!namaPendeta || !jenjang || !sekolah || !tahunLulus) {
                                Swal.showValidationMessage(
                                    'Terdapat bagian yang tidak valid atau belum diisi!'
                                );
                                return false;
                            }

                            return new Promise((resolve, reject) => {
                                resolve({
                                    id_pendeta: id_pendeta,
                                    nama_pendeta: namaPendeta,
                                    jenjang: jenjang,
                                    sekolah: sekolah,
                                    tahun_lulus: tahunLulus,
                                    ijazah: ijazah,
                                    keterangan: keterangan
                                });
                            }).catch(error => {
                                Swal.showValidationMessage(error);
                            });
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
                                keterangan
                            } = result.value;

                            // Send AJAX request to update the Pendeta
                            $.ajax({
                                url: "{{ route('api.update.pendeta') }}",
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id_pendeta: id_pendeta,  
                                    nama_pendeta: nama_pendeta,
                                    jenjang: jenjang,
                                    sekolah: sekolah,
                                    tahun_lulus: tahun_lulus,
                                    ijazah: ijazah,
                                    keterangan: keterangan
                                },
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
