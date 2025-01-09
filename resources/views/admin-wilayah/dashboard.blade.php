@extends('layouts.admin-wilayah')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard Jemaat GKJ Mergangsan') }}</h1>

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form id="form" method="GET" action="{{ route('admin-wilayah.dashboard') }}" class="container mt-4">
        <div class="card p-3 shadow-sm">
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <label for="Kelamin" class="mr-2 font-weight-bold">Pilih Gender:</label>
                    <select id="Kelamin" name="Kelamin" class="custom-select" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="Laki-laki" {{ request('Kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('Kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="card shadow h-100 py-4 ml-3" style="background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 8px; padding: 8px 16px; font-size: 16px; font-weight: bold; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                    Total: {{ $totalJemaat }}
                </div>
                <div class="card shadow h-100 py-4 ml-3" style="background-color: #f9cafcaf; border: 1px solid #ddd; border-radius: 8px; padding: 8px 16px; font-size: 16px; font-weight: bold; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                    Jemaat Perempuan: {{ $perempuan }}
                </div>
                <div class="card shadow h-100 py-4 ml-3" style="background-color: #bdd9f5a9; border: 1px solid #ddd; border-radius: 8px; padding: 8px 16px; font-size: 16px; font-weight: bold; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                    Jemaat Laki-laki: {{ $laki }}
                </div>
            </div>
        </div>
    </form>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <br>
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Jemaat per Wilayah</h4>
                </div>
                <canvas id="chartJemaatPerWilayah" style="width:100%; height:300px;"></canvas>
            </div>
            <div class="col-md-4">
                <br>
                <h4>Status </h4>
                <canvas id="chartStatus" style="width:100%; height:300px; max-width: 300px; max-height: 300px;"></canvas>
            </div>
        </div>
        <div class="row">
            <form method="GET" action="{{ route('admin-wilayah.dashboard') }}" class="form-inline">
                <div class="form-group mb-2">
                    <label for="tahun" class="mr-2">Select Year:</label>
                    <input
                        type="number"
                        id="tahun"
                        name="tahun"
                        class="form-control form-control-sm mr-2"
                        value="{{ request('tahun', old('tahun', date('Y'))) }}"
                        placeholder="Enter year"
                        min="2000"
                        max="{{ date('Y') }}">
                </div>
                <input type="hidden" name="InOut" value="{{ request('InOut', '') }}">
                <button type="submit" class="btn btn-primary btn-sm mb-2">Search</button>
            </form>
            <div class="col-md-6">
                <br>
                <h4>Baptis {{$tahun}}</h4>
                <canvas id="chartBaptis" style="width:100%; height:200px;"></canvas>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Jemaat Keluar Masuk {{$tahun}}</h4>
                    <span>
                        <form id="keluarMasuk" method="GET" action="{{ route('admin-wilayah.dashboard') }}">
                            <input type="hidden" name="tahun" value="{{ request('tahun', old('tahun', date('Y'))) }}">
                            <select id="InOut" name="InOut" class="form-select" onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="Masuk" {{ request('InOut') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                                <option value="Keluar" {{ request('InOut') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </form>
                    </span>
                </div>
             <canvas id="chartKeluarMasuk" style="width:100%; height:250px;"></canvas>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    const chart1 = document.getElementById('chartJemaatPerWilayah').getContext('2d');
    const jemaatChart = new Chart(chart1, {
        type: 'bar',
        data: {
            label: 'Wilayah: ',
            labels: @json($labelWilayah),
            datasets: [{
                label: 'Jumlah Jemaat',
                data: @json($isiJemaat),
                backgroundColor: 'rgba(0, 53, 220, 0.7)',
                borderColor: 'rgba(0, 53, 220, 0.7)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    const chart2 = document.getElementById('chartStatus').getContext('2d');
    const status = new Chart(chart2, {
        type: 'doughnut',
        data: {
            labels: @json($labelStatus),
            datasets: [{
                label: 'Jumlah',
                data: @json($jumlahStatus),
                backgroundColor: [
                    'rgba(100, 251, 95, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 0, 0, 0.3)',
                    'rgba(219, 53, 53, 0.5)',
                    'rgba(172, 115, 249, 0.2)'
                ],
                borderColor: [
                    'rgba(100, 251, 95, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 0, 0, 0.7)',
                    'rgba(219, 53, 53, 0.8)',
                    'rgba(172, 115, 249, 0.8)'
                ],
                borderWidth: 1
            }]
        }
    });
    const chart3 = document.getElementById('chartBaptis').getContext('2d');
    const Baptis = new Chart(chart3, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sept','Okt','Nov','Des'],
            datasets: [{
                label: 'Baptis Anak',
                data: @json($isiBA),
                backgroundColor: 'rgba(255, 153, 153, 1)',
                borderColor: 'rgba(255, 153, 153,1)',
                borderWidth: 1
            },
            {
                label: 'Baptis Sidi',
                data: @json($isiBS),
                backgroundColor: 'rgba(255, 222, 41, 1)',
                borderColor: 'rgba(255, 222, 41, 1)',
                borderWidth: 1
            },
            {
                label: 'Baptis Dewasa',
                data: @json($isiBD),
                backgroundColor: 'rgba(153, 153, 255, 1)',
                borderColor: 'rgba(153, 153, 255, 1)',
                borderWidth: 1
            }
        ]
        },
        options: {
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: {
                        drawOnChartArea: false,
                    }
                }
            }
        }
    });
    const chart4 = document.getElementById('chartKeluarMasuk').getContext('2d');
    var selectedOption = document.getElementById('InOut').value;
    if (selectedOption === 'Masuk') {
        const keluarMasuk = new Chart(chart4, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sept','Okt','Nov','Des'],
            datasets: [{
                label: 'Atestasi Masuk',
                data: @json($isiMasuk),
                backgroundColor: 'rgba(153, 204, 255, 0.7)',
                borderColor: 'rgba(153, 204, 255, 0.7)',
                borderWidth: 1
            },{
                label: 'Baptis Anak',
                data: @json($isiBA),
                backgroundColor: 'rgba(255, 153, 153, 0.6)',
                borderColor: 'rgba(255, 153, 153, 0.6)',
                borderWidth: 1
            },{
                label: 'Baptis Dewasa',
                data: @json($isiBD),
                backgroundColor: 'rgba(57, 38, 198, 0.6)',
                borderColor: 'rgba(57, 38, 198, 0.6)',
                borderWidth: 1
            }]
        },
        options: {
            barValueSpacing: 20,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    }else if (selectedOption === 'Keluar') {
        const keluarMasuk = new Chart(chart4, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sept','Okt','Nov','Des'],
            datasets: [{
                label: 'Jemaat Meninggal',
                    data: @json($isiKematian),
                    backgroundColor: 'rgba(219, 53, 53, 0.7)',
                    borderColor: 'rgba(219, 53, 53, 0.7)',
                    borderWidth: 1
                }, {
                    label: 'Atestasi Keluar',
                    data: @json($isiKeluar),
                    backgroundColor: 'rgba(255, 0, 0, 0.8)',
                    borderColor: 'rgba(255, 0, 0, 0.8)',
                    borderWidth: 1
            }]
        },
        options: {
            barValueSpacing: 20,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    }else{
        const keluarMasuk = new Chart(chart4, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sept','Okt','Nov','Des'],
            datasets: [{
                label: 'Atestasi Masuk',
                data: @json($isiMasuk),
                backgroundColor: 'rgba(153, 204, 255, 0.7)',
                borderColor: 'rgba(153, 204, 255, 0.7)',
                borderWidth: 1,
                stack: 'group1'
            },{
                label: 'Baptis Anak',
                data: @json($isiBA),
                backgroundColor: 'rgba(255, 153, 153, 0.6)',
                borderColor: 'rgba(255, 153, 153, 0.6)',
                borderWidth: 1,
                stack: 'group1'
            },{
                label: 'Baptis Dewasa',
                data: @json($isiBD),
                backgroundColor: 'rgba(57, 38, 198, 0.6)',
                borderColor: 'rgba(57, 38, 198, 0.6)',
                borderWidth: 1,
                stack: 'group1'
            },{
                label: 'Jemaat Meninggal',
                    data: @json($isiKematian),
                    backgroundColor: 'rgba(219, 53, 53, 0.7)',
                    borderColor: 'rgba(219, 53, 53, 0.7)',
                    borderWidth: 1,
                    stack: 'group2'
                }, {
                    label: 'Atestasi Keluar',
                    data: @json($isiKeluar),
                    backgroundColor: 'rgba(255, 0, 0, 0.8)',
                    borderColor: 'rgba(255, 0, 0, 0.8)',
                    borderWidth: 1,
                    stack: 'group2'
            }]
        },
        options: {
            barValueSpacing: 20,
            responsive: true,
            scales: {
                x:{
                    stacked: true,
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    }

</script>
@endpush
