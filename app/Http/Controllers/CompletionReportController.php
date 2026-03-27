<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletionReport;

class CompletionReportController extends Controller
{
    public function index (){
        CompletionReport::with(['jobOrder.complaint.category'])
        ->where('reported_by', auth()->id())
        ->orderBy('created_at','desc')
        ->paginate(15);

        return view('supervisor.reports.index', compact('reports'));
    }
}
