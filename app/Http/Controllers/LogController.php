<?php

namespace App\Http\Controllers;

use App\Models\ComplaintLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(){
        $logs = ComplaintLog::with('complaint')
        ->whereHas('complaint', function ($query){
            $query->where('user_id', auth()->id());
        })
        ->orderBy('created_at','desc')
        ->paginate(15);

        return view('complaints.log',compact('logs'));
    }
}
