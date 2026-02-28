<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    /** @use HasFactory<\Database\Factories\DivisionFactory> */
    use HasFactory;

    protected $fillable = ['division_code','name', 'dept_id'];

    public function department(){
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function sections(){
        return $this->hasMany(Section::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }
}
