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
    $('#dashboardLink').click(function() {
        $('#id-dashboard').show();
        $('#id-task').hide();
    });

    $('#tasksLink').click(function() {
        $('#id-dashboard').hide();
        $('#id-task').show();
    });
</script>
@endsection