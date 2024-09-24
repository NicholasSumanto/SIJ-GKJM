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
        'no_surat',
        'tanggal',
        'surat',
    ];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah', 'id_wilayah');
    }

    public function gereja()
    {
        return $this->belongsTo(Gereja::class, 'id_gereja', 'id_gereja');
    }
}
