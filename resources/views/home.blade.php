@extends('layouts.home')

@section('title', 'User Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">User Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm border-light">
            <div class="card-header bg-primary text-white">
                Overview
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Reservations</h5>
                                <p class="card-text">{{ $reservations->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Upcoming Events</h5>
                                <p class="card-text">{{ $reservations->where('reservation_date', '>', now())->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="card shadow-sm border-light">
            <div class="card-header bg-warning text-dark">
                Your Reservations
            </div>
            <div class="card-body">
                @if($reservations->isEmpty())
                    <p class="text-center">No reservations found.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Venue</th>
                                    <th>Date</th>
                                    <th>Event</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $index => $reservation)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $reservation->venue ? $reservation->venue->name : 'No venue assigned' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') }}</td>
                                        <td>{{ $reservation->event_type }}</td>
                                        <td>
                                            @if($reservation->payment_status == 'success')
                                                <span class="badge bg-success">Success</span>
                                            @elseif($reservation->payment_status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($reservation->payment_status == 'failed')
                                                <span class="badge bg-danger">Failed</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .card {
        border-radius: 12px;
    }

    .card-header {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        vertical-align: middle;
        padding: 15px;
    }

    th {
        background-color: #e9ecef;
        color: #495057;
    }

    .table-light {
        background-color: #f8f9fa;
    }

    .table-responsive {
        overflow-x: auto;
    }

    @media (max-width: 768px) {
        .table {
            font-size: 0.9rem;
        }

        th, td {
            padding: 10px;
        }
    }
</style>
@endsection