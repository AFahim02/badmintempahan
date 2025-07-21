@extends('layouts.home')

@section('content')
<div class="container">
    <h2>Redirecting to Payment...</h2>
    <form id="payment-form" action="{{ route('payment.create') }}" method="POST">
        @csrf
        <input type="hidden" name="reservation_id" value="{{ $reservation_id }}">
        <input type="hidden" name="amount" value="{{ $amount }}">
    </form>
    <script>
        document.getElementById('payment-form').submit();
    </script>
</div>
@endsection