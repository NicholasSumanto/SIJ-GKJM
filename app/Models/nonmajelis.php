<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonMajelis extends Model
{
    use HasFactory;

    protected $table = 'nonmajelis';
    protected $primaryKey = 'id_nonmajelis';

    protected $fillable = [
        'id_jemaat',
        'nama_majelis_non',
        'id_gereja',
        'tanggal_mulai',
        'tanggal_selesai',
        'id_jabatan_non',
        'id_status',
        'no_sk',
        'berkas',
    ];

    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat');
    }

    public function gereja()
    {
        return $this->belongsTo(Gereja::class, 'id_gereja');
    }

    public function jabatanNonMajelis()
    {
        return $this->belongsTo(JabatanNonMajelis::class, 'id_jabatan_non');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }
}
