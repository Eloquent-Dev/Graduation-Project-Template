<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;

    protected $fillable = ['dept_code','name', 'dept_status'];

    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function divisions(){
        return $this->hasMany(Division::class, 'dept_id');
    }
}
