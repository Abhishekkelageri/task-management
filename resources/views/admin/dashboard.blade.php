<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            background-color: rgb(230, 234, 237);
            flex-direction: column;
        }
        .sidebar {
            height: 100vh;
            background-color: white;
            color: black;
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            padding: 20px 0;
        }
        .sidebar a {
            color: black;
            padding: 15px;
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
        .card-dashboard {
            height: 150px;
        }
        .icon {
            font-size: 2.5rem;
            margin-right: 15px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo text-center mb-4">
            <img src="https://via.placeholder.com/40" alt="Logo" class="img-logo">
        </div>
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="/admin/dashboard" id="dashboardLink"><i class="bi bi-house me-2"></i> Dashboard</a>
        <a href="/admin/users" id="usersLink"><i class="bi bi-people me-2"></i> Users</a>
        <a href="/admin/tasks" id="tasksLink"><i class="bi bi-list-check me-2"></i> Tasks</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" id="logoutLink"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Header -->
        <nav class="navbar navbar-light bg-light mb-4">
            <div class="container-fluid d-flex flex-column align-items-start">
                <h3 class="mb-0" style="color: black; font-weight: bold;">Welcome, {{ Auth::user()->name }}!</h3>
            </div>
        </nav>

        <!-- Dashboard Cards -->
        <div class="container" id="id-dashboard">
    <div class="row">
        <!-- Total User Card -->
        <div class="col-md-4">
            <div class="card card-dashboard mb-4 total-users">
                <div class="d-flex justify-content-between align-items-center h-100 px-3">
                    <div class="text-start">
                        <h5 class="mb-2">Total Users</h5>
                        <h2 class="task-count">0</h2> 
                    </div>
                    <i class="fas fa-chart-bar icon" style="color: green;"></i>
                </div>
            </div>
        </div>

        <!-- Total Task Card -->
        <div class="col-md-4">
            <div class="card card-dashboard mb-4 total-tasks">
                <div class="d-flex justify-content-between align-items-center h-100 px-3">
                    <div class="text-start">
                        <h5 class="mb-2">Total Tasks</h5>
                        <h2 class="task-count">0</h2> 
                    </div>
                    <i class="fas fa-tasks icon" style="color: blue;"></i>
                </div>
            </div>
        </div>

        <!-- Completed Task Card -->
        <div class="col-md-4">
            <div class="card card-dashboard mb-4 completed-tasks">
                <div class="d-flex justify-content-between align-items-center h-100 px-3">
                    <div class="text-start">
                        <h5 class="mb-2">Completed</h5>
                        <h2 class="task-count">0</h2> 
                    </div>
                    <i class="fas fa-handshake icon" style="color: orange;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        function loadDashboardCounts() {
            // Get User Count
            $.ajax({
                url: '/api/admin/user-count',
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    
                    if(response.status === 200) {
                        $('.total-users .task-count').text(response.count);
                    }
                },
                error: function() {
                    console.error("Error fetching user count.");
                }
            });

            // Get Task Count
            $.ajax({
                url: '/api/admin/task-count',
                type: 'GET',
                success: function(response) {
                    if(response.status === 200) {
                        $('.total-tasks .task-count').text(response.count);
                    }
                },
                error: function() {
                    console.error("Error fetching task count.");
                }
            });

            // Get Completed Task Count
            $.ajax({
                url: '/api/admin/completed-task-count',
                type: 'GET',
                success: function(response) {
                    if(response.status === 200) {
                        $('.completed-tasks .task-count').text(response.count);
                    }
                },
                error: function() {
                    console.error("Error fetching completed task count.");
                }
            });
        }

        loadDashboardCounts();
    });
</script>

</html>
