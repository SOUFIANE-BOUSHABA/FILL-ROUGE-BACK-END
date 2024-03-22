<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Topic;
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



    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'buyMeACoffee' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', 
        ]);

        $user = auth()->user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->url_pay_me_coffee = $request->input('buyMeACoffee');

        if($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
        }
        $user->avatar =$filename;
       

        $user->save();

        return response()->json(['message' => 'User details updated successfully']);
    }




    public function getTopicForUser($id)
    {
        $data = Topic::with('tags', 'user', 'topicVotes')->where('user_id', $id)->get();
        
        $data->each(function ($topic) {
            $topic->total_votes = $topic->topicVotes->sum('value');
        });
    
        return response()->json([
            'topics' => $data,
        ]);
    }

    public function getCommentsForUser($id){
        $data = Comment::with( 'commentVotes')->where('user_id', $id)->get();
        
        $data->each(function ($comment) {
            $comment->total_votes = $comment->commentVotes->sum('value');
        });
    
        return response()->json([
            'comments' => $data,
        ]);
    }
   
}
