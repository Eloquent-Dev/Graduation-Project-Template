<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\User;
use App\Notifications\newComplaintSubmitted;
use Illuminate\Support\Facades\Notification;

class ComplaintController extends Controller
{
    public function create(){
        $categories = Category::all();

        return view('complaints.create',compact('categories'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ]);

        $complaint = Complaint::Create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'user_id' => auth()->id()
        ]);

        $dispatchers = User::all();
        Notification::send($dispatchers, new newComplaintSubmitted($complaint));

        return redirect()->route('home')->with('success','Your complaint has been submitted and is under review');
    }
}
