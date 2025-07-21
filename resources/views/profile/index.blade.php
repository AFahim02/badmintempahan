@extends('layouts.home')

@section('title', 'Profile')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Your Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-light">
        <div class="card-body">
            <form action="{{ url('/profile') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                <div class="mb-3 text-center">
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('placeholder.jpg') }}" 
                         alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px;"/>
                    <div class="mt-2">
                        <input type="file" name="profile_picture" class="form-control-file" accept="image/*">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Your User ID</label>
                    <input type="text" class="form-control" id="user_id" value="{{ $user->custom_id }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                </div>
                <div class="mb-3">
                    <label for="id_card_number" class="form-label">ID Card Number</label>
                    <input type="text" class="form-control" id="id_card_number" name="id_card_number" value="{{ $user->id_card_number }}">
                </div>
                <div class="mb-3">
                    <label for="telegram_chat_id" class="form-label">Telegram Chat ID</label>
                    <input type="text" class="form-control" id="telegram_chat_id" name="telegram_chat_id" value="{{ $user->telegram_chat_id }}">
                    <div class="form-text">You can get this from <a href="https://t.me/userinfobot" target="_blank">@userinfobot</a> on Telegram.</div>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .card {
        border-radius: 12px;
    }

    .card-body {
        padding: 2rem;
    }

    .form-control {
        border-radius: 8px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 8px;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert {
        border-radius: 8px;
    }
</style>
@endsection