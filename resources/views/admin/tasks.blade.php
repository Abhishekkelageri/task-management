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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


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
            left: 50%; 
            transform: translate(-50%, 0); 
            margin: 0;
            max-width: 600px; 
            width: 100%;
        }
        .modal-content {
            min-width: 300px; 
            height: auto; 
        }
        .task-summary {
            background-color: #007bff;
            color: white; 
            padding: 10px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
        }
        .btn-small {
            padding: 0.25rem 0.5rem; 
            font-size: 0.875rem; 
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
        <a href="/admin/dashboard"><i class="bi bi-house me-2"></i> Dashboard</a>
        <a href="/admin/users"><i class="bi bi-people me-2"></i> Users</a>
        <a href="/admin/tasks"><i class="bi bi-list-check me-2"></i> Tasks</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" id="logoutLink"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>

    <div class="content">
        <!-- Header -->
        <nav class="navbar navbar-light bg-light mb-4">
            <div class="container-fluid d-flex flex-column align-items-start">
                <h3 class="mb-0" style="color: black; font-weight: bold;">Welcome!</h3>
                <span class="dim-text">{{ Auth::user()->name }}</span>
            </div>
        </nav>

        <!-- User Management Section -->
        <div class="welcome-section mb-4">
            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-column">
                    <h1 class="section-header">Manage Task</h1>
                    <span class="dim-text">Check your daily tasks and schedules</span>
                </div>
            </div>
            <button class="btn btn-primary btn-small mt-2" data-bs-toggle="modal" data-bs-target="#addTaskModal">Add New</button>
        </div>

        <!-- Task Summary -->
        <div class="task-summary">
            All tasks (9) &nbsp;&nbsp;  &nbsp;&nbsp; Completed (8)
        </div>

        <!-- Static Task Cards -->
        <div class="row row-cols-1 row-cols-md-2 g-4" id="taskContainer">
            <!-- Dynamic task cards will be added here -->
        </div>


        <!-- Add Task Modal -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addTaskForm" action="" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="taskName" class="form-label">Task Name</label>
                                <input type="text" class="form-control" name="title" id="taskName" required>
                            </div>
                            <div class="mb-3">
                                <label for="taskDetails" class="form-label">Task Details</label>
                                <textarea class="form-control" name="description" id="taskDetails" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="taskDate" class="form-label">Due Date</label>
                                <input type="date" class="form-control" name="date" id="taskDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="assignedBy" class="form-label">Assig To</label>
                                <select class="form-select" id="assignedTo" name="assigned_to" required>
                                    <option value="">Select Assignee</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach     
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="taskStatus" class="form-label">Task Status</label>
                                <select class="form-select" id="taskStatus" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="taskStatus" class="form-label">Task Priority</label>
                                <select class="form-select" id="taskPriority" name="priority" required>
                                    <option value="">Select Priority</option>
                                    <option value="low">Low</option>
                                    <option value="in_medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Task Modal -->
        <div class="modal " id="edit-form" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm"> 
                <div class="modal-content">
                    <form id="addTaskForm">
                        <div class="modal-body">
                        <input type="hidden" class="form-control" id="taskIdEdit"  name="id" value="" required>
                            <div class="mb-3">
                                <label for="taskName" class="form-label">Task Name</label>
                                <input type="text" class="form-control" name="title" id="edittaskName" required>
                            </div>
                            <div class="mb-3">
                                <label for="taskDetails" class="form-label">Task Details</label>
                                <textarea class="form-control" name="description" id="edittaskDetails" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="taskDate" class="form-label">Due Date</label>
                                <input type="date" class="form-control" name="date" id="edittaskDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="assignedBy" class="form-label">Assig To</label>
                                <select class="form-select" id="editassignedTo" name="assigned_to" required>
                                    <option value="">Select Assignee</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach     
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="taskStatus" class="form-label">Task Status</label>
                                <select class="form-select" id="edittaskStatus" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="taskStatus" class="form-label">Task Priority</label>
                                <select class="form-select" id="edittaskPriority" name="priority" required>
                                    <option value="">Select Priority</option>
                                    <option value="low">Low</option>
                                    <option value="in_medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">update Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<script>
    $(document).ready(function() {
        fetchTasks();
    });

    $('body').on('submit', '#addTaskForm', function(e){
        e.preventDefault(); 

        const newTask = {
            title: $('#taskName').val(),
            date: $('#taskDate').val(),
            description: $('#taskDetails').val(),
            status: $('#taskStatus').val(),
            assigned_to: $('#assignedTo').val(),
            priority: $('#taskPriority').val(),
            
        };

        $.ajax({
            url: '/api/admin/tasks', 
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(newTask),
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('authToken')
            },
        success: function(response) {
                console.log(response);
                alert('Task added successfully!'); 

                $('#addTaskForm')[0].reset();
                location.href = "/admin/tasks"
                $('#addTaskModal').modal('hide'); 

            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Failed to add task. Please try again.'); 
            }
        });
    });

    
    function fetchTasks() {
            $.ajax({
                url: '/api/admin/tasks', 
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    
                    $('#taskContainer').empty();
                   
                    response.tasks.forEach(task => {
                        const taskCard = `
                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">${task.title}</h5>
                                        <p class="card-text">${task.description}</p>
                                        <p class="card-text"><strong>Due Date:</strong> ${new Date(task.date).toLocaleDateString()}</p>
                                        <p class="card-text"><strong>Status:</strong> ${task.status}</p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40" alt="Logo" class="img-logo me-2">
                                                <span class="assigned-by">Assigned to: ${task.assigned_user.name}</span>
                                            </div>
                                            <button class="btn btn-priority">
                                                <span class="priority-text">Priority:</span>
                                                <span class="priority-level ${getPriorityClass(task.priority)}">${task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}</span>
                                            </button>
                                        </div>
                                          <div class="mt-3 d-flex justify-content-between">
                                            <button class="btn btn-warning btn-edit edit-task" data-id="${task.id}" data-title="${task.title}" data-description="${task.description}" data-date="${task.date}" data-priority="${task.priority}" data-status="${task.status}" data-assigned_to="${task.assigned_to}">Edit</button>
                                            <button class="btn btn-danger btn-delete delete-task" data-id="${task.id}">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        $('#taskContainer').append(taskCard);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to fetch tasks. Please try again.');
                }
            });
    }

        function getPriorityClass(priority) {
            switch (priority) {
                case 'low': return 'priority-low';
                case 'medium': return 'priority-medium';
                case 'high': return 'priority-high';
                default: return '';
            }
        }

        $('body').on('click', '.edit-task', function(e) {
                e.preventDefault();
                
                const taskId = $(this).data('id');
                const taskTitle = $(this).data('title');
                const taskDescription = $(this).data('description');
                const taskPriority = $(this).data('priority');
                const taskStatus = $(this).data('status');
                const taskData = $(this).data('date');
                const taskAssigned_to = $(this).data('assigned_to');

                $('#taskIdEdit').val(taskId);
                $('#edittaskName').val(taskTitle);
                $('#edittaskDetails').val(taskDescription);
                $('#edittaskDate').val(taskData);
                $('#edittaskPriority').val(taskPriority);
                $('#editAssignedTo').val(taskAssigned_to);
                $('#edittaskStatus').val(taskStatus);

                $('#edit-form').modal('show');

        });


        $('body').on('click', '.delete-task', function(e) {
        e.preventDefault();
        const taskId = $(this).data('id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: `/api/admin/tasks/${taskId}`,
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('authToken')
                },
                success: function(response) {
                    if (response.status === 200) {
                        alert(response.message);
                        location.href = "/admin/tasks";
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

