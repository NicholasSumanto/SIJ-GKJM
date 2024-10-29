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

        <div class="col-xl-1 col-md-2 mb-2">
            <div class="card border-left-danger shadow h-85 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-danger text-uppercase mb-2">Semua</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalJemaat }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-1 col-md-2 mb-2">
            <div class="card border-left-danger shadow h-85 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-danger text-uppercase mb-1">Rata-rata</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($rataRataUsia, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-1 col-md-2 mb-2">
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

        <div class="col-xl-1 col-md-2 mb-2">
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

        <div class="col-xl-1 col-md-2 mb-2">
            <div class="card border-left-success shadow h-85 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-success text-uppercase mb-1">Anak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlahAnak}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-1 col-md-2 mb-2">
            <div class="card border-left-success shadow h-85 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-success text-uppercase mb-1">Dewasa</div>
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
                    <h4>Kategori Usia</h4>
                    <canvas id="ageGroupChart" style="width:100%; height:300px;  max-width: 500px; max-height: 300px;"></canvas>
                </div>
                <div class="col-md-6">
                    <br>
                    <h4>Usia dan Wilayah</h4>
                    <canvas id="ageGeo" style="width:100%; height:300px;  max-width: 500px; max-height: 300px;"></canvas>
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
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Jemaat',
                data: @json($data),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(255, 90, 94, 0.7)'
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
</script>
@endpush
