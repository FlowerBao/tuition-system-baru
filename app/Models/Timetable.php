<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timetable extends Model
{
    /** @use HasFactory<\Database\Factories\TimetableFactory> */
    use HasFactory;

    protected $fillable = ['subject_id', 'day', 'start_time', 'end_time', 'classroom_name'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
