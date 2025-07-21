@extends('layouts.app')

@section('title', 'Reset Password - eTempahan Portal')

@section('content')
<div class="background-container" style="position: relative; height: calc(100vh - 70px); background-image: url('path/to/your/background-image.jpg'); background-size: cover; background-position: center; display: flex; align-items: flex-start; justify-content: center; padding-top: 200px;">
    <div class="reset-form" style="position: relative; background-color: rgba(255, 255, 255, 0.9); border-radius: 20px; padding: 40px; width: 400px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);">
        <h2 class="text-center" style="color: #0D0C54; font-weight: bold;">{{ __('Reset Password') }}</h2>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="row mb-3">
                <label for="email" class="col-form-label text-md-end" style="color: #0D0C54;">{{ __('Email Address') }}</label>

                <div>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="background-color: #0D0C54; border-color: #0D0C54;">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </div>
        </form>

        <div class="text-center mt-3">
            <p style="font-weight: bold; color: #0D0C54;">Remembered your password? <a href="{{ route('login') }}" style="color: #0D0C54;">Login</a></p>
        </div>
    </div>
</div>
@endsection

<style>
/* Styles specific to the reset password page */
.background-container {
    position: relative;
    height: calc(100vh - 70px);
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding-top: 200px;
}

.reset-form {
    position: relative;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 40px;
    width: 400px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
}

h2 {
    font-family: 'Inter', sans-serif;
    margin-bottom: 20px;
}

.btn-primary {
    background-color: #0D0C54;
    border-color: #0D0C54;
}
</style>