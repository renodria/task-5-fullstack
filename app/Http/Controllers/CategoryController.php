<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index', [
            'categories' => Category::first()->where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.form.create');
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
            'name' => ['required', 'min:5', 'max:50', 'unique:categories']
        ]);

        $validationRules['user_id'] = auth()->user()->id;
        Category::create($validationRules);

        return redirect('/categories')->with('success', 'New category success has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if ($category->user->id !== auth()->user()->id) {
            abort(403);
        }

        return view('category.form.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validationRules = $request->validate([
            'name' => ['required', 'min:5', 'max:50', 'unique:categories']
        ]);

        $validationRules['user_id'] = auth()->user()->id;
        Category::where('id', $category->id)->update($validationRules);

        return redirect('/categories')->with('success', 'Category success has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->user->id === auth()->user()->id) {
            Category::destroy($category->id);

            return redirect('/categories')->with('success', 'Category success has been deleted!');
        }
        if ($category->user->id !== auth()->user()->id) {
            abort(403);
        }
    }
}
