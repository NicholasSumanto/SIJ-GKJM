<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga';
    protected $primaryKey = 'id_keluarga';

    protected $fillable = [
        'id_jemaat',
        'kepala_keluarga',
        'id_wilayah',
    ];
    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat');
    }
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }

}
