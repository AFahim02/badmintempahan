@extends('layouts.home')

@section('title', 'My Reservations')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2 class="mb-4">Available Venues</h2>
    <div class="row">
        @if($venues->isEmpty())
            <div class="col-12">
                <p>No available venues found.</p>
            </div>
        @else
            @foreach($venues as $venue)
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-light">
                    <img src="{{ asset('storage/' . $venue->image_location) }}" class="card-img-top" alt="{{ $venue->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $venue->name }}</h5>
                        <p class="card-text">Location: {{ $venue->location }}</p>
                        <p class="card-text">Capacity: {{ $venue->capacity }}</p>
                        <p class="card-text">Fee: RM {{ $venue->fee }} / Day</p>
                        @if($venue->status == 'available')
                            <a href="{{ route('reservations.create', ['venue_id' => $venue->id]) }}" class="btn btn-primary">Book</a>
                        @else
                            <button class="btn btn-secondary" disabled>Unavailable</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @endif

        @if(request('query') && $venues->isEmpty())
            <div class="col-12">
                <p>No results found for "<strong>{{ request('query') }}</strong>".</p>
            </div>
        @endif
    </div>
</div>

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
        color: #333;
    }

    .card-text {
        color: #555;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn-secondary:disabled {
        background-color: #e0e0e0;
    }
</style>
@endsection