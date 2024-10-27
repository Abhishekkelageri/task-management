<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\task;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'designation' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "Validation errors occured",
                'errors' => $validator->errors(),
                'status' => 422
        ],);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'designation' => $request->input('designation'),
            'created_by' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'status' => 200,
            'user' => $user
        ],);
    
    }

    public function getUsers(){
        $adminId = Auth::id();
        $users = User::where('created_by', $adminId)->get();

        return response()->json([
            'message' => 'Users retrieved successfully',
            'users' => $users,
            'status' => 200
        ],);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'designation' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => "Validation errors occured",
                'errors' => $validator->errors(),
                'status' => 422
            ],);
        }
    
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
                'status' => 404
            ],);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->designation = $request->input('designation');
        $user->save();

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user,
            'status' => 200
        ],);
    }

    public function destroy($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.', 'status' => 404],);
        }
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully.',
            'status' => 200
        ],);
    }


    //to get user count

    public function getUserCount()
    {
        $adminId = Auth::id();
        $userCount = User::whereHas('creator', function($query) use ($adminId) {
            $query->where('id', $adminId);
        })->count();

        return response()->json([
            'message' => 'User count retrieved successfully.',
            'status' => 200,
            'count' => $userCount
        ],);
    }

    //to get tasks count

    public function getTaskCount()
    {
        $adminId = Auth::id();
        $taskCount = Task::whereHas('creator', function($query) use ($adminId) {
            $query->where('id', $adminId);
        })->count();

        return response()->json([
            'message' => 'Task count retrieved successfully.',
            'status' => 200,
            'count' => $taskCount
        ],);
    }

    public function getCompletedTaskCount()
    {
        $admin = Auth::user();
        $completedTaskCount = $admin->createdTasks()->where('status', 'completed')->count();
        return response()->json([
            'message' => 'Completed task count retrieved successfully.',
            'status' => 200,
            'count' => $completedTaskCount
        ],);
    }


}
