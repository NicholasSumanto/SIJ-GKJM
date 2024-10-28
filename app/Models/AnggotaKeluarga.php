<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    use HasFactory;

    protected $table = 'anggota_keluarga';
    protected $primaryKey = 'id_anggota_keluarga';

    protected $fillable = [
        'id_jemaat',
        'id_keluarga',
        'nama_anggota',
        'id_status',
    ];


    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat');
    }
    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'id_keluarga');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }
}
