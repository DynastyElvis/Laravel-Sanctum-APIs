<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
// use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }

    public function create()           
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->imagetag = $request->imagetag;
        $category->slug = $request->slug;
        $category->save();

        return redirect()->route('categories.index')->with('success','Category created successfully');
    }

    public function show($id)
    {
        $category = Category::find($id);
        return $category;  

    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->imagetag = $request->imagetag;
        $category->slug = $request->slug;
        $category->save();

        return redirect()->route('categories.index')->with('success','Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success','Category deleted successfully');
    }

}
