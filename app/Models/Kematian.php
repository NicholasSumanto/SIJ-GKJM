<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kematian extends Model
{
    use HasFactory;

    protected $table = 'kematian';
    protected $primaryKey = 'id_kematian';

    protected $fillable = [
        'id_jemaat',
        'nama_gereja',
        'id_pendeta',
        'tanggal_meninggal',
        'tanggal_pemakaman',
        'tempat_pemakaman',
        'keterangan',
    ];

    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
    }

    public function pendeta()
    {
        return $this->belongsTo(Pendeta::class, 'id_pendeta', 'id_pendeta');
    }
}
