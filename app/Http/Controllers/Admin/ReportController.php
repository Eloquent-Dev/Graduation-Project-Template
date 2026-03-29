<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminReport;
use Illuminate\Http\Request;
use App\Models\Complaint;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(){
        $reports = AdminReport::with('generator')->latest()->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    public function generate(){
        $startDate = now()->subDays(30);

        $endDate = now();

        $complaints = Complaint::WhereBetween('created_at',[$startDate,$endDate])->get();

        $totalRecieved = $complaints->count();
        $totalResolved = $complaints->whereIn('status',['approved','resolved'])->count();
        $totalPending = $complaints->where('status','pending')->count();
        $totalReopened = $complaints->where('status','reopened')->count();
        $totalRejected = $complaints->where('status','rejected')->count();

        $resolvedComplaints = $complaints->whereIn('status',['approved','resolved']);
        $totalHours = 0;

        foreach($resolvedComplaints as $complaint){
            $completionTime = $complaint->approved_at ? Carbon::parse($complaint->approved_at) : $complaint->updated_at;
            $totalHours += $completionTime->diffInHours($completionTime);
        }

        $avgResolutionTime = $resolvedComplaints->count() > 0
        ? round($totalHours / $resolvedComplaints->count(), 1)
        : 0;

        $metrics = [
            'period' => $startDate->format('M d, Y'). ' - ' . $endDate->format('M d, Y'),
            'total_received' => $totalRecieved,
            'total_resolved' => $totalResolved,
            'total_pending' => $totalPending,
            'total_reopened' => $totalReopened,
            'total_rejected' => $totalRejected,
            'avg_resolution_hours' => $avgResolutionTime
        ];

        $report = AdminReport::create([
            'title' => 'System KPI Snapshot - '. now()->format('M d, Y'),
            'metrics' => $metrics,
            'generated_by' => auth()->user()->employee->id
        ]);

        return redirect()->route('admin.reports.show',$report->id)->with('success','New KPI Report generated successfully!');
    }

    public function show(AdminReport $report){
        return view('admin.reports.show', compact('report'));
    }
}
