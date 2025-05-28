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
        'user_id',
        'parent_id',
        // Removed subject_id
    ];

    // Remove or revise this if not needed
    public function reserves()
    {
        // This looks off — does a student really "have many" student lists by user_id?
        return $this->hasMany(StudentList::class, 'user_id');
    }


    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    // Optional: Helper to get subjects via enrollments
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'enrollments', 'student_id', 'subject_id') ->withTimestamps();
    }
    

    public function feePayments()
{
    return $this->hasMany(FeePayment::class, 'student_id');
}


// In App\Models\StudentList.php
public function hasUnpaidFees()
{
    // Returns true if the student has any fee payments with status other than 'paid'
    return $this->feePayments()->where('status', '!=', 'paid')->exists();
}

}
