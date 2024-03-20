<?php

namespace App\Http\Controllers;

use App\Models\TopicVote;
use Illuminate\Http\Request;

class VotetopicController extends Controller
{
    //

    public function voteTopic(Request $request)
    {
        $topic_id = $request->topic_id;
        $user_id = auth()->user()->id;
        $value = $request->value;
        $vote = TopicVote::where('topic_id', $topic_id)->where('user_id', $user_id)->first();
        if($vote){
            $vote->update([
                'value' => $value
            ]);
        }else{
            TopicVote::create([
                'topic_id' => $topic_id,
                'user_id' => $user_id,
                'value' => $value
            ]);
        }
        return response()->json([
            'message' => 'Vote added successfully'
        ]);
    }
}
