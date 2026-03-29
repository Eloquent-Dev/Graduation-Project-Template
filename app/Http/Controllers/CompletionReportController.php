<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletionReport;

class CompletionReportController extends Controller
{
    public function index (){
        $reports = CompletionReport::with(['jobOrder.complaint.category'])
        ->where('reported_by', auth()->id())
        ->orderBy('created_at','desc')
        ->paginate(15);

        return view('supervisor.reports.index', compact('reports'));
    }
    public function show(CompletionReport $completionReport){
      if ($completionReport->reported_by !== auth()->id()) {
          abort(403, 'Unauthorized action. You can only view your own reports.');
      }
      $completionReport->load(['jobOrder.complaint.category']);
      return view('supervisor.reports.show', compact('completionReport'));
    }
}
