<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pernikahan extends Model
{
    use HasFactory;

    protected $table = 'pernikahan';
    protected $primaryKey = 'id_nikah';

    protected $fillable = [
        'nomor',
        'nama_gereja',
        'tanggal_nikah',
        'id_pendeta',
        'pengantin_pria',
        'pengantin_wanita',
        'ayah_pria',
        'ibu_pria',
        'ayah_wanita',
        'ibu_wanita',
        'saksi1',
        'saksi2',
        'warga',
        'tempat',
        'ketua_majelis',
        'sekretaris_majelis',
    ];

    public function pendeta()
    {
        return $this->belongsTo(Pendeta::class, 'id_pendeta');
    }
}
