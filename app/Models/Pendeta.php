<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendeta extends Model
{
    use HasFactory;

    protected $table = 'pendeta';
    protected $primaryKey = 'id_pendeta';

    protected $fillable = [
        'nama_pendeta',
        'jenjang',
        'sekolah',
        'tahun_lulus',
        'keterangan',
        'ijazah',
    ];
}
