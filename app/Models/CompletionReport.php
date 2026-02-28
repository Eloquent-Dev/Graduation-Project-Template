<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletionReport extends Model
{
    /** @use HasFactory<\Database\Factories\CompletionReportFactory> */
    use HasFactory;

    protected $fillable =[
        'job_order_id',
        'reported_by',
        'supervisor_comments',
        'started_at',
        'completed_at',
        'image_path',
    ];

    public function jobOrder(){
        return $this->belongsTo(JobOrder::class);
    }

    public function reportedBy(){
        return $this->belongsTo(Employee::class, 'reported_by');
    }
}
