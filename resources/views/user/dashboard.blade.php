@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container" id="id-dashboard">
    <div class="row">
        <!-- Total Task Card -->
        <div class="col-md-6">
            <div class="card card-dashboard mb-4" style="height: 150px;">
                <div class="d-flex justify-content-between align-items-center h-100 px-3">
                    <div class="text-start">
                        <h5 class="mb-2">Total Task</h5>
                        <h2 class="task-count">12</h2>
                    </div>
                    <i class="fa-solid fa-chart-bar icon" style="color: green; font-size: 2.5rem; margin-right: 15px;"></i>
                </div>
            </div>
        </div>

        <!-- Completed Task Card -->
        <div class="col-md-6">
            <div class="card card-dashboard mb-4" style="height: 150px;">
                <div class="d-flex justify-content-between align-items-center h-100 px-3">
                    <div class="text-start">
                        <h5 class="mb-2">Completed</h5>
                        <h2 class="task-count">06</h2>
                    </div>
                    <i class="fa-solid fa-handshake icon" style="color: orange; font-size: 2.5rem; margin-right: 15px;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        fetchAssignedTaskCount();
        fetchCompletedTaskCount();

        function fetchAssignedTaskCount() {
            $.ajax({
                url: '/api/user/assigned-task-count', 
                type: 'GET',
                success: function(response) {
                    if (response.status === 200) {
                        $('.task-count').first().text(response.count);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to retrieve assigned task count.');
                }
            });
        }

        function fetchCompletedTaskCount() {
            $.ajax({
                url: '/api/user/completed-task-count',  
                type: 'GET',
                success: function(response) {
                    if (response.status === 200) {
                        $('.task-count').last().text(response.count); 
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to retrieve completed task count.');
                }
            });
        }

        // Toggle dashboard and task views
        $('#dashboardLink').click(function() {
            $('#id-dashboard').show();
            $('#id-task').hide();
        });

        $('#tasksLink').click(function() {
            $('#id-dashboard').hide();
            $('#id-task').show();
        });
    });
</script>
@endsection
