<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaptisSidi extends Model
{
    use HasFactory;

    protected $table = 'baptis_sidi';
    protected $primaryKey = 'id_sidi';

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
