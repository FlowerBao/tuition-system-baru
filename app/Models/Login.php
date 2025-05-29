<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Login extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'logged_in_at',
        'action',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'logged_in_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}