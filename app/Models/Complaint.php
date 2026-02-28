<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    /** @use HasFactory<\Database\Factories\ComplaintFactory> */
    use HasFactory;
    use softDeletes;

    protected $fillable =[
        'title',
        'status',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'rejection_reason',
        'resolved_at',
        'resolved_by',
        'closed_at',
        'closed_by',
        'complainant_name',
        'guest_national_no',
        'passport_no',
        'longitude',
        'latitude',
        'description',
        'category_id',
        'user_id',
        'reopened_from_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function jobOrder(){
        return $this->hasMany(JobOrder::class);/*Not Sure if we want this to stay hasMany not hasOne*/
    }

    public function feedback(){
        return $this->hasOne(Feedback::class);/*Not Sure if we want this to stay hasOne not hasMany*/
    }

    public function reopenedComplaint(){
        return $this->belongsTo(Complaint::class, 'reopened_from_id');
    }

    // --- Auditing relationships ---
    public function approvedBy(){
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    public function rejectedBy(){
        return $this->belongsTo(Employee::class, 'rejected_by');
    }

    public function resolvedBy(){
        return $this->belongsTo(Employee::class, 'resolved_by');
    }

    public function closedBy(){
        return $this->belongsTo(Employee::class, 'closed_by');
    }
}
