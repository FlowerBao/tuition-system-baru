<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'parent_id', 'amount', 'status', 'stripe_payment_id'
    ];

    public function student()
    {
        return $this->belongsTo(StudentList::class, 'student_id');
    }

    public function parent()
    {
        return $this->belongsTo(ParentInfo::class, 'parent_id');
    }
}

