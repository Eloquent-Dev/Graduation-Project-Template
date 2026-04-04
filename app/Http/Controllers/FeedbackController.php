<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Complaint;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'rating' => 'required|numeric|min:0|max:5',
            'quality_comments' => 'nullable|string',
            'speed_rating' => 'required|numeric|min:0|max:5',
        ]);

       $complaint->feedback()->create($validated);

        if($validated['rating']<=2.5){
            $complaint->update(['status' => 'reopened']);
        }
        else{
            $complaint->update(['status' => 'closed']);
        }

        return redirect()->route('complaints.index')->with('success', 'Feedback submitted successfully.');
    }
}
