@extends('adminpage.adminlayout.home')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h2>Rejected / Canceled Booking</h2>
    <ul class="list-group mb-4">
        <li class="list-group-item">1. user3455</li>
        <li class="list-group-item">2. user9999</li>
        <li class="list-group-item">3. user1212</li>
    </ul>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Details</h5>
            <p><strong>Username:</strong> user3455</p>
            <p><strong>Full name:</strong> Ahmad Kamsuri bin Salleh</p>
            <p><strong>Rejected details:</strong> Cancellation of booking 3 days before the date, 29/6/2024</p>
            <p><strong>Booked facility:</strong> Padang Dato Keramat</p>
            <p><strong>Status:</strong> Organizing sports events</p>
            <div class="d-flex justify-content-between mt-3">
                <button class="btn btn-secondary">Ignore</button>
                <button class="btn btn-primary">Proceed Refund</button>
            </div>
        </div>
    </div>
</div>
@endsection