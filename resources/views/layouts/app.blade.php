<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM9OCZp+ePpvN6AbQqY8PZ0s4DkVxEmKylwJ6Qb" crossorigin="anonymous">
    <style>
        /* Common styling for layout */
        body {
            min-height: 100vh;
            display: flex;
            background-color: rgb(230 234 237) !important;
            flex-direction: column;
        }
        .sidebar {
            height: 100vh;
            background-color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            padding: 90px 0;
        }
        .sidebar a {
            color: black;
            padding: 30px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo text-center">
            <img src="https://via.placeholder.com/40" alt="Logo" class="img-logo">
        </div>
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="#" id="dashboardLink"><i class="bi bi-house me-2"></i> Dashboard</a>
        <a href="#" id="tasksLink"><i class="bi bi-list-check me-2"></i> Tasks</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" id="logoutLink"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Header -->
        <nav class="navbar navbar-light bg-light mb-4">
            <div class="container-fluid d-flex flex-column align-items-start">
                <h3 class="mb-0" style="color: black;font-weight: bold;">Welcome!</h3>
                <p class="mb-0" style="font-size: 1.25rem; color: black;">Abhishek</p>
            </div>
        </nav>

        <!-- Page Content -->
        @yield('content')
    </div>

    

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>