<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    /** @use HasFactory<\Database\Factories\TutorFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'tutor_name',
        'tutor_ic',
        'tutor_email',
        'tutor_phone', 
        'tutor_address', 
        'subject_id',
    ];

    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

    public function subject()
{
    return $this->belongsTo(\App\Models\Subject::class);
}

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'tutor_id');
    }
}
