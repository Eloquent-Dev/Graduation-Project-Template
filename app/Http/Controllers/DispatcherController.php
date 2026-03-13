<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Models\JobOrder;
use App\Models\Employee;
use App\Http\Requests\storeJobRequest;

class DispatcherController extends Controller
{
    public function index(){
        $jobOrders = JobOrder::with(['complaint.category','complaint.user','workers'])
        ->whereIn('status', ['pending','reopened','in_progress'])
        ->orderByRaw("
        CASE priority
        WHEN 'high' THEN 1
        WHEN 'medium' THEN 2
        WHEN 'low' THEN 3
        ELSE 4
        END ASC")
        ->latest()
        ->paginate(15);

        return view('dispatcher.job_orders.index', compact('jobOrders'));
    }

    public function show(JobOrder $jobOrder){
        $jobOrder->load(['complaint.category','complaint.user','workers.user']);

        $divisionId = $jobOrder->complaint->category->division_id;

        $divisionEmployees = Employee::with('user')
        ->where('division_id',$divisionId)
        ->get();

        $supervisors = $divisionEmployees->filter(function($employee){
            return $employee->user->role === 'supervisor';
        });

        $workers = $divisionEmployees->filter(function($employee){
            return $employee->user->role === 'worker';
        });

        $availableWorkers = Employee::with('user')
        ->where('division_id',$divisionId)
        ->get();

        return view('dispatcher.job_orders.show', compact('jobOrder', 'supervisors','workers'));
    }

    public function update(storeJobRequest $request,JobOrder $jobOrder){
        $request->validate([
            'supervisor_ids' => 'required|array|min:1|max:1',
            'supervisor_ids.*' => 'exists:employees,id',
            'worker_ids' => 'required|array|min:1',
            'worker_ids.*' => 'exists:employees,id'
        ],[],[
            'supervisor_ids.required' => 'You must assign at least one Supervisor to lead the team.',
            'worker_ids.required' => 'You must assign at least one Worker to the team.'
        ]);

        $teamIds = array_merge($request->supervisor_ids,$request->worker_ids);

        $jobOrder->workers()->sync($teamIds);

        $jobOrder->update([
            'status' => 'in_progress',
            'assigned_at' => now(),
            'assigned_by' => auth()->user()->employee->id ?? null
        ]);

        $jobOrder->complaint->update([
            'status' => 'in_progress'
        ]);

        return redirect()->route('dispatcher.job_orders.index')
        ->with('success','Field team dispatched! Job Order is now In Progress.');
    }
}
