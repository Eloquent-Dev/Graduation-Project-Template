<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    /** @use HasFactory<\Database\Factories\JobOrderFactory> */
    use HasFactory;

    protected $fillable = [
        'assigned_by',
        'assigned_at',
        'completed_at',
        'closed_at',
        'closed_by',
        'closure_reason',
        'complaint_id',
        'status',
        'priority',
    ];

    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }

    public function workers(){
        return $this->belongsToMany(Employee::class, 'employee_job_order')
        ->withTimestamps();
    }

    public function assignedBy(){
        return $this->belongsTo(Employee::class, 'assigned_by');
    }

    public function closedBy(){
        return $this->belongsTo(Employee::class, 'closed_by');
    }

    public function completionReport(){
        return $this->hasOne(CompletionReport::class);
    }
}
