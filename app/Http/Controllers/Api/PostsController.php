<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function create(Request $request)
    {
        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->desc = $request->desc;
        //check if post has photo 
        if ($request->photo != '') {
            //choose a unique name for pic 
            $photo = time() . 'jpg';
            file_put_contents('storage/posts/' . $photo, base64_decode($request->photo));
            $post->photo = $photo;
        }
        $post->save();
        $post->user;
        return response()->json([
            'success' => true,
            'message' => 'posted',
            'post' => $post
        ]);
    }

    public function update(Request $request)
    {
        $post = Post::find($request->id);
        if (Auth::user()->id != $request->id) {
            return response()->json([
                'success' => false,
                'message' => 'unaunthorized access'
            ]);
        }
        $post->desc = $request->desc;
        $post->update();
        return response()->json([
            'success' => true,
            'message' => 'post edited'
        ]);
    }
    public function delete(Request $request)
    {
        $post = Post::find($request->id);
        if (Auth::user()->id != $request->id) {
            return response()->json([
                'success' => false,
                'message' => 'unaunthorized access'
            ]);
        }

        //check if post has a photo 
        if ($post->photo != '') {
            Storage::delete('public/posts/' . $post->photo);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'post deleted'
        ]);
    }
    public function posts()
    {
        $posts = Post::orderBy('id', 'desc')->get();
        foreach ($posts as $post) {
            //user of post 
            $post->user;
            //comment count 
            $post['commentsCount'] = count($post->comments);
            //like count 
            $post['likesCount'] = count($post->likes);
            //check if users liked his own post 
            $post['selfLike'] = false;
            foreach ($post->likes as $like) {
                $post['selfLike'] = true;
            }
        }
        return response()->json([
            'success' => true,
            'message' => $posts
        ]);
    }
}
