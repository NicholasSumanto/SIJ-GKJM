<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtestasiKeluar extends Model
{
    use HasFactory;

    protected $table = 'atestasi_keluar';
    protected $primaryKey = 'id_keluar';

    protected $fillable = [
        'id_jemaat',
        'id_wilayah',
        'nama_gereja',
        'no_surat',
        'tanggal',
        'keterangan',
    ];

    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah', 'id_wilayah');
    }
}
