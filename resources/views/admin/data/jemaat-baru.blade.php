@extends('layouts.admin-main-data')

@section('title', 'Jemaat Baru')

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
                <li class="breadcrumb-item active" aria-current="page">Daftar Jemaat</li>
            </ol>
        </nav>

        <div class="alert alert-success" role="alert">
            Data dibawah ini adalah data jemaat baru yang di input oleh admin wilayah.
            Sehingga admin harus melakukan validasi, data jemaat yang masuk.
        </div>

        <div id="toolbar" class="select">
            <select class="form-control">
                <option value="">Export (Hanya yang Ditampilkan)</option>
                <option value="all">Export (Semua)</option>
                <option value="selected">Export (Yang Dipilih)</option>
            </select>
        </div>
        <table id="table" data-show-export="true" data-pagination="true" data-click-to-select="true"
            data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-columns="true"
            data-filter-control="true" data-ajax="ApiGetJemaatBaru">
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
                        return `<button class="btn btn-primary btn-view" data-id_jemaat="${row.id_jemaat}">View</button>`;
                    },
                    align: 'center'
                }, {
                    field: 'validasi',
                    title: 'Status',
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
                            return `<button class="btn btn-primary btn-view" data-id_jemaat="${row.id_jemaat}">View</button>`;
                        },
                        align: 'center'

                    }, {
                        field: 'validasi',
                        title: 'Status',
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

                var url = '{{ route('admin.data.anggota-jemaat-baru-keluarga-detail', ':id') }}';
                url = url.replace(':id', id_jemaat);

                window.location.href = url;
            });
        });

        function ApiGetJemaatBaru(params) {
            $.ajax({
                type: "POST",
                url: "{{ route('api.get.jemaat') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    // onlyName: true,
                    baru: true
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
