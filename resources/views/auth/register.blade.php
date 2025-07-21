@extends('layouts.app')

@section('title', 'Register - BadminTempahan Portal')

@section('content')
    <div class="background-container" style="position: relative; height: calc(100vh - 70px); background-image: url('path/to/your/background-image.jpg'); background-size: cover; background-position: center; display: flex; align-items: flex-start; justify-content: center; padding-top: 200px;">
        
        <div class="register-form" style="position: relative; background-color: rgba(255, 255, 255, 0.9); border-radius: 20px; padding: 40px; width: 400px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);">
            <!-- Close Button -->
            <a href="{{ url('/') }}" class="close-button" style="position: absolute; top: 10px; right: 10px; color: #0D0C54; font-size: 24px;">&times;</a>

            <h2 class="text-center" style="color: #0D0C54; font-weight: bold;">Sign Up</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group position-relative">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Name">
                    <img src="https://img.icons8.com/material-outlined/24/3D52A0/user.png" alt="Name" class="input-icon">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group position-relative">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                    <img src="https://img.icons8.com/material-outlined/24/3D52A0/email.png" alt="Email" class="input-icon">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group position-relative">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                    <img src="https://img.icons8.com/material-outlined/24/3D52A0/lock.png" alt="Password" class="input-icon">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group position-relative">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                    <img src="https://img.icons8.com/material-outlined/24/3D52A0/lock.png" alt="Confirm Password" class="input-icon">
                </div>

                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                    <label class="form-check-label" for="terms" style="font-weight: bold; color: #0D0C54;">I agree to the Terms and Conditions</label>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="background-color: #0D0C54; border-color: #0D0C54;">Register</button>

                <div class="text-center mt-3">
                    <p style="font-weight: bold; color: #0D0C54;">Already Have an Account? <a href="{{ route('login') }}" class="text-primary" style="color: #0D0C54;">Login</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection

<style>
    /* Styles specific to the register page */
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