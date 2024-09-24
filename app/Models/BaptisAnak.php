<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaptisAnak extends Model
{
    use HasFactory;

    protected $table = 'baptis_anak';
    protected $primaryKey = 'id_ba';

    protected $fillable = [
        'id_wilayah',
        'id_pendeta',
        'nomor',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'ayah',
        'ibu',
        'tanggal_baptis',
        'ketua_majelis',
        'sekretaris_majelis',
    ];
}
