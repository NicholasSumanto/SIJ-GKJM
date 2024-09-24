<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';
    protected $primaryKey = 'id_wilayah';

    protected $fillable = [
        'nama_wilayah',
        'alamat_wilayah',
        'kota_wilayah',
        'email_wilayah',
        'telepon_wilayah',
    ];
}
