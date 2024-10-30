<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Majelis extends Model
{
    use HasFactory;

    protected $table = 'majelis';
    protected $primaryKey = 'id_majelis';

    protected $fillable = [
        'id_jemaat',
        'nama_majelis',
        'tanggal_mulai',
        'tanggal_selesai',
        'id_jabatan',
        'id_status',
        'no_sk',
        'berkas',
    ];

    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat');
    }

    public function jabatanMajelis()
    {
        return $this->belongsTo(JabatanMajelis::class, 'id_jabatan');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }
}
