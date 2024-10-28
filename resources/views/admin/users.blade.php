<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.3/css/all.min.css"> 

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
        .table th {
            background-color: #4c91da;
            color: white;
        }
        .color {
            background-color: #4c91da;
        }
        
        .table td, .table th {
            vertical-align: middle;
        }
        .table-container {
            max-width: 90%; 
            margin-right: 20px; 
        }
        .modal-backdrop.show {
            backdrop-filter: blur(80px); 
            background-color: rgba(0, 0, 0, 0.7); 
        }
        .modal-dialog {
            position: fixed; 
            bottom: 5%;
            left: 45%;
            transform: translate(-50%, 0); 
            margin: 0; 
            max-width: 800px; 
            width: 100%; 
        }
        .modal-content {
            min-width: 400px; 
            height: auto;
        }
        .form-row {
            display: flex; 
            justify-content: space-between; 
        }
        .form-row .form-group {
            width: 48%; 
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

        <!-- User Management Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 style="color: black;">Create User</h1>
            <button class="btn btn-primary color" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New</button>
        </div>
        
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="adduser">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group mb-3">
                                <label for="userName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="userName" name="name" value="" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="userDesignation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="userDesignation" name="designation" value="" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group mb-3">
                                <label for="userEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="userEmail" name="email" value="" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="userPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="userPassword" name="password" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update user modal -->
    <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateUser">
                    <div class="modal-body">
                        <div class="form-row">
                        <input type="hidden" class="form-control" id="userIdEdit"  name="id" value="" required>
                            <div class="form-group mb-3">
                                <label for="userName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="userNameEdit"  name="name" value="" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="userDesignation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="userDesignationEdit"  name="designation" value="" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group mb-3">
                                <label for="userEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="userEmailEdit" name="email" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="updateUserBtn" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>

    $(document).ready(function() {
        fetchUsers();
    });

    //creating users

    $('body').on('submit', '#adduser', function(e){
        e.preventDefault();
        const newUser = {
            name: $('#userName').val(),
            email: $('#userEmail').val(),
            password: $('#userPassword').val(),
            designation: $('#userDesignation').val(),
        };

        $.ajax({
            url: '/api/admin/users',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(newUser),
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('authToken')
            },
            success: function(response) {
                if(response.status == 200){
                    $('#adduser')[0].reset();
                    alert(response.message);
                    location.href = "/admin/users"
                }else{
                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseJSON.message);
            }
        });
    });

    //fetch users

    function fetchUsers() {
        $.ajax({
            url: '/api/admin/users',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('authToken')
            },
            success: function(response) {
                $('#userTableBody').empty();
                response.users.forEach(function(user, index) {
                    $('#userTableBody').append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${user.name}</td>
                            <td>${user.designation}</td>
                            <td>${user.email}</td>
                            <td>
                                <a href="" class="btn btn-primary color btn-sm edit-user" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}" data-designation="${user.designation}"><i class="bi bi-pencil-square"></i></a>
                                <a href="#" class="btn btn-danger btn-sm delete-user" data-id="${user.id}"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function(xhr) {
                console.error(xhr.responseJSON.message);
            }
        });
    }

    $('body').on('click', '.edit-user', function(e) {
        e.preventDefault();

        const userId = $(this).data('id');
        const userName = $(this).data('name');
        const userEmail = $(this).data('email');
        const userDesignation = $(this).data('designation');

        $('#userIdEdit').val(userId);
        $('#userNameEdit').val(userName);
        $('#userEmailEdit').val(userEmail);
        $('#userDesignationEdit').val(userDesignation);

        $('#updateUserModal').modal('show');

    });

    //update user

    $('body').on('submit', '#updateUser', function(e){
        e.preventDefault();
        const newUser = {
            id: $('#userIdEdit').val(), 
            name: $('#userNameEdit').val(),
            email: $('#userEmailEdit').val(),
            designation: $('#userDesignationEdit').val(),
        };
        $.ajax({
            url: '/api/admin/users/' + newUser.id,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(newUser),
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('authToken')
            },
            success: function(response) {
                if(response.status == 200){
                    alert(response.message);
                    location.href = "/admin/users";
                }else{
                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseJSON.message);
            }
        });
    });

    //delete user

    $('body').on('click', '.delete-user', function(e) {
        e.preventDefault();
        const userId = $(this).data('id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: `/api/admin/users/${userId}`,
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('authToken')
                },
                success: function(response) {
                    if (response.status === 200) {
                        alert(response.message);
                        location.href = "/admin/users";
                        fetchUsers();
                    }else{
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseJSON.message);
                }
            });
        }
    });



    </script>
</body>
</html>