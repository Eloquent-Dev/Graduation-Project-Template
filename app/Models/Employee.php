<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dept_id',
        'job_title',
        'dispatch_area',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function assignedJobOrders(){
        return $this->belongsToMany(JobOrder::class, 'employee_job_order')
        ->withTimestamps();
    }

    public function dispatchedJobsBy(){
        return $this->hasMany(JobOrder::class, 'assigned_by');
    }

    public function approvedComplaintsBy(){
        return $this->hasMany(Complaint::class, 'approved_by');
    }

    public function rejectedComplaintsBy(){
        return $this->hasMany(Complaint::class, 'rejected_by');
    }

    public function completionReports(){
        return $this->hasMany(CompletionReport::class);
    }

    public function adminReports(){
        return $this->hasMany(AdminReport::class);
    }
}
