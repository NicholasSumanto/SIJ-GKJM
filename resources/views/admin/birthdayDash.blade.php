@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard Ulangtahun') }}</h1>

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

    <!-- Filter Form -->
    <form id="filterForm" method="GET" action="{{ route('admin.birthdayDash') }}" class="container mt-4">
        <div class="card p-3 shadow-sm">
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <label for="start_date" class="mr-2 font-weight-bold">Tanggal Awal:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-auto">
                    <label for="end_date" class="mr-2 font-weight-bold">Tanggal Akhir:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-auto mt-2">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <button type="button" class="btn btn-danger" onclick="resetDate()">Reset</button>
                </div>
            </div>
        </div>
    </form>

    <div class="container mt-4">
        <div class="row">
            <!-- Jemaat Ulangtahun Chart & Table -->
            <div class="col-md-8">
                <h4 class="mt-4">Ulangtahun Jemaat</h4>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button class="btn btn-secondary" onclick="resetTables()">Show All Wilayah</button>
                        <canvas id="chartJemaatPerWilayah" style="width:100%; height:300px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="mt-4">Jemaat Ulangtahun</h4>
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if($pagination->isNotEmpty())
                            <table class="table table-striped table-bordered" id="jemaatTable">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Wilayah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pagination as $data)
                                        <tr>
                                            <td>{{ $data->nama_jemaat ?? 'N/A' }}</td>
                                            <td>{{ $data->tanggal_lahir ?? 'N/A' }}</td>
                                            <td>{{ $data->wil ?? 'Tidak Ada Wilayah' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $pagination->links('admin.custom-pagination') }}
                            </div>
                        @else
                            <p class="text-danger">Data tidak ditemukan untuk rentang tanggal tersebut.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Pernikahan Ulangtahun Chart & Table -->
            <div class="col-md-8">
                <h4 class="mt-4">Ulangtahun Pernikahan</h4>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button class="btn btn-secondary" onclick="resetTables()">Show All Wilayah</button>
                        <canvas id="chartMarried" style="width:100%; height:300px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="mt-4"> Ulangtahun Pernikahan</h4>
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if($paginationMarried->isNotEmpty())
                            <table class="table table-striped table-bordered" id="marriedTable">
                                <thead>
                                    <tr>
                                        <th>Nama Pengantin Pria</th>
                                        <th>Nama Pengantin Wanita</th>
                                        <th>Tanggal Nikah</th>
                                        <th>Wilayah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paginationMarried as $data)
                                        <tr>
                                            <td>{{ $data->pengantin_pria ?? 'N/A' }}</td>
                                            <td>{{ $data->pengantin_wanita ?? 'N/A' }}</td>
                                            <td>{{ $data->tanggal_nikah ?? 'N/A' }}</td>
                                            <td class="wilayah">{{ $data->nama_wilayah }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">                       
                                {{ $paginationMarried->links('admin.custom-pagination') }}
                            </div>
                        @else
                            <p class="text-danger">Data tidak ditemukan untuk rentang tanggal tersebut.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Utility to reset date inputs and reload the form
    function resetDate() {
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
        document.getElementById('filterForm').submit();
    }

    // Filters jemaat table based on wilayah selected in the chart
    function filterTableByWilayah(wilayah, tableId) {
        const rows = document.querySelectorAll(`#${tableId} tbody tr`);
        rows.forEach(row => {
            const wilayahCell = row.querySelector('.wilayah') || row.querySelector('td:nth-child(3)');
            row.style.display = wilayahCell && wilayahCell.textContent.trim() === wilayah ? '' : 'none';
        });
    }

    // Resets both tables
    function resetTables() {
        document.querySelectorAll('table tbody tr').forEach(row => row.style.display = '');
    }

    // Jemaat Chart
    const chartJemaatCtx = document.getElementById('chartJemaatPerWilayah').getContext('2d');
    const jemaatChart = new Chart(chartJemaatCtx, {
        type: 'bar',
        data: {
            labels: @json($labelWilayah),
            datasets: [{
                label: 'Jumlah Jemaat',
                data: @json($dataCount),
                backgroundColor: 'rgba(0, 53, 220, 0.7)',
                borderColor: 'rgba(0, 53, 220, 1)',
                borderWidth: 1
            }]
        },
        options: {
            onClick: (event, elements) => {
                if (elements.length > 0) {
                    const selectedIndex = elements[0].index;
                    const selectedWilayah = jemaatChart.data.labels[selectedIndex];
                    filterTableByWilayah(selectedWilayah, 'jemaatTable');
                }
            }
        }
    });

    // Pernikahan Chart
    const chartMarriedCtx = document.getElementById('chartMarried').getContext('2d');
    const chartMarried = new Chart(chartMarriedCtx, {
        type: 'bar',
        data: {
            labels: @json($wilayahNames),
            datasets: [{
                label: 'Total Weddings',
                data: @json($weddingCounts),
                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            onClick: function(evt, elements) {
                if (elements.length > 0) {
                    const selectedIndex = elements[0].index;
                    const selectedWilayah = chartMarried.data.labels[selectedIndex];
                    filterTableByWilayah(selectedWilayah, 'marriedTable');
                }
            }
        }
    });
</script>
@endpush
