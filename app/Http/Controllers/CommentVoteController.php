<?php

namespace App\Http\Controllers;

use App\Models\CommentVote;
use Illuminate\Http\Request;

class CommentVoteController extends Controller
{
    //

    
    public function voteComment(Request $request)
    {
        $user_id = auth()->user()->id;
        $value = $request->value;
        $vote = CommentVote::where('comment_id', $request->comment_id)->where('user_id', $user_id)->first();
        if($vote){
            if($vote->value == $value){
                $vote->delete();
                return response()->json([
                    'message' => 'Vote removed successfully'
                ]);
            } else{
                $vote->update([
                    'value' => $value
                ]);
            }
           
        }else{
            CommentVote::create([
                'comment_id' => $request->comment_id,
                'user_id' => $user_id,
                'value' => $value
            ]);
        }
        return response()->json([
            'message' => 'Vote added successfully'
        ]);
    }
}
