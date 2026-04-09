<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintLog extends Model
{
    protected $fillable = ['complaint_id', 'user_id','status','title','description'];

    public function complaint(){
        return $this->belongsTo(Complaint::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
