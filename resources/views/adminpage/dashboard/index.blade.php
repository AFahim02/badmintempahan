@extends('adminpage.adminlayout.home')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard</h2>
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">Total Reservations</h5>
                    <p class="card-text display-4">{{ $totalReservations }}</p>
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-link">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-light">
                <div class="card-body">
                    <h5 class="card-title">Total Venues</h5>
                    <p class="card-text display-4">{{ $totalVenues }}</p>
                    <a href="{{ route('admin.venues.index') }}" class="btn btn-link">View</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Reservations & Venues Overview</h5>
                    <canvas id="overviewChart" style="max-height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    
</div>

{{-- Include Chart.js from CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxOverview = document.getElementById('overviewChart').getContext('2d');
        const overviewChart = new Chart(ctxOverview, {
            type: 'bar',
            data: {
                labels: ['Total Reservations', 'Total Venues'],
                datasets: [{
                    label: 'Count',
                    data: [{{ $totalReservations }}, {{ $totalVenues }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
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

        
    });
</script>

{{-- Custom Styles --}}
<style>
    .card {
        border-radius: 12px;
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-weight: 600;
    }

    .display-4 {
        font-size: 2.5rem;
        color: #333;
    }

    .btn-link {
        color: #007bff;
        text-decoration: none;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    canvas {
        display: block; /* Ensure canvas is displayed */
        width: 100% !important; /* Make sure it's responsive */
        height: auto !important;
    }
</style>
@endsection