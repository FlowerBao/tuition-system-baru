<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    /** @use HasFactory<\Database\Factories\CertificateFactory> */
    use HasFactory;
    protected $table = 'certificates';
    
    public function tutor()
{
    return $this->belongsTo(User::class, 'tutor_id');
}

}
