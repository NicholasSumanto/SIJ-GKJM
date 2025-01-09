@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard Usia') }}</h1>

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
    <div class="row">

        <div class="col-xl-2 col-md-2 mb-2">
            <div class="card border-left-danger shadow h-85 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-danger text-uppercase mb-2">Total Jemaat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalJemaat }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-2 mb-2">
            <div class="card border-left-danger shadow h-85 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-danger text-uppercase mb-1">Rata-rata Usia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($rataRataUsia, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-2 mb-2">
            <div class="card border-left-primary shadow h-85 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1">Termuda</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$termuda}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-2 mb-2">
            <div class="card border-left-primary shadow h-85 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-primary text-uppercase mb-2">Tertua</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$tertua}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-2 mb-2">
            <div class="card border-left-success shadow h-85 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-success text-uppercase mb-1">Jumlah Anak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlahAnak}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-2 mb-2">
            <div class="card border-left-success shadow h-85 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-success text-uppercase mb-1">Jumlah Dewasa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlahDewasa}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <br>
                    <h4>Kategori Usia Berdasarkan Komisi</h4>
                    <canvas id="ageGroupChart" style="width:100%; height:300px;  max-width: 500px; max-height: 300px;"></canvas>
                </div>
                <div class="col-md-6">
                    <br>
                    <h4>Usia dan Wilayah</h4>
                    <canvas id="ageGeo" style="width:100%; height:300px;  max-width: 500px; max-height: 300px;"></canvas>
                </div>
            </div>
            <div class="row" >
                <div  class="col-md-6">
                    <br>
                    <h4>Rata-Rata Usia</h4>
                    <canvas id="chartAverageAgePerWilayah" style="width:100%; height:300px;  max-width: 500px; max-height: 300px;"></canvas>
                </div>
                <div  class="col-md-6">
                    <br>
                    <h4>Baptis</h4>
                    <canvas id="chartBaptis" style="width:100%; height:300px;  max-width: 500px; max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3"></script>
<script>
    const chart1 = document.getElementById('ageGroupChart').getContext('2d');
    const ageGroupChart = new Chart(chart1, {
        type: 'doughnut',
        data: {
            labels: ['Sekolah Minggu Kecil (<6th)', 'Sekolah Minggu Besar (7-15th)', 'Remaja (16-18th)','Pemuda (19-30th)','Dewasa Muda (31-39th)','Dewasa (40-59th)','Lansia (>60th)'
            ],
            datasets: [{
                label: 'Jumlah Jemaat',
                data: @json($isiData),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 25, 60, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(54, 102, 219, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                    
            ],
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
    const chart2 = document.getElementById('ageGeo').getContext('2d');
    const usiaChart = new Chart(chart2, {
        type: 'bar',
        data: {
            labels: @json($wilayahLabels),
            datasets: [
                {
                    label: 'Anak',
                    data: @json($anakCounts),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Dewasa',
                    data: @json($dewasaCounts),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const chart3 = document.getElementById('chartAverageAgePerWilayah').getContext('2d');
    const avgChart = new Chart(chart3, {
        type: 'bar',
        data: {
            labels: @json($avgLabel),
            datasets: [
                {
                    label: 'Wilayah',
                    data: @json($avgData),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    const chart4 = document.getElementById('chartBaptis').getContext('2d');
    const baptisChart = new Chart(chart4, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sept', 'Okt', 'Nov', 'Des'], 
            datasets: [
                {
                    label: 'Anak Sudah Baptis',
                    data: @json($ba->pluck('jumlah')->toArray()),
                    backgroundColor: 'rgba(255, 153, 153, 0.2)',
                    borderColor: 'rgba(255, 153, 153, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Anak Belum Baptis',
                    data: @json($ba->pluck('jumlah')->toArray()),
                    backgroundColor: 'rgba(185, 0, 0, 0.2)',
                    borderColor: 'rgba(155, 0, 0, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Dewasa Sudah Baptis Sidi',
                    data: @json($bs->pluck('jumlah')->toArray()),
                    backgroundColor: 'rgba(255, 222, 41, 0.2)',
                    borderColor: 'rgba(255, 222, 41, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Dewasa Belum Baptis Sidi',
                    data: @json($bs->pluck('jumlah')->toArray()),
                    backgroundColor: 'rgba(220, 0, 0, 0.2)',
                    borderColor: 'rgba(220, 0, 0, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Dewasa Baptis',
                    data: @json($bd->pluck('jumlah')->toArray()),
                    backgroundColor: 'rgba(153, 153, 255, 0.2)',
                    borderColor: 'rgba(153, 153, 255, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Dewasa Belum Baptis',
                    data: @json($bd->pluck('jumlah')->toArray()),
                    backgroundColor: 'rgba(85, 0, 0, 0.2)',
                    borderColor: 'rgba(85, 0, 0, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah',
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan',
                    }
                }
            }
        }
    });
</script>
@endpush
