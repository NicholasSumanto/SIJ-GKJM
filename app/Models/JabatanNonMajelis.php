<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanNonMajelis extends Model
{
    use HasFactory;

    protected $table = 'jabatan_nonmajelis';
    protected $primaryKey = 'id_jabatan_non';

    protected $fillable = [
        'jabatan_nonmajelis',
        'periode',
    ];
}
