@extends('adminpage.adminlayout.home')

@section('title', 'Create Venue')

@section('content')
<div class="container">
    <h2 class="mb-4">Create New Venue</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input.</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.venues.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Venue Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="form-group mb-3">
            <label for="description">Description (optional)</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" required value="{{ old('location') }}">
        </div>

        <div class="form-group mb-3">
            <label for="capacity">Capacity</label>
            <input type="number" name="capacity" class="form-control" required min="1" max="5000" value="{{ old('capacity') }}">
        </div>

        <div class="form-group mb-3">
            <label for="fee">Fee (RM)</label>
            <input type="number" name="fee" class="form-control" required step="0.01" value="{{ old('fee') }}">
        </div>

        <div class="form-group mb-3">
            <label for="image_location">Upload Venue Image</label>
            <input type="file" name="image_location" class="form-control-file" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Venue</button>
        <a href="{{ route('admin.venues.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
