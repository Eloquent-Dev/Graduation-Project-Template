<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminReport extends Model
{

protected $fillable = [ 'title', 'metrics', 'generated_by' ];

protected $casts = ['metrics' => 'array'];
    public function generator(){
        return $this->belongsTo(Employee::class, 'generated_by');
    }
}
