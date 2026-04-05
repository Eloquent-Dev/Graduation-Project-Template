<?php

namespace App\Http\Controllers\Admin;

use App\Http\controllers\controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Division;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('complaints')
        ->orderBy('id' , 'asc')
        ->paginate(15);
        return view('admin.categories.index', compact('categories'));
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
         return view('admin.categories.show',compact('category','stats','complaints'));
    }
    public function create()
     {
        $divisions = Division::all();
        return view('admin.categories.create', compact('divisions'));
     }

     public function store(Request $request)
     {
        $validated = $request->validate([
            'name'=> 'required|string|max:255|unique:categories,name',
            'allowance_period' => 'required|integer|min:1',
            'division_id' => 'required|exists:divisions,id'
        ]);
        category::create([
            'name'=> $validated['name'],
            'allowance_period' => $validated['allowance_period'],
            'division_id' => $validated['division_id']
        ]);
        return redirect()->route('admin.categories.index')->with('success','Category created successfully!');
     }

    public function destroy(category $category)
     {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success','Category deleted successfully!');
     }
     public function edit(Category $category){
        $divisions = Division::all();
        return view('admin.categories.edit',compact('category','divisions'));
     }
     public function update(Request $request, Category $category){
        $validated = $request->validate([
            'name'=> 'required|string|max:255',
            'allowance_period' => 'required|integer|min:1',
            'division_id' => 'required|exists:divisions,id',
        ]);
        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success','Category updated successfully!');
     }
}
