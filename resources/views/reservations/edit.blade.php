@extends('layouts.home')

@section('content')
<div class="container">
    <h1>Edit Reservation</h1>
    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="location" class="form-label">Venue</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $reservation->location }}" required>
        </div>
        <div class="mb-3">
            <label for="event_type" class="form-label">Event Type</label>
            <input type="text" class="form-control" id="event_type" name="event_type" value="{{ $reservation->event_type }}" required>
        </div>
        <div class="mb-3">
            <label for="reservation_date" class="form-label">Reservation Date</label>
            <input type="date" class="form-control" id="reservation_date" name="reservation_date" value="{{ $reservation->reservation_date }}" required>
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $reservation->start_time }}" required>
        </div>
        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $reservation->end_time }}" required>
        </div>
        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ $reservation->contact_number }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Reservation</button>
    </form>
</div>
@endsection