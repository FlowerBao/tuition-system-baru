<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'level',
        'subject_class',
    ];

    // public function reserves(){
    //     return $this->hasMany(Subject::class, 'tutor_id');
    // }

    public function tutors()
    {
        return $this->hasMany(Tutor::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

   public function students()
    {
        return $this->belongsToMany(StudentList::class, 'enrollments', 'subject_id', 'student_id');
    }
    
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}