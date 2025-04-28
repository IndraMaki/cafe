@extends('admin.layouts.admin')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    {{-- Greeting --}}
    <h1>Selamat Datang, {{ $admin->username }}</h1>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="p-4 bg-white rounded shadow text-center">
            <h2 class="text-sm font-medium text-gray-500">Total Pendapatan</h2>
            <p class="text-lg font-semibold text-gray-700">
                Rp {{ number_format($pendapatanHarian, 0, ',', '.') }}
            </p>
        </div>
        <div class="p-4 bg-white rounded shadow text-center">
            <h2 class="text-sm font-medium text-gray-500">Total Meja</h2>
            <p class="text-lg font-semibold text-gray-700">{{ $totalMeja }}</p>
        </div>
        <div class="p-4 bg-white rounded shadow text-center">
            <h2 class="text-sm font-medium text-gray-500">Banyaknya Pengunjung</h2>
            <p class="text-lg font-semibold text-gray-700">{{ $totalPengunjung }}</p>
        </div>

    </div>

    {{-- Chart Section --}}
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Report selama 1 bulan</h2>
        {{-- Dummy Chart Box --}}
        <div class="h-64 bg-white rounded shadow p-4">
            <canvas id="pendapatanChart"></canvas>
        </div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('pendapatanChart').getContext('2d');
            const pendapatanChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dates) !!},
                    datasets: [{
                        label: 'Pendapatan Harian',
                        data: {!! json_encode($pendapatan) !!},
                        fill: true,
                        borderColor: '#7C3AED', // ungu
                        backgroundColor: 'rgba(124, 58, 237, 0.2)', // warna latar
                        tension: 0.3,
                        pointBackgroundColor: '#7C3AED',
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: {
                            ticks: {
                                autoSkip: true,
                                maxTicksLimit: 15
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    }
                }
            });
        </script>

    </div>
</div>
@endsection
