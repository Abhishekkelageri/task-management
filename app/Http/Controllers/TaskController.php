<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;


class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::with('assignedUser')->where('created_by', Auth::id())->get();
        return response()->json([
            'tasks' => $tasks,
            'status' => 200
        ],);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'status' => 'required',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "validation errors occured",
                'errors' => $validator->errors(), 
                'status' => 422,
            ],);
        }

        $task = Task::create([
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'assigned_to' => $request->input('assigned_to'),
            'created_by' => Auth::id(),
            'priority' => $request->input('priority'),
        ]);
    
        return response()->json([
            'message' => 'Task created successfully',
            'status' => 200,
            'task' => $task,
        ],);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'status' => 'required|string|in:pending,in_progress,completed',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|string|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "validation errors occured",
                'errors' => $validator->errors(),
                'status' => 422,
            ],);
        }

        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found',
                'status' => 404
            ],);
        }

        $task->update([
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'assigned_to' => $request->input('assigned_to'),
            'priority' => $request->input('priority'),
        ]);

        return response()->json([
            'message' => 'Task updated successfully',
            'status' => 200,
            'task' => $task,
        ],);

    }

    public function destroy($id){
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found',
                'status' => 404
            ],);
        }
        $task->delete();
        return response()->json([
            'message' => 'Task deleted successfully',
            'status' => 200
        ],);
    }

    public function userTasks()
    {
        $user = Auth::user();
        $tasks = $user->tasks()->with('creator')->get();
        
        return response()->json([
            'tasks' => $tasks,
            'status' => 200
        ]);
    }



    //to update the status

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,in_progress,completed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => "Validation errors occured",
                'errors' => $validator->errors(),
                'status' => 422
            ],);
        }
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found.',
                'status' => 404
            ], 404);
        }
        if ($task->assigned_to !== Auth::id()) {
            return response()->json([
                'message' => 'You are not authorized to update this task.',
                'status' => 403
            ],);
        }
        $task->status = $request->input('status');
        $task->save();

        return response()->json([
            'message' => 'Task status updated successfully.',
            'status' => 200,
            'task' => $task
        ],);
    }





}
