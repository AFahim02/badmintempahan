@extends('adminpage.adminlayout.home')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Reservation List</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Reservation Date</th>
                            <th>Event Name</th>
                            <th>Time</th>
                            <th>Venue</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($reservations->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">No reservations found.</td>
                            </tr>
                        @else
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') }}</td>
                                    <td>{{ $reservation->event_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</td>
                                    <td>{{ $reservation->venue->name ?? 'N/A' }}</td>
                                    <td>{{ $reservation->user->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($reservation->payment_status == 'success')
                                            <span class="badge bg-success">Success</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($reservation->payment_status == 'pending')
                                            <form action="{{ route('admin.reservations.remind', $reservation->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-info">Remind</button>
                                            </form>
                                            <form action="{{ route('admin.reservations.delete', $reservation->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .card {
        border-radius: 12px;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1); /* Light blue background on hover */
    }
</style>
@endsection