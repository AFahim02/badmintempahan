@extends('adminpage.adminlayout.home')

@section('title', 'Available Venues')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Available Venues</h2>

    {{-- Display success message if available --}}
    @if (session('success'))
        <div id="success-message" class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" onclick="window.location='{{ route('admin.venues.create') }}'">Create New Venue</button>
    </div>
    
    <div class="row">
        @if($venues->isEmpty())
            <div class="col-12">
                <p>No venues found.</p>
            </div>
        @else
            @foreach($venues as $venue)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm border-light">
                    <img src="{{ asset('storage/' . $venue->image_location) }}" class="card-img-top img-fluid" alt="{{ $venue->name }}" style="object-fit: cover; height: 200px;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $venue->name }}</h5>
                        <div class="mt-auto">
                            <a href="{{ route('admin.venues.edit', $venue->id) }}" class="btn btn-secondary">Update Venue</a>
                            
                            {{-- Delete Button --}}
                            <form action="{{ route('admin.venues.destroy', $venue->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this venue?')">Delete Venue</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

{{-- JavaScript to hide the success message after 3 seconds --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.transition = 'opacity 0.5s ease';
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.remove(); // Remove the element from the DOM
                }, 500); // Wait for the fade-out transition to complete
            }, 3000); // Wait for 3 seconds before starting the fade-out
        }
    });
</script>

{{-- Custom Styles --}}
<style>
    .card {
        border-radius: 12px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>
@endsection