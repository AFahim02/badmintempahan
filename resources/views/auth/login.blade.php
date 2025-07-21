@extends('layouts.app')

@section('title', 'Login - BadminTempahan Portal')

@section('content')
    <div class="background-container" style="position: relative; height: calc(100vh - 70px); background-image: url('path/to/your/background-image.jpg'); background-size: cover; background-position: center; display: flex; align-items: flex-start; justify-content: center; padding-top: 200px;">
        
        <div class="login-form" style="position: relative; background-color: rgba(255, 255, 255, 0.9); border-radius: 20px; padding: 40px; width: 400px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);">
            <!-- Close Button -->
            <a href="{{ url('/') }}" class="close-button" style="position: absolute; top: 10px; right: 10px; color: #0D0C54; font-size: 24px;">&times;</a>

            <h2 class="text-center" style="color: #0D0C54; font-weight: bold;">Login</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group position-relative">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group position-relative">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    <img src="https://img.icons8.com/material-outlined/24/3D52A0/visible.png" alt="Show Password" class="input-icon" id="toggle-password" style="cursor: pointer;" onclick="togglePasswordVisibility()">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember" style="font-weight: bold; color: #0D0C54;">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="background-color: #0D0C54; border-color: #0D0C54;">Login</button>

                <div class="text-center mt-3">
                    <p style="font-weight: bold; color: #0D0C54;">Don't Have an Account? <a href="{{ route('register') }}" class="text-primary" style="color: #0D0C54;">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection

<style>
    /* Styles specific to the login page */
    .form-control {
        border: none; /* Remove default border */
        border-bottom: 2px solid #3D52A0; /* Line only */
        background-color: transparent; /* No background */
        border-radius: 0; /* No rounded corners */
        padding-right: 35px; /* Space for icon */
    }

    .input-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #3D52A0; /* Icon color */
        pointer-events: auto; /* Allow clicking */
    }

    .close-button {
        text-decoration: none;
    }

    .form-group {
        position: relative;
        margin-bottom: 20px; /* Space between form fields */
    }

    h2 {
        font-family: 'Inter', sans-serif;
        margin-bottom: 20px;
    }
</style>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggle-password');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.src = 'https://img.icons8.com/material-outlined/24/3D52A0/invisible.png'; // Change to 'invisible' icon
        } else {
            passwordInput.type = 'password';
            toggleIcon.src = 'https://img.icons8.com/material-outlined/24/3D52A0/visible.png'; // Change to 'visible' icon
        }
    }
</script>