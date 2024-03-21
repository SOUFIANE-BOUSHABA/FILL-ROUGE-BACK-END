<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //

    public function store(Request $request)
    {

       
            $request->validate([
                'topic_id' => ['required', 'integer'],
                'text' => ['required', 'string'],
            ]);
        
            $comment = Comment::create([
                'user_id' => auth()->user()->id,
                'topic_id' => $request->topic_id,
                'text' => $request->text,
            ]);
        
            return response()->json($comment, 201);
        
        
       
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(null, 204);
    }
}
