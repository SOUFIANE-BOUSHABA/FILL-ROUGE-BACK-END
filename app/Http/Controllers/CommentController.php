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

    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return response()->json(['comment' => $comment], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => ['required', 'string'],
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update([
            'text' => $request->text,
        ]);

        return response()->json($comment, 200);
    }


    public  function vliderComment(Request $request){
        $request->validate([
            'comment_id' => 'required',
        ]);
        $comment = Comment::findOrFail($request->comment_id);
        $comment->update([
            'validation' => !$comment->validation,
        ]);

        return response()->json($comment, 200);
    }
}
