@extends('adminpage.adminlayout.home')

@section('title', 'Edit Venue')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Venue: {{ $venue->name }}</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.venues.update', $venue->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Venue Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $venue->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="image_location">Image Location</label>
                    <input type="file" name="image_location" class="form-control @error('image_location') is-invalid @enderror" id="image_location">
                    <img src="{{ asset('storage/' . $venue->image_location) }}" class="img-thumbnail mt-2" alt="{{ $venue->name }}" width="150">
                    <small class="form-text text-muted">Leave blank to keep the current image.</small>
                    @error('image_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description', $venue->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location" value="{{ old('location', $venue->location) }}" required>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" id="capacity" value="{{ old('capacity', $venue->capacity) }}" required>
                    @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="fee">Fee</label>
                    <input type="number" name="fee" class="form-control @error('fee') is-invalid @enderror" id="fee" value="{{ old('fee', $venue->fee) }}" required>
                    @error('fee')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" id="status" required>
                        <option value="available" {{ old('status', $venue->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ old('status', $venue->status) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Update Venue</button>
            </form>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .card {
        border-radius: 12px;
    }

    .form-control {
        border-radius: 8px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        border-color: #007bff;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
@endsection