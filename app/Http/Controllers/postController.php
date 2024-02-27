<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostDetailResource;
use Illuminate\Support\Facades\Storage;

//LoadMissing digunakan didalam return
//With Digunakan pada pengambilan data dalam pembuatan variabel Eloquent

class postController extends Controller
{
    public function Index()
    {
        $posts = Post::with('writer:id,firstname')->get();
        return PostDetailResource::collection($posts->loadMissing(['writer:id,firstname','comments:id,post_id,user_id,comment_content'])); // Untuk Array
    }

    public function showPost($id)
    {
        $post = Post::with('writer:id,firstname')->findOrFail($id);
        return new PostDetailResource($post->loadMissing(['writer:id,firstname','comments:id,post_id,user_id,comment_content'])); // Untuk Array);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        if ($request->hasFile('file')) {

            $validatedData=$request->validate([
                'file' => 'required|file|mimes:jpeg,png,gif'
            ]);
            
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            Storage::putFileAs('image', $request->file, $fileName.'.'.$extension);
        }

        $request['author'] = Auth::user()->id;
        $request['image'] = $fileName.'.'.$extension;
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

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}
