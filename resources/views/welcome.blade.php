@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Grafik Penjualan Harian</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="penjualanChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Grafik Penjualan per Kategori</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="kategoriChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function() {
            // Grafik Penjualan Harian
            var ctx = document.getElementById('penjualanChart').getContext('2d');
            var penjualanChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Total Penjualan',
                        data: @json($data),
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Total: Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Grafik Penjualan per Kategori
            var ctx2 = document.getElementById('kategoriChart').getContext('2d');
            var kategoriChart = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: @json($kategoriLabels),
                    datasets: [{
                        data: @json($kategoriData),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': Rp ' + context.raw.toLocaleString(
                                        'id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
