@extends('layouts.home')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Payment History</h2>

    @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
    @endif

    @if($payments->isEmpty())
        <div class="alert alert-warning text-center">No payment history found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Bill Code</th>
                        <th>Reference No</th>
                        <th>Created At</th>
                        <th>Amount (RM)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $index => $payment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $payment->billcode }}</td>
                            <td>{{ $payment->refno }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('Y-m-d H:i:s') }}</td>
                            <td>RM {{ number_format($payment->amount) }}</td> {{-- Assuming amount is stored in cents --}}
                            <td>
                                @if($payment->status == 'success')
                                    <span class="badge bg-success">Success</span>
                                @elseif($payment->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($payment->status == 'failed')
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

{{-- Add custom CSS for further styling --}}
<style>
    .table {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>
@endsection