<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtestasiMasuk extends Model
{
    use HasFactory;

    protected $table = 'atestasi_masuk';
    protected $primaryKey = 'id_masuk';

    protected $fillable = [
        'id_wilayah',
        'id_gereja',
        'id_jemaat',
        'no_surat',
        'tanggal',
        'surat',
    ];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }

    public function gereja()
    {
        return $this->belongsTo(Gereja::class, 'id_gereja');
    }
    
    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat');
    }
}
