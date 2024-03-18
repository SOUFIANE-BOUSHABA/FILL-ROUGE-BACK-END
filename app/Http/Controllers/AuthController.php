<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => 2,
        ]);

     
      

        return $user;
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }
    
        $user = Auth::user();
        
        if ($user->is_blocked) {
            Auth::logout();
            return response()->json([
                'message' => 'User is blocked. Cannot login.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $userRole = $user->role; 
        $token = $user->createToken('token')->plainTextToken;
    
        return response()->json([
            'user' => $user,
            'role' => $userRole, 
            'token' => $token,
            'message' => 'Login successful'
        ], Response::HTTP_OK);
    }
    
    public function user()
    {
        $user = Auth::user();
    
        if ($user) {
            $userRole = $user->role; 
            return response()->json([
                'user' => $user,
                'role' => $userRole, 
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }
    

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ], Response::HTTP_OK);
    }



}


