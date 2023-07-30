<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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
        $categories = Category::first()->where('user_id', auth()->user()->id)->paginate(5)->withQueryString();

        return response()->json([
            'status' => true,
            'message' => "Category found",
            'category' => $categories
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
            'name' => ['required', 'min:5', 'max:100', 'unique:categories'],

        ]);

        $rulesValidation['user_id'] = auth()->user()->id;
        $categories = Category::create($rulesValidation);

        if ($categories)
        {
            return response()->json([
                'status' => true,
                'message' => 'Category created successfully!',
                'data' => $categories->toArray()
            ], 200);
        }
        
        if (!$categories)
        {
            return response()->json([
                'status' => false,
                'message' => 'Category failed added'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::where('user_id', auth()->user()->id)->find($id);

        if ($categories) 
        {
            return response()->json([
                'status' => true,
                'message' => 'Category found',
                'data' => $categories->toArray()
            ], 200);
        }

        if (!$categories) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categories = Category::where('user_id', auth()->user()->id)->find($id);
 
        if (!$categories) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 400);
        }
 
        $update = $categories->fill($request->all())->save();
 
        if ($update)
        {
            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully!'
            ], 200);
        }
        
        if(!$update)
        {
            return response()->json([
                'status' => false,
                'message' => 'Category can not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = Category::where('user_id', auth()->user()->id)->find($id);
 
        if (!$categories) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }
 
        if ($categories->delete()) 
        {
            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully!'
            ], 200);
        } 

        if (!$categories->delete())
        {
            return response()->json([
                'status' => false,
                'message' => 'Category failed delete'
            ], 500);
        }
    }
}
