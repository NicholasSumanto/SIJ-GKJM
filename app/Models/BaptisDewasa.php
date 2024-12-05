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
        'status',
        'id_jemaat',
        'id_wilayah',
        'id_pendeta',
        'alamat',
        'kelamin',
        'nomor_bd',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'ayah',
        'ibu',
        'tanggal_baptis',
        'ketua_majelis',
        'sekretaris_majelis',
    ];
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }
    public function pendeta()
    {
        return $this->belongsTo(Pendeta::class, 'id_pendeta');
    }
}
