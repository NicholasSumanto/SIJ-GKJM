<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendetaDidik extends Model
{
    use HasFactory;

    protected $table = 'pendeta_didik';
    protected $primaryKey = 'id_didik';

    protected $fillable = [
        'id_pendeta',
        'nama_pendeta_didik',
        'jenjang',
        'sekolah',
        'tahun_lulus',
        'keterangan',
        'ijazah',
    ];

    public function pendeta()
    {
        return $this->belongsTo(Pendeta::class, 'id_pendeta');
    }
}
