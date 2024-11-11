<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtestasiKeluarDtl extends Model
{
    use HasFactory;

    protected $table = 'atestasi_keluar_dtl';
    protected $primaryKey = 'id_keluar_dtl';

    protected $fillable = [
        'id_keluar',
        'id_jemaat',
        'keterangan',
    ];

    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
    }
}
