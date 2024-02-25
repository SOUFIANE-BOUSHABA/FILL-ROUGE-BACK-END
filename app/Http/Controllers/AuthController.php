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
            'password' => Hash::make($request->input('password'))
        ]);

     
        $userRole = Role::where('name', 'user')->first(); 
        if ($userRole) {
            $user->roles()->attach($userRole);
        }

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
    $userRole = $user->roles()->first(); 
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
        if( $user = Auth::user()){
            $userRole = $user->roles()->first(); 
            return response()->json([
                'user' => Auth::user(),
                'role'=> $userRole
            ], Response::HTTP_OK);
        }else{
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


