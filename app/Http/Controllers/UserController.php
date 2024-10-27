<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UserController extends Controller
{
    public function dashboard(){
        return view('user.dashboard');
    }

    
    public function getAssignedTaskCount()
    {
        $user = Auth::user();
        $assignedTaskCount = $user->tasks()->count();

        return response()->json([
            'message' => 'Assigned task count retrieved successfully.',
            'status' => 200,
            'count' => $assignedTaskCount
        ],);
    }

    public function getCompletedTaskCountByUser()
    {
        $user = Auth::user();
        $completedTaskCount = $user->tasks()->where('status', 'completed')->count();

        return response()->json([
            'message' => 'Completed task count retrieved successfully.',
            'status' => 200,
            'count' => $completedTaskCount
        ],);
    }

}
