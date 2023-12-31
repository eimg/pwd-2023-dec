<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    // GET -> /categories
    public function index()
    {
        return Category::all();
    }

    // POST -> /categories
    public function store(Request $request)
    {
        $name = $request->name;
        if(!$name) return ['msg' => 'name required'];

        $category = new Category;
        $category->name = $name;
        $category->save();

        return $category;
    }

    // GET -> /categories/{id}
    public function show(Category $category)
    {
        return $category;
    }

    // PUT -> /categories/{id}
    public function update(Request $request, Category $category)
    {
        $name = $request->name;
        if (!$name) return ['msg' => 'name required'];

        $category->name = $name;
        $category->save();

        return $category;
    }

    // DELETE -> /categories/{id}
    public function destroy(Category $category)
    {
        $category->delete();
        return $category;
    }
}
