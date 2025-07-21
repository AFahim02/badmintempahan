<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: black;
            background-color: #F8F9FA;
            overflow-x: hidden;
        }

        .navbar-custom {
            background-color: #D9D9D9;
            position: fixed;
            width: calc(100% - 250px);
            z-index: 1000;
            left: 250px;
            top: 0;
        }

        .sidebar {
            background-color: #7091E6;
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            width: 250px;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: white;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 15px;
            transition: background-color 0.3s;
        }

        .sidebar .nav-link .icon-only {
            margin-right: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: #5a73e1;
        }

        .search-input-wrapper {
            position: relative;
            max-width: 400px; /* Increased width for better appearance */
            margin: 0 auto; /* Center the search input */
        }

        .search-input {
            width: 100%;
            padding-left: 30px;
            text-align: center; /* Center the placeholder text */
        }

        .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .menu-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #cce0ff;
            padding: 10px 15px;
        }

        .reservations-submenu {
            display: none;
            padding-left: 15px;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #7091E6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .profile-icon:hover {
            background-color: #5a73e1;
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            right: 10px;
            top: 50px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
            border-radius: 5px;
        }

        .profile-dropdown.show {
            display: block;
        }

        main {
            margin-left: 250px;
            margin-top: 56px;
            overflow-y: auto;
            height: calc(100vh - 56px);
            transition: margin-left 0.3s;
        }

        @media (max-width: 768px) {
            .navbar-custom {
                left: 0;
                width: 100%;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            main {
                margin-left: 0;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.nav-link:contains("Reservations")').click(function() {
                $(this).next('.reservations-submenu').toggle();
            });

            $('.profile-icon').click(function(event) {
                event.stopPropagation();
                const dropdown = document.getElementById('profileDropdown');
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });

            $(document).click(function(event) {
                const dropdown = document.getElementById('profileDropdown');
                const profileIcon = document.querySelector('.profile-icon');
                if (!profileIcon.contains(event.target)) {
                    dropdown.style.display = 'none';
                }
            });
        });
    </script>
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <div class="search-input-wrapper">
                <i class="fas fa-search search-icon"></i>
                <form action="{{ route('reservations.index') }}" method="GET">
                    <input type="text" name="query" class="form-control search-input" placeholder="Search venues..." aria-label="Search">
                </form>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-5">Welcome back, {{ Auth::user()->name }}!</span>
                <div class="dropdown">
                    <div class="profile-icon" onclick="toggleProfileDropdown()">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profile-dropdown" id="profileDropdown" style="display: none;">
                        <a class="dropdown-item" href="{{ route('profile') }}">View Profile</a>
                        <a class="dropdown-item" href="{{ route('notifications.index') }}">Notifications</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <nav class="sidebar" id="sidebar">
                <div class="position-sticky">
                    <div class="sidebar-header text-center" onclick=window.location="{{ route('home') }}">
                        <h5 class="sidebar-header-text py-3">BadminTempahan System</h5>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <span class="icon-only"><i class="fas fa-tachometer-alt"></i></span>
                                <span class="text">Dashboard</span>
                            </a>
                        </li>
                        <li class="menu-title">MAIN</li>
                         <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">
                                <span class="icon-only"><i class="fas fa-user"></i></span>
                                <span class="text">Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">   
                            <a class="nav-link" href="javascript:void(0)">
                                <span class="icon-only"><i class="fas fa-calendar-alt"></i></span>
                                <span class="text">Reservations</span>
                            </a>
                            <ul class="nav flex-column reservations-submenu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('reservations.index') }}">
                                        <span class="icon-only"><i class="fas fa-eye"></i></span>
                                        <span class="text">View Venues</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('reservations.history') }}">
                                        <span class="icon-only"><i class="fas fa-history"></i></span>
                                        <span class="text">Reservation History</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('payment.status') }}">
                                <span class="icon-only"><i class="fas fa-money-bill-wave"></i></span>
                                <span class="text">Payment History</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('notifications.index') }}">
                                <span class="icon-only"><i class="fas fa-bell"></i></span>
                                <span class="text">Notifications</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Include Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js" integrity="sha384-Ksv1wW4h5D5b9C2v1YfQH5Uq7+2m5zD0YbZzQxgW5B5j5B5j5z3Q+8tU+8+f8+y" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-s5c5PpB5j5f5s5z/RB5F5s5B5j5q5z5/B5j5j5h5B5j5j5B5j5h5B5j5h5B5j5" crossorigin="anonymous"></script>

</body>

</html>