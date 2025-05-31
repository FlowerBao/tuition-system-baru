<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentInfo extends Model
{
    /** @use HasFactory<\Database\Factories\ParentInfoFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_name',
        'parent_ic',
        'parent_email',
        'parent_phone',
        'parent_address'
    ];

   public function user()
{
    return $this->belongsTo(User::class);
}

public function students()
{
    return $this->hasMany(StudentList::class, 'parent_id');
}


}

