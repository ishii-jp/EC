<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Good;
use App\Category;

class CategoryController extends Controller
{
    public function categoryIndex()
    {
        $categories = Category::all();
        return view('ec.categories.categoryIndex', ['categories' => $categories]);
    }

    public function categoryShow(Request $request)
    {
        $items = Good::with('category')->where('category_id', $request->category_id)->get();
        return view('ec.categories.categoryShow', ['items' => $items]);
    }
}
