@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
 <!-- User Management Section -->
 <div class="welcome-section mb-4">
            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-column">
                    <h1 class="section-header">Manage Task</h1>
                    <span class="dim-text">Check your daily tasks and schedules</span>
                </div>
            </div>
        </div>

        <!-- Task Summary -->
        <div class="task-summary">
            All tasks (9) &nbsp;&nbsp;  &nbsp;&nbsp; Completed (8)
        </div>

        <!-- Static Task Cards -->
        <div class="row row-cols-1 row-cols-md-2 g-4" id="taskContainer">
            <!-- Dynamic task cards will be injected here -->
        </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        fetchTasks();

        $('#taskContainer').on('change', '.task-status-dropdown', function() {
            const taskId = $(this).data('task-id');
            const newStatus = $(this).val();
            
            updateTaskStatus(taskId, newStatus);
        });
    });

    function fetchTasks() {
            $.ajax({
                url: '/api/user/tasks', // Update with your API endpoint
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
                                        <div class="card-text">
                                            <strong>Status:</strong>
                                            <select class="form-select task-status-dropdown" data-task-id="${task.id}">
                                                <option value="pending" ${task.status === 'pending' ? 'selected' : ''}>Pending</option>
                                                <option value="in_progress" ${task.status === 'in_progress' ? 'selected' : ''}>In Progress</option>
                                                <option value="completed" ${task.status === 'completed' ? 'selected' : ''}>Completed</option>
                                            </select>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40" alt="Logo" class="img-logo me-2">
                                                <span class="assigned-by">Assigned by: ${task.creator.name}</span>
                                            </div>
                                            <button class="btn btn-priority">
                                                <span class="priority-text">Priority:</span>
                                                <span class="priority-level ${getPriorityClass(task.priority)}">${task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}</span>
                                            </button>
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

        function updateTaskStatus(taskId, status) {
            $.ajax({
                url: `/api/tasks/${taskId}/status`,  
                type: 'PUT',
                data: {
                    status: status,
                },
                success: function(response) {
                    if (response.status === 200) {
                        alert('Task status updated successfully.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to update task status. Please try again.');
                }
            });
        }

</script>
@endsection