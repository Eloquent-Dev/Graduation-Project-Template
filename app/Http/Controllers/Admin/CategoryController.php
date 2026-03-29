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
     public function show(Category $category){
       $stats=[
        'total' => $category->complaints()->count(),
        'pending' => $category->complaints()->where('status','pending')->count(),
        'in_progress' => $category->complaints()->whereIn('status',['in_progress','under_review'])->count(),
        'resolved' => $category->complaints()->whereIn('status',['approved','resolved'])->count(),
       ];
       $complaints = $category->complaints()
       ->with(['user'])
       ->orderBy('created_at','desc')
       ->paginate(15);
         return view('categories.show',compact('category','stats','complaints'));
    }
}
