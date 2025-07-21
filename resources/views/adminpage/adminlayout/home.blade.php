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
            z-index: 999;
        }

        .sidebar .nav-link {
            color: white;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 15px;
            transition: background-color 0.3s;
        }

        .sidebar .nav-link .icon {
            margin-right: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: #5a73e1;
        }

        main {
            margin-left: 250px;
            margin-top: 56px;
            overflow-y: auto;
            height: calc(100vh - 56px); 
            padding: 20px;
        }

        .search-input-wrapper {
            position: relative;
            max-width: 300px;
            margin: 0 auto;
        }

        .search-input {
            width: 100%;
            padding-left: 30px;
        }

        .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
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
                margin-top: 56px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle Profile Dropdown
            $('.profile-icon').click(function(event) {
                event.stopPropagation();
                $('#profileDropdown').toggle();
            });

            // Close dropdown when clicking outside
            $(document).click(function(event) {
                if (!$(event.target).closest('.profile-icon').length) {
                    $('#profileDropdown').hide();
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
                <form action="{{ route('admin.venues.index') }}" method="GET">
                    <input type="text" name="query" class="form-control search-input" placeholder="Search venues..." aria-label="Search">
                </form>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-5">Welcome back, {{ Auth::user()->name }}!</span>
                <div class="dropdown">
                    <div class="profile-icon"> 
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profile-dropdown" id="profileDropdown" style="display: none;">
                        <a class="dropdown-item" href="{{ route('admin.notifications.create') }}">Send Notifications</a>
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

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header text-center py-3" onclick=window.location="{{ route('admin.dashboard')}}">
            <h5 class="text-white">BadminTempahan System</h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt icon"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.reservations.index') }}">
                    <i class="fas fa-calendar-alt icon"></i> Reservations
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.venues.index') }}">
                    <i class="fas fa-map-marker-alt icon"></i> Venues
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.payment.history') }}">
                    <i class="fas fa-money-bill-wave icon"></i> Payment History
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>

</html>