<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'allowance_period',
        'division_id',
    ];

    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function complaints(){
        return $this->hasMany(Complaint::class);
    }
}
