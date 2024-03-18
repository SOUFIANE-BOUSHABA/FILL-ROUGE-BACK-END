<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TopicController extends Controller
{
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
    
}
