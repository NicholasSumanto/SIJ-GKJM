<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluargaDetil extends Model
{
    use HasFactory;

    protected $table = 'keluarga_detil';
    protected $primaryKey = 'id_keluarga_detil';

    protected $fillable = [
        'id_jemaat',
        'id_keluarga',
    ];

    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'id_keluarga', 'id_keluarga');
    }
}

