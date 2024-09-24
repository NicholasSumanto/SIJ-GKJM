<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaptisDewasa extends Model
{
    use HasFactory;

    protected $table = 'baptis_dewasa';
    protected $primaryKey = 'id_bd';

    protected $fillable = [
        'id_wilayah',
        'id_pendeta',
        'nomor',
        'nama',
        'tempat_lahir',
        'tangal_lahir',
        'ayah',
        'ibu',
        'tanggal_baptis',
        'ketua_majelis',
        'sekretaris_majelis',
    ];
}
