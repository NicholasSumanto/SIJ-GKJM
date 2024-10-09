<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jemaat extends Model
{
    use HasFactory;

    protected $table = 'jemaat';
    protected $primaryKey = 'id_jemaat';

    protected $fillable = [
        'id_wilayah',
        'id_status',
        'stamboek',
        'nama_jemaat',
        'tempat_lahir',
        'tanggal_lahir',
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

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'id_kelurahan');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'id_kabupaten');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi');
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'id_pendidikan');
    }

    public function ilmu()
    {
        return $this->belongsTo(BidangIlmu::class, 'id_ilmu');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'id_pekerjaan');
    }


}

