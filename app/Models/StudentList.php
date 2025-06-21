<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ic',
        'level',
        'phone',
        'parent_id',
    ];

    public function parent()
    {
        // return $this->belongsTo(User::class, 'parent_id');
        return $this->belongsTo(\App\Models\ParentInfo::class, 'parent_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'enrollments', 'student_id', 'subject_id')->withTimestamps();
    }

    public function feePayments()
    {
        return $this->hasMany(FeePayment::class, 'student_id');
    }

    public function hasUnpaidFees()
    {
        return $this->feePayments()->where('status', '!=', 'paid')->exists();
    }
}
