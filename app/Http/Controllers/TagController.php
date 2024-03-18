<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    // Get all tags
    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

    // Create a new tag
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:tags,name'],
        ]);

        $tag = Tag::create([
            'name' => $request->name,
        ]);

        return response()->json($tag, 201);
    }

    // Get a specific tag
    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        return response()->json($tag);
    }

    // Update an existing tag
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:tags,name'],
        ]);

        $tag = Tag::findOrFail($id);
        $tag->update([
            'name' => $request->name,
        ]);

        return response()->json($tag, 200);
    }

    // Delete a tag
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return response()->json(null, 204);
    }
}
