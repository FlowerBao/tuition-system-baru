<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tutor;

class Certificate extends Model
{
    /** @use HasFactory<\Database\Factories\CertificateFactory> */
    use HasFactory;
    protected $table = 'certificates';
    
    protected $fillable = [
        'name',
        'file_path',
        'tutor_id',
    ];

    public function tutor()
{
     return $this->belongsTo(\App\Models\Tutor::class, 'tutor_id');
}

}
