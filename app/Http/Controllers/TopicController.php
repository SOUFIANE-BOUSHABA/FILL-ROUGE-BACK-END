<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TopicController extends Controller
{
    public function index()
    {
        $id = auth()->user()->id;
        $data = Topic::with('tags', 'user', 'topicVotes')->get();
        
        $data->each(function ($topic) {
            $topic->total_votes = $topic->topicVotes->sum('value');
        });
    
        return response()->json([
            'topics' => $data,
            'user_id' => $id
        ]);
    }
    

    public function storeTopic(Request $request)
    {

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
        }
      
        $topic = Topic::create([
            'title' => $request->title,
            'details' => $request->details,
            'category_id' => $request->selectedCategory,
                'image_url' => $filename,
                'user_id' => auth()->user()->id,
        ]);


        $tages = explode(',', $request->selectedTags) ;
        foreach ($tages as $tage) {
            $topic->tags()->attach($tage);
        }
        return response()->json([
            'message' => 'Topic created successfully',
            'topic' => $topic
         ]);  
    }

    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        if($topic->image_url){
            $fileName = public_path('uploads/') . $topic->image_url;
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }
        return response()->json(null, 204);
    }


    public function getTopicById($id)
    {
        $topic = Topic::with('category', 'tags' )->findOrFail($id);
        return response()->json($topic);
    }

    public function update(Request $request, $id)
    {
      
            $topic = Topic::findOrFail($id);
            $topic->title = $request->title;
            $topic->details = $request->details;
            $topic->category_id = $request->category_id;

            $topic->tags()->detach();

               $tages = explode(',', $request->selectedTags) ;
                foreach ($tages as $tage) {
                    $topic->tags()->attach($tage);
                }

           
                if ($request->hasFile('image')) {
                    $fileName = public_path('uploads/') . $topic->image_url;
                    if (file_exists($fileName)) {
                        unlink($fileName);
                    }
                    $file = $request->file('image');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads'), $filename);
                    $topic->image_url = $filename;
                }

            $topic->save();

            return response()->json([
                'message' => 'Topic updated successfully',
                'topic' => $topic
            ]);
        } 
    

        
        public function getTopicByIdForComments($id)
        {
            $topic = Topic::with('tags', 'user', 'topicVotes' , 'comments' , 'comments.user')->find($id);
        
            if ($topic == null) {
                return response()->json(['error' => 'Topic not found'], 404);
            }
        
            $topic->total_votes = $topic->topicVotes->sum('value');
        
            return response()->json([
                'topic' => $topic,
                'user_id' => auth()->user()->id
            ]);
        }
        
        
}
