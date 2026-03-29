<?php

namespace App\Http\Controllers\Admin;

use App\Http\controllers\controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('complaints')
        ->orderBy('name' , 'asc')
        ->get();
        return view('categories.index', compact('categories'));
    }
}
