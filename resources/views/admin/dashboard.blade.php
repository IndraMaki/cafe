@extends('admin.layouts.admin')

@section('content')
<div class="p-6">
    {{-- Greeting --}}
    <h2 class="text-2xl font-semibold mb-3"><span class="text-yellow-600">Selamat Datang!,</span> {{ $admin->username }}</h2>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="p-4 bg-white rounded shadow-md text-center text-white bg-[url('/assets/img/bg-card.png')] bg-cover bg-center">
            <h2 class="text-sm font-medium ">Total Pendapatan</h2>
            <p class="text-xl font-semibold">
                Rp {{ number_format($pendapatanHarian, 0, ',', '.') }}
            </p>
        </div>
        <div class="p-4 bg-white rounded shadow-md text-center">
            <h2 class="text-sm font-medium text-gray-500">Total Meja</h2>
            <p class="text-xl font-semibold text-gray-700">{{ $totalMeja }}</p>
        </div>
        <div class="p-4 bg-white rounded shadow-md text-center">
            <h2 class="text-sm font-medium text-gray-500">Banyaknya Pengunjung</h2>
            <p class="text-xl font-semibold text-gray-700">{{ $totalPengunjung }}</p>
        </div>

    </div>

    {{-- Chart Section --}}
    <div class="bg-white p-6 rounded-2xl shadow-md transition-all">
        <h2 class="text-xl font-bold text-gray-800 mb-1">📊 Laporan Pendapatan</h2>
        <p class="text-gray-500 mb-4 text-sm">Data pendapatan harian selama 1 bulan terakhir</p>

        {{-- Chart Box --}}
        <div class="h-64 rounded-xl p-4 bg-gradient-to-br from-purple-50 to-white">
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
                        borderColor: '#7C3AED',
                        backgroundColor: 'rgba(124, 58, 237, 0.2)',
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
                            labels: {
                                color: '#4B5563',
                                font: {
                                    size: 14
                                }
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        </script>
    </div>
</div>
@endsection
