<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function index()
    {
        return User::with('role')->get();
    }


    public function blockUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
         }
        $user->is_blocked = !$user->is_blocked;
        $user->save();

         return response()->json(['message' => 'User blocked successfully'], 200);
    }


    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json([
            'message' => 'User role updated successfully',
            'user' => $user
        ]);
    }
}
