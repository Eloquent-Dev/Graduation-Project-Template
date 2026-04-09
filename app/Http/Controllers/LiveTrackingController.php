<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use Illuminate\Http\Request;

class LiveTrackingController extends Controller
{
public function index()
{
    return view('livetracking.index');
}

public function getTrackingData()
{
    $jobOrders = JobOrder::has('workers')
    ->with(['workers.user','complaint'])
    ->whereNotIn('status',['resolved','rejected'])
    ->orderByRaw("
        CASE priority
        WHEN 'high' THEN 1
        WHEN 'medium' THEN 2
        WHEN 'low' THEN 3
        ELSE 4
        END ASC")
    ->orderBy('created_at','desc')
    ->get()
    ->map(function($jobOrder){
        return[
            'id'=>$jobOrder->id,
            'priority'=>$jobOrder->priority,
            'status'=>$jobOrder->status,
            'complaint_id'=> $jobOrder->complaint_id,
            'workers'=> $jobOrder->workers->map(function($worker){
                return[
                'id'=>$worker->id,
                'name'=> $worker->user->name ?? 'Unknown Employee',
                'duty_status'=>$worker->duty_status,
                'worker_status'=>$worker->pivot->worker_status,
        ];
    })->values()->toArray()
    ];
    })->values()->toArray();


    return response()->json($jobOrders);
}
}
