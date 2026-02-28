<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminReport extends Model
{

protected $fillable = [
    'report_type',
    'generated_by',
];
    public function employee(){
        return $this->belongsTo(Employee::class, 'generated_by');
    }
}
