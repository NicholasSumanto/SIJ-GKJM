@extends('layouts.admin-wilayah')

@section('main-content')
    <div class="card-body p-3 shadow" style="background: #fff; border-radius: 3px;">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

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

        <form id="form" method="GET" action="{{ route('admin-wilayah.dashboard') }}">
            <label for="Kelamin">Pilih Gender:</label>
            <select id="Kelamin" name="Kelamin" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="Laki-laki" {{ request('Kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ request('Kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </form>
        
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <br>
                    <h4>Jemaat per Wilayah</h4>
                    <canvas id="chartJemaatPerWilayah" style="width:100%; height:200px;"></canvas>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Jemaat Keluar Masuk {{ $tahun }}</h4>
                        <span>
                            <form id="keluarMasuk" method="GET" action="{{ route('admin-wilayah.dashboard') }}">
                                <select id="InOut" name="InOut" class="form-select" onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <option value="Masuk" {{ request('InOut') == 'Masuk' ? 'selected' : '' }}>Masuk
                                    </option>
                                    <option value="Keluar" {{ request('InOut') == 'Keluar' ? 'selected' : '' }}>Keluar
                                    </option>
                                </select>
                            </form>
                        </span>
                    </div>
                    <canvas id="chartKeluarMasuk" style="width:100%; height:250px;"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <br>
                    <h4>Baptis {{ $tahun }}</h4>
                    <canvas id="chartBaptis" style="width:100%; height:200px;"></canvas>
                </div>
                <div class="col-md-4">
                    <br>
                    <h4>Pendidikan</h4>
                    <canvas id="chartPendidikan" style="width:100%; height:50px;"></canvas>
                </div>
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
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
        const chart2 = document.getElementById('chartKeluarMasuk').getContext('2d');
        var selectedOption = document.getElementById('InOut').value;
        if (selectedOption === 'Masuk') {
            const keluarMasuk = new Chart(chart2, {
                type: 'bar',
                data: {
                    labels: @json($labelBulan),
                    datasets: [{
                        label: 'Atestasi Masuk',
                        data: @json($isiMasuk),
                        backgroundColor: 'rgba(153, 204, 255, 0.7)',
                        borderColor: 'rgba(153, 204, 255, 0.7)',
                        borderWidth: 1
                    }, {
                        label: 'Baptis Anak',
                        data: @json($isiBA),
                        backgroundColor: 'rgba(255, 153, 153, 0.6)',
                        borderColor: 'rgba(255, 153, 153, 0.6)',
                        borderWidth: 1
                    }, {
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
        } else if (selectedOption === 'Keluar') {
            const keluarMasuk = new Chart(chart2, {
                type: 'bar',
                data: {
                    labels: @json($labelBulan),
                    datasets: [{
                        label: 'Jemaat Meninggal',
                        data: @json($isiKematian),
                        backgroundColor: 'rgba(185, 0, 0, 0.8)',
                        borderColor: 'rgba(185, 0, 0, 0.8)',
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
        } else {
            const keluarMasuk = new Chart(chart2, {
                type: 'bar',
                data: {
                    labels: @json($labelBulan),
                    datasets: [{
                        label: 'Atestasi Masuk',
                        data: @json($isiMasuk),
                        backgroundColor: 'rgba(153, 204, 255, 0.7)',
                        borderColor: 'rgba(153, 204, 255, 0.7)',
                        borderWidth: 1,
                        stack: 'group1'
                    }, {
                        label: 'Baptis Anak',
                        data: @json($isiBA),
                        backgroundColor: 'rgba(255, 153, 153, 0.6)',
                        borderColor: 'rgba(255, 153, 153, 0.6)',
                        borderWidth: 1,
                        stack: 'group1'
                    }, {
                        label: 'Baptis Dewasa',
                        data: @json($isiBD),
                        backgroundColor: 'rgba(57, 38, 198, 0.6)',
                        borderColor: 'rgba(57, 38, 198, 0.6)',
                        borderWidth: 1,
                        stack: 'group1'
                    }, {
                        label: 'Jemaat Meninggal',
                        data: @json($isiKematian),
                        backgroundColor: 'rgba(185, 0, 0, 0.8)',
                        borderColor: 'rgba(185, 0, 0, 0.8)',
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
                        x: {
                            stacked: true,
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        const chart3 = document.getElementById('chartBaptis').getContext('2d');
        const Baptis = new Chart(chart3, {
            type: 'line',
            data: {
                labels: @json($labelBaptis),
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
        const chart4 = document.getElementById('chartPendidikan').getContext('2d');
        const pendidikan = new Chart(chart4, {
            type: 'pie',
            data: {
                labels: @json($labelPendidikan),
                datasets: [{
                    label: 'kkm',
                    data: @json($isiPendidikan),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
@endpush
