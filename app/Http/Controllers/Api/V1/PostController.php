<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::first()->where('user_id', auth()->user()->id)->paginate(5)->withQueryString();

        return response()->json([
            'status' => true,
            'message' => "Post found",
            'post' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rulesValidation = $request->validate([
            'title' => ['required', 'min:5', 'max:100', 'unique:posts'],
            'content' => ['required', 'min:5'],
            'image' => []

        ]);

        $rulesValidation['user_id'] = auth()->user()->id;
        $posts = Post::create($rulesValidation);

        if ($posts)
        {
            return response()->json([
                'status' => true,
                'message' => 'Post created successfully!',
                'data' => $posts->toArray()
            ], 200);
        }
        
        if (!$posts)
        {
            return response()->json([
                'status' => false,
                'message' => 'Post failed added'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('user_id', auth()->user()->id)->find($id);

        if ($post) 
        {
            return response()->json([
                'status' => true,
                'message' => 'Post found',
                'data' => $post->toArray()
            ], 200);
        }

        if (!$post) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::where('user_id', auth()->user()->id)->find($id);
 
        if (!$post) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        $update = $post->fill($request->all())->save();
 
        if ($update)
        {
            return response()->json([
                'status' => true,
                'message' => 'Post updated successfully!'
            ], 200);
        }
        
        if(!$update)
        {
            return response()->json([
                'status' => false,
                'message' => 'Post can not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('user_id', auth()->user()->id)->find($id);
 
        if (!$post) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ], 404);
        }
 
        if ($post->delete()) 
        {
            return response()->json([
                'status' => true,
                'message' => 'Post deleted successfully!'
            ], 200);
        } 

        if (!$post->delete())
        {
            return response()->json([
                'status' => false,
                'message' => 'Post failed delete'
            ], 500);
        }
    }
}
