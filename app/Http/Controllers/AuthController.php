<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required',  Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->has('role') ? 1 : 0,
        ]);

        auth()->login($user);

        if($request->has('role')){
            return redirect('/admin/dashboard')->with('success', 'Registration successful as admin');
        }else{
            return redirect('/user/dashboard')->with('success', 'Registration successful as user');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'role' => 'required' 
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->input('role');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            if (($role == 1 && $user->role == 1) || ($role == 0 && $user->role == 0)) {
                $token = $user->createToken('task')->plainTextToken;
    
                return response()->json([
                    'message' => 'Logged in successfully.',
                    'token' => $token,
                    'role' => $user->role
                ], 200);
            } else {
                return response()->json(['message' => 'Invalid credentials for the specified role.'], 403);
            }
        }
        return response()->json(['message' => 'Invalid credentials.'], 401);

    }

    public function logout(Request $request){
        Auth::logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('message', 'You have been logged out successfully.');
    }
}
