<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('blog.index', [
            'posts' => Post::latest()->where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.form.create', [
            'categories' => Category::all()
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
        $validationRules = $request->validate([
            'title' => ['required', 'max:100', 'min:5', 'unique:posts'],
            'category_id' => ['required'],
            'image' => ['image', 'file', 'max:1024'],
            'content' => ['required', 'min:5']
        ]);

        if ($request->file('image')) {
            $validationRules['image'] = $request->file('image')->store('post-images');
        }

        $validationRules['user_id'] = auth()->user()->id;
        Post::create($validationRules);

        return redirect('/posts')->with('success', 'New post success has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if ($post->user->id === auth()->user()->id) {
            return view('blog._detail', [
                'post' => $post
            ]);
        }
        if ($post->user->id !== auth()->user()->id) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if ($post->user->id === auth()->user()->id) {
            return view('blog.form.edit', [
                'post' => $post,
                'categories' => Category::all()
            ]);
        }
        if ($post->user->id !== auth()->user()->id) {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => ['required', 'max:255', 'unique:posts'],
            'category_id' => 'required',
            'image' => ['image', 'file', 'max:1024'],
            'content' => 'required'
        ];

        if ($request->slug != $post->slug) {
            $rules['slug'] = ['required', 'unique:posts'];
        }

        $validated = $request->validate($rules);

        if ($request->file('image')) 
        {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            $validated['image'] = $request->file('image')->store('post-images');
        }

        $validated['user_id'] = auth()->user()->id;
        Post::where('id', $post->id)->update($validated);

        return redirect('/posts')->with('success', 'Post success has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if ($post->user->id === auth()->user()->id) 
        {
            if ($post->image) {
                Storage::delete($post->image);
            }

            Post::destroy($post->id);
            return redirect('/posts')->with('success', 'Post success has been deleted!');
        }
        if ($post->user->id === auth()->user()->id) {
            abort(403);
        }

    }
}
