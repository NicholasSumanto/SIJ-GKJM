<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JemaatTitipan extends Model
{
    use HasFactory;

    protected $table = 'jemaat_titipan';

    protected $fillable = [
        'id_wilayah',
        'id_status',
        'nama_jemaat',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kelamin',
        'alamat_jemaat',
        'alamat_domisili',
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
        'nama_ortu',
        'telepon_ortu',
        'photo',
        'tanggal_baptis',
        'golongan_darah',
        'id_pendidikan',
        'id_ilmu',
        'id_pekerjaan',
        'instansi',
        'penghasilan',
        'gereja_ibadah',
        'alat_transportasi',
        'nomorsurat',
        'surat',
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
