<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BadminTempahan Portal')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/badminton.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .header {
            position: relative;
            background-color: #000; /* Change blue to black */
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 2;
            border-bottom: 2px solid white;
        }
        .nav-links a {
            color: white; /* Keep text color white */
            margin: 0 15px;
            text-decoration: none;
            font-size: 1.2rem;
            position: relative;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: #FFD700; /* Keep hover color */
        }
        .login-button {
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 5px;
            background-color: transparent;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
            outline: none;
            text-decoration: none;
        }
        .login-button:hover {
            background-color: white;
            color: #3f51b5; /* Keep hover color */
        }
        .container {
            background-color:rgba(0, 0, 0, 0.7); /* Change blue to black */
            border-radius: 0 0 75% 75%;
            width: 100%;
            max-width: 1920px;
            height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 1;
            margin-top: -10px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: yellow; /* Keep this color or change if needed */
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: white;
        }
        .search-input {
            padding: 10px 40px;
            width: 300px;
            border: 2px solid white;
            border-radius: 5px;
            font-size: 0.9rem;
            outline: none;
            color: #3D52A0; /* Change if you want it black */
            text-align: center;
        }
        .search-input::placeholder {
            color: #3D52A0; /* Change if you want it black */
            text-align: center;
        }
        .search-icon, .location-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .search-icon {
            right: 10px;
            color: white; /* Keep icon color white */
        }
        .location-icon {
            left: 10px;
            color: white; /* Keep icon color white */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="home-icon">
            <a href="{{ url('/') }}"><img src="https://img.icons8.com/material-outlined/24/ffffff/home.png" alt="Home"></a>
        </div>
        <div class="nav-links">
            <a href="{{ url('/about') }}">About Us</a>
        </div>
        <a href="{{ route('login') }}" class="login-button">Login</a>
    </div>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>