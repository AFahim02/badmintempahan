<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Payment Failed</h1>
        <p>We're sorry, but your payment could not be processed. Please try again.</p>
        <a href="{{ route('reservations.index') }}" class="btn btn-primary">Return to Reservations</a>
    </div>
</body>
</html>