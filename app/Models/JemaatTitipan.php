<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JemaatTitipan extends Model
{
    use HasFactory;

    protected $table = 'jemaat_titipan';
    protected $primaryKey = 'id_titipan';

    protected $fillable = [
        'nama_jemaat',
        'nama_gereja',
        'id_jemaat',
        'kelamin',
        'alamat_jemaat',
        'titipan',
        'surat',
    ];

}
