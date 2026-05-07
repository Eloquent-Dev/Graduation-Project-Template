<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkerController extends Controller
{
    public function assignments(){
        $user = auth()->user();

        if(!$user->employee()){
            abort(403,'Your account isn\'t linked to an employee. Contact the administrator.');
        }

        $employeeId = $user->employee->id;

        $assignments = $user->employee->assignedJobOrders()
        ->with(['complaint.category'])
        ->where('job_orders.status','in_progress')
        ->orderByRaw("
        CASE priority
        WHEN 'high' THEN 1
        WHEN 'medium' THEN 2
        WHEN 'low' THEN 3
        ELSE 4
        END ASC")
        ->latest('job_orders.created_at')
        ->paginate(10);

        return view('worker.assignments',compact('assignments'));
    }

    public function updateStatus(Request $request,JobOrder $jobOrder){
        $request->validate([
            'worker_status' => 'required|in:on_site,off_duty,in_route,off_site'
        ]);

        $employeeId = auth()->user()->employee->id;

        if(!$jobOrder->workers->contains($employeeId)){abort(403,'You cannot change your status when this task isnt assigned to you.');}

        if(in_array($request->worker_status,['on_site','in_route'])){
            DB::table('employee_job_order')
            ->where('employee_id',$employeeId)
            ->where('job_order_id', '!=', $jobOrder->id)
            ->whereIn('worker_status',['on_site','in_route'])
            ->update(['worker_status'=>'off_site']);
        }

        $jobOrder->workers()->updateExistingPivot($employeeId, [
            'worker_status' => $request->worker_status
        ]);

        return back();
    }

    public function toggleDuty(){
        $employee = auth()->user()->employee;

        $newStatus = $employee->duty_status === 'on_duty' ? 'off_duty': 'on_duty';

        $employee->update([
            'duty_status' => $newStatus
        ]);

        if($newStatus === 'off_duty'){

        $jobIds = $employee->assignedJobOrders()->pluck('job_orders.id');

        if($jobIds->isNotEmpty()){
            $employee->assignedJobOrders()->updateExistingPivot($jobIds,[
                'worker_status' => 'off_site'
            ]);
        }

            DB::table('employee_job_order')
            ->where(['employee_id',$employee->id])
            ->update(['worker_status'=>'off_site']);
        }

        return back();
    }

    public function show(JobOrder $jobOrder){
        $user = auth()->user();

        $employee = $user->employee;

        if(!$employee || !$jobOrder->workers->contains($employee->id)){
            abort(403,'unauthorized access');
        }

        $jobOrder->load(['complaint.category','workers.user']);

        return view('worker.show',compact('jobOrder','employee'));
    }
}
