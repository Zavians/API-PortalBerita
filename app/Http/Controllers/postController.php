<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostDetailResource;


//LoadMissing digunakan didalam return
//With Digunakan pada pengambilan data dalam pembuatan variabel Eloquent

class postController extends Controller
{
    public function Index()
    {
        $posts = Post::with('writer:id,firstname')->get();
        return PostDetailResource::collection($posts); // Untuk Array
    }

    public function showPost($id)
    {
        $post = Post::with('writer:id,firstname')->findOrFail($id);
        return new PostDetailResource($post); // Untuk Detail Tanpa Array
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,firstname'));

    }

    function update (Request $request, $id) 
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,firstname'));
    }

    function destroy (Request $request, $id) 
    {

        $post = Post::findOrFail($id);
        $post->delete();
        return new PostDetailResource($post->loadMissing('writer:id,firstname'));
    }


}
