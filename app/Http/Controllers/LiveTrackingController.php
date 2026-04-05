<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class LiveTrackingController extends Controller
{
function index(){
    return view('livetracking.index');
}

public function getWorkerLocations()
{
    $workers = Employee::whereHas('user', function ($query) {
        $query->where('role', 'worker');
    })

   ->whereNotNull('latitude')
    ->whereNotNull('longitude')
    ->with('user')
    ->get(['id', 'user_id', 'latitude', 'longitude','job_title','tracking_status', 'updated_at']);

    return response()->json($workers);
}
}
