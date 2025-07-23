@extends('main.master')

@section('title', 'Payment Graph')

@section('content')
<div class="content-body">
    <div class="container">
        <div class="row page-titles mb-3">
            <div class="col">
                <h4 class="mb-0">📊 Monthly Payment Chart</h4>
                <small class="text-muted">Visual summary of monthly deposits</small>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <canvas id="monthlyChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyTotals->pluck('month')->map(fn($m) => \Carbon\Carbon::parse($m.'-01')->format('M Y'))) !!},
            datasets: [{
                label: 'Deposit Amount (BDT)',
                data: {!! json_encode($monthlyTotals->pluck('total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' ৳';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
