<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jemaat extends Model
{
    use HasFactory;

    protected $table = 'jemaat';

    protected $fillable = [
        'id_wilayah',
        'id_status',
        'stamboek',
        'nama_jemaat',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kelamin',
        'alamat_jemaat',
        'id_kelurahan',
        'id_kecamatan',
        'id_kabupaten',
        'id_provinsi',
        'kodepos',
        'telepon',
        'hp',
        'email',
        'nik',
        'no_kk',
        'photo',
        'id_nikah',
        'id_sidi',
        'id_ba',
        'id_bd',
        'tanggal_baptis',
        'golongan_darah',
        'id_pendidikan',
        'id_ilmu',
        'id_pekerjaan',
        'instansi',
        'penghasilan',
        'gereja_baptis',
        'alat_transportasi',
    ];

 
}

