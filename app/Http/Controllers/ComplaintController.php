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

    public function index(){
        $complaints = Complaint::where('user_id', auth()->id())
                    ->with('category')
                    ->latest()
                    ->get();

                    return view('complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint){
        if($complaint->user_id !== auth()->id()){
            abort(403,'Unauthorized action. You can only view your own complaints.');
        }
        return view('complaints.show', compact('complaint'));
    }
    public function create(){
        $categories = Category::all();

        return view('complaints.create',compact('categories'));
    }

    public function store(Request $request){
        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ];

        if(!auth()->check()){
            $rules['complainant_name'] = 'required|string|max:255';
            $rules['guest_national_no'] = 'required_without:passport_no|nullable|string|max:20';
            $rules['passport_no'] = 'required_without:guest_national_no|nullable|string|max:20';
        }

        $validated = $request->validate($rules,[],[
            'complainant_name' => 'Full Name',
            'title' => 'Title',
            'guest_national_no' => 'National Number',
            'passport_no' => 'Passport Number',
            'description' => 'Description'
        ]);

        $complaint = Complaint::Create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'user_id' => auth()->id(),
            'complainant_name' =>$validated['complainant_name'] ?? null,
            'guest_national_no' => $validated['guest_national_no'] ?? null,
            'passport_no' => $validated['passport_no'] ?? null
        ]);

        $dispatchers = User::whereIn('role' , ['dispatcher','admin'])->get()->all();

        if(auth()->check()) $dispatchers[] = auth()->user();

        Notification::send($dispatchers, new newComplaintSubmitted($complaint));

        return redirect()->route('home')->with('success','Your complaint has been submitted and is under review');
    }
}
