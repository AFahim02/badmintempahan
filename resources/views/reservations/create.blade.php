@extends('layouts.home')

@section('content')
<style>
    .reservation-container {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: auto;
        display: flex; 
        flex-direction: column; 
    }

    .venue-info-container {
        display: flex; 
        align-items: center; 
        margin-bottom: 20px;
    }

    .venue-image {
        width: 40%;  
        height: 200px; 
        object-fit: cover; 
        border-radius: 10px;
        margin-right: 20px; 
    }

    .venue-info {
        flex: 1; 
    }

    .form-group {
        margin-bottom: 20px; 
    }

    .time-group {
        display: flex; 
        align-items: center;
    }

    .time-label {
        margin-right: 10px; 
        font-weight: bold; 
    }

    .form-row {
        display: flex; 
        justify-content: space-between;
    }

    .form-control {
        width: calc(100% - 10px);
        margin-right: 10px;
    }

    .btn {
        width: 100%;
        margin-top: 20px;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px; 
        border-radius: 5px;
        cursor: pointer;
    }

    .header-title {
        font-size: 24px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    label {
        font-weight: bold; 
    }
</style>

<div class="reservation-container">
    <div class="header-title">Make a Reservation</div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST"> <!-- Updated form action -->
        @csrf
        <input type="hidden" name="venue_id" value="{{ $venue->id }}">

        <div class="venue-info-container">
            <img src="{{ asset('storage/' . $venue->image_location) }}" alt="Venue Image" class="venue-image">

            <div class="venue-info">
                <h2>{{ $venue->name }}</h2>
                <p>Capacity: {{ $venue->capacity }}</p>
                <p>Rate per hour: RM{{ $venue->fee }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="time-label">Time:</label>
            <div class="time-group">
                <div class="form-group">
                    <label for="start_time">Start:</label>
                    <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" required>
                    @error('start_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_time">End:</label>
                    <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" required>
                    @error('end_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="reservation_date">Date</label>
                <input type="date" name="reservation_date" class="form-control @error('reservation_date') is-invalid @enderror" id="reservation_date" required>
                @error('reservation_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="event_type">Event</label>
                <input type="text" name="event_type" class="form-control @error('event_type') is-invalid @enderror" id="event_type" required>
                @error('event_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="contact_number">Contact Number</label>
            <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" required placeholder="+60">
            @error('contact_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn">Book</button>
    </form>
</div>
@endsection