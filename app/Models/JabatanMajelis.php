<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanMajelis extends Model
{
    use HasFactory;

    protected $table = 'jabatan_majelis';
    protected $primaryKey = 'id_jabatan';

    protected $fillable = [
        'jabatan_majelis',
        'periode',
    ];
}
