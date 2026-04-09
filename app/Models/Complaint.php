<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    /** @use HasFactory<\Database\Factories\ComplaintFactory> */
    use HasFactory;
    use SoftDeletes;

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
        'image_path'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function jobOrders(){
        return $this->hasMany(JobOrder::class);
    }

    public function feedback(){
        return $this->hasOne(Feedback::class);
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

    public function logs(){
        return $this->hasMany(ComplaintLog::class)->orderBy('created_at','desc');
    }

    protected static function booted(){
        static::created(function($complaint){
            $complaint->logs()->create([
                'user_id' => auth()->id(),
                'status' => $complaint->status,
                'title' => 'Complaint Submitted',
                'description' => 'Your complaint has been successfully received by the system.'
            ]);
        });

        static::updated(function($complaint){
            if($complaint->wasChanged('status')){
                $oldStatus = $complaint->getOriginal('status');
                $newStatus = $complaint->status;

                $complaint->logs()->create([
                    'user_id' => auth()->id(),
                    'status' => $complaint->status,
                    'title' => 'Status Updated',
                    'description' => "Complaint status changed from {$oldStatus} to {$newStatus}"
                ]);
            }
        });
    }
}
