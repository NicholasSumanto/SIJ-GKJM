<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// PENGATURAN
use App\Models\Wilayah as Wilayah;
use App\Models\JabatanMajelis as JabatanMajelis;
use App\Models\JabatanNonMajelis as JabatanNonMajelis;
use App\Models\User as User;
use App\Models\Pekerjaan as Pekerjaan;
// daerah

// DATA
use App\Models\Jemaat as Jemaat;
use App\Models\Keluarga as Keluarga;
//jemaat baru
use App\Models\Majelis as Majelis;
use App\Models\NonMajelis as NonMajelis;

// TRANSAKSI
use App\Models\Pernikahan as Pernikahan;
use App\Models\Kematian as Kematian;
use App\Models\AtestasiKeluar as AtestasiKeluar;
use App\Models\AtestasiMasuk as AtestasiMasuk;
use App\Models\BaptisAnak as BaptisAnak;
use App\Models\BaptisDewasa as BaptisDewasa;
use App\Models\BaptisSidi as BaptisSidi;

class ApiController extends Controller
{
    // API for getting all data
// GET WILAYAH
    public function ApiGetWilayah(Request $request)
    {
        if ($request->has('id')) {
            $data = Wilayah::where('id_wilayah', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Wilayah::count(),
                'rows' => $data->map(function ($item) {
                    return [
                        'id_wilayah' => $item->id_wilayah,
                        'nama_wilayah' => $item->nama_wilayah,
                        'alamat_wilayah' => $item->alamat_wilayah,
                        'kota_wilayah' => $item->kota_wilayah,
                        'email_wilayah' => $item->email_wilayah,
                        'telepon_wilayah' => $item->telepon_wilayah,
                    ];
                })->toArray()
            ];

            return response()->json($formattedData);
        } else {
            $data = Wilayah::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Wilayah::count(),
                'rows' => $data->map(function ($item) {
                    return [
                        'id_wilayah' => $item->id_wilayah,
                        'nama_wilayah' => $item->nama_wilayah,
                        'alamat_wilayah' => $item->alamat_wilayah,
                        'kota_wilayah' => $item->kota_wilayah,
                        'email_wilayah' => $item->email_wilayah,
                        'telepon_wilayah' => $item->telepon_wilayah,
                    ];
                })->toArray()
            ];
            return response()->json($data);
        }
    }
// GET WILAYAH END

// GET JABATAN MAJELIS
   public function ApiGetJabatanMajelis(Request $request) {
        if ($request->has('id')) {
            $data = JabatanMajelis::where('id_jabatan', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => JabatanMajelis::count(),
                'rows' => $data->map(function ($item) {
                    return [
                        'id_jabatan' => $item->id_jabatan,
                        'jabatan_majelis' => $item->jabatan_majelis,
                        'periode' => $item->periode,
                    ];
                })->toArray()
            ];

            return response()->json($formattedData);
        } else {
            $data = JabatanMajelis::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => JabatanMajelis::count(),
                'rows' => $data->map(function ($item) {
                    return [
                        'id_jabatan' => $item->id_jabatan,
                        'jabatan_majelis' => $item->jabatan_majelis,
                        'periode' => $item->periode,
                    ];
                })->toArray()
            ];
            return response()->json($data);
        }
   }
// GET JABATAN MAJELIS END

// GET JABATAN NON MAJELIS
   public function ApiGetJabatanNonMajelis(Request $request) {
    if ($request->has('id')) {
        $data = JabatanNonMajelis::where('id_jabatan_non', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => JabatanMajelis::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_jabatan_non' => $item->id_jabatan_non,
                    'jabatan_nonmajelis' => $item->jabatan_nonmajelis,
                    'periode' => $item->periode,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = JabatanNonMajelis::all();
        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => JabatanMajelis::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_jabatan_non' => $item->id_jabatan_non,
                    'jabatan_nonmajelis' => $item->jabatan_nonmajelis,
                    'periode' => $item->periode,
                ];
            })->toArray()
        ];
        return response()->json($data);
    }
}
// GET JABATAN NON MAJELIS END

// GET USER
public function ApiGetUser(Request $request)
{
    if ($request->has('username')) {
        $data = User::where('username', $request->username)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => User::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'username' => $item->username,
                    'nama_user' => $item->nama_user,
                    'role' => $item->role ? $item->role->nama_role : null,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = User::all();
        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => User::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'username' => $item->username,
                    'nama_user' => $item->nama_user,
                    'role' => $item->role ? $item->role->nama_role : null,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}
// GET USER END

// GET PEKERJAAN
public function ApiGetPekerjaan(Request $request)
{
    if ($request->has('id')) {
        $data = Pekerjaan::where('id_pekerjaan', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Pekerjaan::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_pekerjaan' => $item->id_pekerjaan,
                    'pekerjaan' => $item->pekerjaan,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = Pekerjaan::all();
        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Pekerjaan::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_pekerjaan' => $item->id_pekerjaan,
                    'pekerjaan' => $item->pekerjaan,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}
// GET PEKERJAAN END

// GET JEMAAT
public function ApiGetJemaat(Request $request)
{
    if ($request->has('id')) {
        $data = Jemaat::where('id_jemaat', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Jemaat::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_jemaat' => $item->id_jemaat,
                    'id_wilayah' => $item->id_wilayah,
                    'nama_wilayah' => $item->wilayah ? $item->wilayah->nama_wilayah : null,
                    'id_status' => $item->id_status,
                    'status' => $item->status ? $item->status->nama_status : null,
                    'stamboek' => $item->stamboek,
                    'nama_jemaat' => $item->nama_jemaat,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'agama' => $item->agama,
                    'kelamin' => $item->kelamin,
                    'alamat_jemaat' => $item->alamat_jemaat,
                    'id_kelurahan' => $item->id_kelurahan,
                    'nama_kelurahan' => $item->kelurahan ? $item->kelurahan->nama_kelurahan : null,
                    'id_kecamatan' => $item->id_kecamatan,
                    'nama_kecamatan' => $item->kecamatan ? $item->kecamatan->nama_kecamatan : null,
                    'id_kabupaten' => $item->id_kabupaten,
                    'nama_kabupaten' => $item->kabupaten ? $item->kabupaten->nama_kabupaten : null,
                    'id_provinsi' => $item->id_provinsi,
                    'nama_provinsi' => $item->provinsi ? $item->provinsi->nama_provinsi : null,
                    'kodepos' => $item->kodepos,
                    'telepon' => $item->telepon,
                    'hp' => $item->hp,
                    'email' => $item->email,
                    'nik' => $item->nik,
                    'no_kk' => $item->no_kk,
                    'photo' => $item->photo,
                    'tanggal_baptis' => $item->tanggal_baptis,
                    'golongan_darah' => $item->golongan_darah,
                    'id_pendidikan' => $item->id_pendidikan,
                    'pendidikan' => $item->pendidikan ? $item->pendidikan->nama_pendidikan : null,
                    'id_ilmu' => $item->id_ilmu,
                    'bidang_ilmu' => $item->ilmu ? $item->ilmu->nama_ilmu : null,
                    'id_pekerjaan' => $item->id_pekerjaan,
                    'pekerjaan' => $item->pekerjaan ? $item->pekerjaan->pekerjaan : null,
                    'instansi' => $item->instansi,
                    'penghasilan' => $item->penghasilan,
                    'gereja_baptis' => $item->gereja_baptis,
                    'alat_transportasi' => $item->alat_transportasi,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = Jemaat::all();
        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Jemaat::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_jemaat' => $item->id_jemaat,
                    'id_wilayah' => $item->id_wilayah,
                    'nama_wilayah' => $item->wilayah ? $item->wilayah->nama_wilayah : null,
                    'id_status' => $item->id_status,
                    'status' => $item->status ? $item->status->nama_status : null,
                    'stamboek' => $item->stamboek,
                    'nama_jemaat' => $item->nama_jemaat,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'agama' => $item->agama,
                    'kelamin' => $item->kelamin,
                    'alamat_jemaat' => $item->alamat_jemaat,
                    'id_kelurahan' => $item->id_kelurahan,
                    'nama_kelurahan' => $item->kelurahan ? $item->kelurahan->nama_kelurahan : null,
                    'id_kecamatan' => $item->id_kecamatan,
                    'nama_kecamatan' => $item->kecamatan ? $item->kecamatan->nama_kecamatan : null,
                    'id_kabupaten' => $item->id_kabupaten,
                    'nama_kabupaten' => $item->kabupaten ? $item->kabupaten->nama_kabupaten : null,
                    'id_provinsi' => $item->id_provinsi,
                    'nama_provinsi' => $item->provinsi ? $item->provinsi->nama_provinsi : null,
                    'kodepos' => $item->kodepos,
                    'telepon' => $item->telepon,
                    'hp' => $item->hp,
                    'email' => $item->email,
                    'nik' => $item->nik,
                    'no_kk' => $item->no_kk,
                    'photo' => $item->photo,
                    'tanggal_baptis' => $item->tanggal_baptis,
                    'golongan_darah' => $item->golongan_darah,
                    'id_pendidikan' => $item->id_pendidikan,
                    'pendidikan' => $item->pendidikan ? $item->pendidikan->nama_pendidikan : null,
                    'id_ilmu' => $item->id_ilmu,
                    'bidang_ilmu' => $item->ilmu ? $item->ilmu->nama_ilmu : null,
                    'id_pekerjaan' => $item->id_pekerjaan,
                    'pekerjaan' => $item->pekerjaan ? $item->pekerjaan->pekerjaan : null,
                    'instansi' => $item->instansi,
                    'penghasilan' => $item->penghasilan,
                    'gereja_baptis' => $item->gereja_baptis,
                    'alat_transportasi' => $item->alat_transportasi,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}
// GET JEMAAT END

// GET KELUARGA
public function ApiGetKeluarga(Request $request) {
    if ($request->has('id')) {
        $data = Keluarga::where('id_keluarga', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Keluarga::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_keluarga' => $item->id_keluarga,
                    'id_jemaat' => $item->id_jemaat,
                    'id_gereja' => $item->id_gereja,
                    'jemaat' => $item->jemaat,
                    'gereja' => $item->gereja,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = Keluarga::all();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Keluarga::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_keluarga' => $item->id_keluarga,
                    'id_jemaat' => $item->id_jemaat,
                    'id_gereja' => $item->id_gereja,
                    'jemaat' => $item->jemaat,
                    'gereja' => $item->gereja,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}

// GET KELUARGA END

// GET MAJELIS
public function apiGetMajelis(Request $request)
{

    if ($request->has('id')) {
        $data = Majelis::where('id_majelis', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Majelis::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_majelis' => $item->id_majelis,
                    'id_jemaat' => $item->id_jemaat,
                    'nama_majelis' => $item->nama_majelis,
                    'id_gereja' => $item->id_gereja,
                    'tanggal_mulai' => $item->tanggal_mulai,
                    'tanggal_selesai' => $item->tanggal_selesai,
                    'id_jabatan' => $item->id_jabatan,
                    'id_status' => $item->id_status,
                    'no_sk' => $item->no_sk,
                    'berkas' => $item->berkas,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = Majelis::all();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Majelis::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_majelis' => $item->id_majelis,
                    'id_jemaat' => $item->id_jemaat,
                    'nama_majelis' => $item->nama_majelis,
                    'id_gereja' => $item->id_gereja,
                    'tanggal_mulai' => $item->tanggal_mulai,
                    'tanggal_selesai' => $item->tanggal_selesai,
                    'id_jabatan' => $item->id_jabatan,
                    'id_status' => $item->id_status,
                    'no_sk' => $item->no_sk,
                    'berkas' => $item->berkas,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}

// GET MAJELIS END

// GET NON MAJELIS
public function apiGetNonMajelis(Request $request)
    {
        if ($request->has('id')) {
            $data = NonMajelis::where('id_nonmajelis', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => NonMajelis::count(),
                'rows' => $data->map(function ($item) {
                    return [
                        'id_nonmajelis' => $item->id_nonmajelis,
                        'id_jemaat' => $item->id_jemaat,
                        'nama_majelis_non' => $item->nama_majelis_non,
                        'id_gereja' => $item->id_gereja,
                        'tanggal_mulai' => $item->tanggal_mulai,
                        'tanggal_selesai' => $item->tanggal_selesai,
                        'id_jabatan_non' => $item->id_jabatan_non,
                        'id_status' => $item->id_status,
                        'no_sk' => $item->no_sk,
                        'berkas' => $item->berkas,
                    ];
                })->toArray()
            ];

            return response()->json($formattedData);
        } else {
            $data = NonMajelis::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => NonMajelis::count(),
                'rows' => $data->map(function ($item) {
                    return [
                        'id_nonmajelis' => $item->id_nonmajelis,
                        'id_jemaat' => $item->id_jemaat,
                        'nama_majelis_non' => $item->nama_majelis_non,
                        'id_gereja' => $item->id_gereja,
                        'tanggal_mulai' => $item->tanggal_mulai,
                        'tanggal_selesai' => $item->tanggal_selesai,
                        'id_jabatan_non' => $item->id_jabatan_non,
                        'id_status' => $item->id_status,
                        'no_sk' => $item->no_sk,
                        'berkas' => $item->berkas,
                    ];
                })->toArray()
            ];

            return response()->json($formattedData);
        }
    }
// GET NON MAJELIS END

// GET PERNIKAHAN
public function ApiGetPernikahan(Request $request) {
    if ($request->has('id')) {
        $data = Pernikahan::where('id_nikah', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Pernikahan::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_nikah' => $item->id_nikah,
                    'nomor' => $item->nomor,
                    'id_gereja' => $item->id_gereja,
                    'tanggal_nikah' => $item->tanggal_nikah,
                    'id_pendeta' => $item->id_pendeta,
                    'pengantin_pria' => $item->pengantin_pria,
                    'pengantin_wanita' => $item->pengantin_wanita,
                    'ayah_pria' => $item->ayah_pria,
                    'ibu_pria' => $item->ibu_pria,
                    'ayah_wanita' => $item->ayah_wanita,
                    'ibu_wanita' => $item->ibu_wanita,
                    'saksi1' => $item->saksi1,
                    'saksi2' => $item->saksi2,
                    'warga' => $item->warga,
                    'tempat' => $item->tempat,
                    'ketua_majelis' => $item->ketua_majelis,
                    'sekretaris_majelis' => $item->sekretaris_majelis,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = Pernikahan::all();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Pernikahan::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_nikah' => $item->id_nikah,
                    'nomor' => $item->nomor,
                    'id_gereja' => $item->id_gereja,
                    'tanggal_nikah' => $item->tanggal_nikah,
                    'id_pendeta' => $item->id_pendeta,
                    'pengantin_pria' => $item->pengantin_pria,
                    'pengantin_wanita' => $item->pengantin_wanita,
                    'ayah_pria' => $item->ayah_pria,
                    'ibu_pria' => $item->ibu_pria,
                    'ayah_wanita' => $item->ayah_wanita,
                    'ibu_wanita' => $item->ibu_wanita,
                    'saksi1' => $item->saksi1,
                    'saksi2' => $item->saksi2,
                    'warga' => $item->warga,
                    'tempat' => $item->tempat,
                    'ketua_majelis' => $item->ketua_majelis,
                    'sekretaris_majelis' => $item->sekretaris_majelis,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}

// GET PERNIKAHAN END

// GET KEMATIAN
public function ApiGetKematian(Request $request) {
    if ($request->has('id')) {
        $data = Kematian::where('id_kematian', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Kematian::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_kematian' => $item->id_kematian,
                    'id_jemaat' => $item->id_jemaat,
                    'id_gereja' => $item->id_gereja,
                    'id_pendeta' => $item->id_pendeta,
                    'tanggal_meninggal' => $item->tanggal_meninggal,
                    'tanggal_pemakaman' => $item->tanggal_pemakaman,
                    'tempat_pemakaman' => $item->tempat_pemakaman,
                    'keterangan' => $item->keterangan,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = Kematian::all();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => Kematian::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_kematian' => $item->id_kematian,
                    'id_jemaat' => $item->id_jemaat,
                    'id_gereja' => $item->id_gereja,
                    'id_pendeta' => $item->id_pendeta,
                    'tanggal_meninggal' => $item->tanggal_meninggal,
                    'tanggal_pemakaman' => $item->tanggal_pemakaman,
                    'tempat_pemakaman' => $item->tempat_pemakaman,
                    'keterangan' => $item->keterangan,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}

// GET KEMATIAN END

// GET ATESTASI KELUAR
public function ApiGetAtestasiKeluar(Request $request) {
    if ($request->has('id')) {
        $data = AtestasiKeluar::where('id_keluar', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => AtestasiKeluar::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_keluar' => $item->id_keluar,
                    'id_jemaat' => $item->id_jemaat,
                    'id_pendeta' => $item->id_pendeta,
                    'id_gereja' => $item->id_gereja,
                    'no_surat' => $item->no_surat,
                    'tanggal' => $item->tanggal,
                    'keterangan' => $item->keterangan,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = AtestasiKeluar::all();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => AtestasiKeluar::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_keluar' => $item->id_keluar,
                    'id_jemaat' => $item->id_jemaat,
                    'id_pendeta' => $item->id_pendeta,
                    'id_gereja' => $item->id_gereja,
                    'no_surat' => $item->no_surat,
                    'tanggal' => $item->tanggal,
                    'keterangan' => $item->keterangan,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}

// GET ATESTSI KELUAR END

// GET ATESTASI MASUK
public function ApiGetAtestasiMasuk(Request $request) {
    if ($request->has('id')) {
        $data = AtestasiMasuk::where('id_masuk', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => AtestasiMasuk::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_masuk' => $item->id_masuk,
                    'id_wilayah' => $item->id_wilayah,
                    'id_gereja' => $item->id_gereja,
                    'no_surat' => $item->no_surat,
                    'tanggal' => $item->tanggal,
                    'surat' => $item->surat,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = AtestasiMasuk::all();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => AtestasiMasuk::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_masuk' => $item->id_masuk,
                    'id_wilayah' => $item->id_wilayah,
                    'id_gereja' => $item->id_gereja,
                    'no_surat' => $item->no_surat,
                    'tanggal' => $item->tanggal,
                    'surat' => $item->surat,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}
// GET ATESTASI MASUK END

// GET BAPTIS ANAK
public function ApiGetBaptisAnak(Request $request) {
    if ($request->has('id')) {
        $data = BaptisAnak::where('id_ba', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => BaptisAnak::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_ba' => $item->id_ba,
                    'id_wilayah' => $item->id_wilayah,
                    'id_pendeta' => $item->id_pendeta,
                    'nomor' => $item->nomor,
                    'nama' => $item->nama,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'ayah' => $item->ayah,
                    'ibu' => $item->ibu,
                    'tanggal_baptis' => $item->tanggal_baptis,
                    'ketua_majelis' => $item->ketua_majelis,
                    'sekretaris_majelis' => $item->sekretaris_majelis,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = BaptisAnak::all();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => BaptisAnak::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_ba' => $item->id_ba,
                    'id_wilayah' => $item->id_wilayah,
                    'id_pendeta' => $item->id_pendeta,
                    'nomor' => $item->nomor,
                    'nama' => $item->nama,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'ayah' => $item->ayah,
                    'ibu' => $item->ibu,
                    'tanggal_baptis' => $item->tanggal_baptis,
                    'ketua_majelis' => $item->ketua_majelis,
                    'sekretaris_majelis' => $item->sekretaris_majelis,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}

// GET BAPTIS ANAK END

// GET BAPTIS DEWASA
public function ApiGetBaptisDewasa(Request $request) {
    if ($request->has('id')) {
        $data = BaptisDewasa::where('id_bd', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => BaptisDewasa::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_bd' => $item->id_bd,
                    'id_wilayah' => $item->id_wilayah,
                    'id_pendeta' => $item->id_pendeta,
                    'nomor' => $item->nomor,
                    'nama' => $item->nama,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'ayah' => $item->ayah,
                    'ibu' => $item->ibu,
                    'tanggal_baptis' => $item->tanggal_baptis,
                    'ketua_majelis' => $item->ketua_majelis,
                    'sekretaris_majelis' => $item->sekretaris_majelis,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = BaptisDewasa::all();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => BaptisDewasa::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_bd' => $item->id_bd,
                    'id_wilayah' => $item->id_wilayah,
                    'id_pendeta' => $item->id_pendeta,
                    'nomor' => $item->nomor,
                    'nama' => $item->nama,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'ayah' => $item->ayah,
                    'ibu' => $item->ibu,
                    'tanggal_baptis' => $item->tanggal_baptis,
                    'ketua_majelis' => $item->ketua_majelis,
                    'sekretaris_majelis' => $item->sekretaris_majelis,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}

// GET BAPTIS DEWASA END

// GET BAPTIS SIDI
public function ApiGetBaptisSidi(Request $request) {
    if ($request->has('id')) {
        $data = BaptisSidi::where('id_sidi', $request->id)->get();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => BaptisSidi::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_sidi' => $item->id_sidi,
                    'id_wilayah' => $item->id_wilayah,
                    'id_pendeta' => $item->id_pendeta,
                    'nomor' => $item->nomor,
                    'nama' => $item->nama,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'ayah' => $item->ayah,
                    'ibu' => $item->ibu,
                    'tanggal_baptis' => $item->tanggal_baptis,
                    'ketua_majelis' => $item->ketua_majelis,
                    'sekretaris_majelis' => $item->sekretaris_majelis,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    } else {
        $data = BaptisSidi::all();

        $formattedData = [
            'total' => $data->count(),
            'totalNotFiltered' => BaptisSidi::count(),
            'rows' => $data->map(function ($item) {
                return [
                    'id_sidi' => $item->id_sidi,
                    'id_wilayah' => $item->id_wilayah,
                    'id_pendeta' => $item->id_pendeta,
                    'nomor' => $item->nomor,
                    'nama' => $item->nama,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'ayah' => $item->ayah,
                    'ibu' => $item->ibu,
                    'tanggal_baptis' => $item->tanggal_baptis,
                    'ketua_majelis' => $item->ketua_majelis,
                    'sekretaris_majelis' => $item->sekretaris_majelis,
                ];
            })->toArray()
        ];

        return response()->json($formattedData);
    }
}

// GET BAPTIS SIDI END

    // API for getting all data END

    // API for posting data
//POST WILAYAH
    public function ApiPostWilayah(Request $request)
    {
        if (Wilayah::where('id_wilayah', $request->id_wilayah)->first() != null) {
            return response()->json([
                'message' => 'Data already exists'
            ]);
        }
        $data = new Wilayah();
        $data->id_wilayah = $request->id_wilayah;
        $data->nama_wilayah = $request->nama_wilayah;
        $data->alamat_wilayah = $request->alamat_wilayah;
        $data->kota_wilayah = $request->kota_wilayah;
        $data->email_wilayah = $request->email_wilayah;
        $data->telepon_wilayah = $request->telepon_wilayah;
        $data->save();

        return response()->json($data);
    }
// POST WILAYAH END

// POST JABATAN MAJELIS
    public function ApiPostJabatanMajelis(Request $request)
    {
        if (Majelis::where('id_majelis', $request->id_majelis)->first() != null) {
            return response()->json([
                'message' => 'Data already exists'
            ]);
        }
        $data = new JabatanMajelis();
        $data->id_jabatan = $request->id_jabatan;
        $data->jabatan_majelis = $request->jabatan_majelis;
        $data->periode = $request->periode;
        $data->save();

        return response()->json($data);
    }
// POST JABATAN MAJELIS END

// POST JABATAN NON MAJELIS
    public function ApiPostJabatanNonMajelis(Request $request)
    {
        if(JabatanNonMajelis::where('id_jabatan_non', $request->id_jabatan_non)->first() != null) {
            return response()->json([
                'message' => 'Data already exists'
            ]);
        }

        $data = new JabatanNonMajelis();
        $data->id_jabatan_non = $request->id_jabatan_non;
        $data->jabatan_nonmajelis = $request->jabatan_nonmajelis;
        $data->periode = $request->periode;
        $data->save();

        return response()->json($data);
    }
// POST JABATAN NON MAJELIS END

// POST USER
// public function ApiPostUser(Request $request)
// {
//     $validatedData = $request->validate([
//         'username' => 'required|string|max:255|unique:users',
//         'nama_user' => 'required|string|max:255',
//         'role_id' => 'required|exists:roles,id',
//         'password' => 'required|string|min:6',
//     ]);
//     $user = User::create([
//         'username' => $validatedData['username'],
//         'nama_user' => $validatedData['nama_user'],
//         'role_id' => $validatedData['role_id'],
//         'password' => Hash::make($validatedData['password']),
//     ]);

//     return response()->json([
//         'message' => 'User created successfully',
//         'user' => [
//             'username' => $user->username,
//             'nama_user' => $user->nama_user,
//             'role' => $user->role ? $user->role->nama_role : null,
//         ]
//     ], 201);
// }
// POST USER END

// POST PEKERJAAN
    public function ApiPostPekerjaan(Request $request)
{

    if (Pekerjaan::where('id_pekerjaan', $request->id_pekerjaan)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = new Pekerjaan();
    $data->id_pekerjaan = $request->id_pekerjaan;
    $data->pekerjaan = $request->pekerjaan;
    $data->save();

    return response()->json($data);
}

// POST PEKERJAAN END

// POST JEMAAT
public function ApiPostJemaat(Request $request)
{

    if (Jemaat::where('id_jemaat', $request->id_jemaat)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = new Jemaat();
    $data->id_jemaat = $request->id_jemaat;
    $data->id_wilayah = $request->id_wilayah;
    $data->id_status = $request->id_status;
    $data->stamboek = $request->stamboek;
    $data->nama_jemaat = $request->nama_jemaat;
    $data->tempat_lahir = $request->tempat_lahir;
    $data->tanggal_lahir = $request->tanggal_lahir;
    $data->agama = $request->agama;
    $data->kelamin = $request->kelamin;
    $data->alamat_jemaat = $request->alamat_jemaat;
    $data->id_kelurahan = $request->id_kelurahan;
    $data->id_kecamatan = $request->id_kecamatan;
    $data->id_kabupaten = $request->id_kabupaten;
    $data->id_provinsi = $request->id_provinsi;
    $data->kodepos = $request->kodepos;
    $data->telepon = $request->telepon;
    $data->hp = $request->hp;
    $data->email = $request->email;
    $data->nik = $request->nik;
    $data->no_kk = $request->no_kk;
    $data->photo = $request->photo;
    $data->tanggal_baptis = $request->tanggal_baptis;
    $data->golongan_darah = $request->golongan_darah;
    $data->id_pendidikan = $request->id_pendidikan;
    $data->id_ilmu = $request->id_ilmu;
    $data->id_pekerjaan = $request->id_pekerjaan;
    $data->instansi = $request->instansi;
    $data->penghasilan = $request->penghasilan;
    $data->gereja_baptis = $request->gereja_baptis;
    $data->alat_transportasi = $request->alat_transportasi;
    $data->save();

    return response()->json($data);
}
// POST JEMAAT END

// POST KELUARGA
public function ApiPostKeluarga(Request $request)
{

    if (Keluarga::where('id_keluarga', $request->id_keluarga)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = new Keluarga();
    $data->id_keluarga = $request->id_keluarga;
    $data->id_jemaat = $request->id_jemaat;
    $data->id_gereja = $request->id_gereja;
    $data->save();

    return response()->json($data);
}
// POST KELUARGA END

// POST MAJELIS
public function ApiPostMajelis(Request $request)
{
    // Check if id_majelis already exists
    if (Majelis::where('id_majelis', $request->id_majelis)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    // Create a new Majelis instance
    $data = new Majelis();
    $data->id_majelis = $request->id_majelis;
    $data->id_jemaat = $request->id_jemaat;
    $data->nama_majelis = $request->nama_majelis;
    $data->id_gereja = $request->id_gereja;
    $data->tanggal_mulai = $request->tanggal_mulai;
    $data->tanggal_selesai = $request->tanggal_selesai;
    $data->id_jabatan = $request->id_jabatan;
    $data->id_status = $request->id_status;
    $data->no_sk = $request->no_sk;
    $data->berkas = $request->berkas;
    $data->save();

    return response()->json($data);
}
// POST MAJELIS END

// POST NON MAJELIS
public function ApiPostNonMajelis(Request $request)
{

    if (NonMajelis::where('id_nonmajelis', $request->id_nonmajelis)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }


    $data = new NonMajelis();
    $data->id_nonmajelis = $request->id_nonmajelis;
    $data->id_jemaat = $request->id_jemaat;
    $data->nama_majelis_non = $request->nama_majelis_non;
    $data->id_gereja = $request->id_gereja;
    $data->tanggal_mulai = $request->tanggal_mulai;
    $data->tanggal_selesai = $request->tanggal_selesai;
    $data->id_jabatan_non = $request->id_jabatan_non;
    $data->id_status = $request->id_status;
    $data->no_sk = $request->no_sk;
    $data->berkas = $request->berkas;
    $data->save();

    return response()->json($data);
}
// POST NON MAJELIS END

// POST PERNIKAHAN
public function ApiPostPernikahan(Request $request)
{
    if (Pernikahan::where('id_nikah', $request->id_nikah)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = new Pernikahan();
    $data->id_nikah = $request->id_nikah;
    $data->nomor = $request->nomor;
    $data->id_gereja = $request->id_gereja;
    $data->tanggal_nikah = $request->tanggal_nikah;
    $data->id_pendeta = $request->id_pendeta;
    $data->pengantin_pria = $request->pengantin_pria;
    $data->pengantin_wanita = $request->pengantin_wanita;
    $data->ayah_pria = $request->ayah_pria;
    $data->ibu_pria = $request->ibu_pria;
    $data->ayah_wanita = $request->ayah_wanita;
    $data->ibu_wanita = $request->ibu_wanita;
    $data->saksi1 = $request->saksi1;
    $data->saksi2 = $request->saksi2;
    $data->warga = $request->warga;
    $data->tempat = $request->tempat;
    $data->ketua_majelis = $request->ketua_majelis;
    $data->sekretaris_majelis = $request->sekretaris_majelis;
    $data->save();

    return response()->json($data);
}

// POST PERNIKAHAN END

// POST KEMATIAN
public function ApiPostKematian(Request $request) {

    if (Kematian::where('id_kematian', $request->id_kematian)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = new Kematian();
    $data->id_jemaat = $request->id_jemaat;
    $data->id_gereja = $request->id_gereja;
    $data->id_pendeta = $request->id_pendeta;
    $data->tanggal_meninggal = $request->tanggal_meninggal;
    $data->tanggal_pemakaman = $request->tanggal_pemakaman;
    $data->tempat_pemakaman = $request->tempat_pemakaman;
    $data->keterangan = $request->keterangan;
    $data->save();

    return response()->json($data);
}
// POST KEMATIAN END

// POST ATESTASI KELUAR
public function ApiPostAtestasiKeluar(Request $request) {

    if (AtestasiKeluar::where('id_keluar', $request->id_keluar)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = new AtestasiKeluar();
    $data->id_jemaat = $request->id_jemaat;
    $data->id_pendeta = $request->id_pendeta;
    $data->id_gereja = $request->id_gereja;
    $data->no_surat = $request->no_surat;
    $data->tanggal = $request->tanggal;
    $data->keterangan = $request->keterangan;
    $data->save();

    return response()->json($data);
}
// POST ATESTASI KELUAR END

// POST ATESTASI MASUK
public function ApiPostAtestasiMasuk(Request $request) {
    if (AtestasiMasuk::where('id_masuk', $request->id_masuk)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = new AtestasiMasuk();
    $data->id_wilayah = $request->id_wilayah;
    $data->id_gereja = $request->id_gereja;
    $data->no_surat = $request->no_surat;
    $data->tanggal = $request->tanggal;
    $data->surat = $request->surat;
    $data->save();

    return response()->json($data);
}
// POST ATESTASI MASUK END

// POST BAPTIS ANAK
public function ApiPostBaptisAnak(Request $request)
{
    if (BaptisAnak::where('id_ba', $request->id_ba)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = new BaptisAnak();
    $data->id_ba = $request->id_ba;
    $data->id_wilayah = $request->id_wilayah;
    $data->id_pendeta = $request->id_pendeta;
    $data->nomor = $request->nomor;
    $data->nama = $request->nama;
    $data->tempat_lahir = $request->tempat_lahir;
    $data->tanggal_lahir = $request->tanggal_lahir;
    $data->ayah = $request->ayah;
    $data->ibu = $request->ibu;
    $data->tanggal_baptis = $request->tanggal_baptis;
    $data->ketua_majelis = $request->ketua_majelis;
    $data->sekretaris_majelis = $request->sekretaris_majelis;
    $data->save();

    return response()->json($data);
}
// POST BAPTIS ANAK END

// POST BAPTIS DEWASA
public function ApiPostBaptisDewasa(Request $request)
{
    if (BaptisDewasa::where('id_bd', $request->id_bd)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = new BaptisDewasa();
    $data->id_bd = $request->id_bd;
    $data->id_wilayah = $request->id_wilayah;
    $data->id_pendeta = $request->id_pendeta;
    $data->nomor = $request->nomor;
    $data->nama = $request->nama;
    $data->tempat_lahir = $request->tempat_lahir;
    $data->tanggal_lahir = $request->tanggal_lahir;
    $data->ayah = $request->ayah;
    $data->ibu = $request->ibu;
    $data->tanggal_baptis = $request->tanggal_baptis;
    $data->ketua_majelis = $request->ketua_majelis;
    $data->sekretaris_majelis = $request->sekretaris_majelis;
    $data->save();

    return response()->json($data);
}
// POST BAPTIS DEWASA END

// POST BAPTIS SIDI
public function ApiPostBaptisSidi(Request $request)
{
    if (BaptisSidi::where('id_sidi', $request->id_sidi)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = new BaptisSidi();
    $data->id_sidi = $request->id_sidi;
    $data->id_wilayah = $request->id_wilayah;
    $data->id_pendeta = $request->id_pendeta;
    $data->nomor = $request->nomor;
    $data->nama = $request->nama;
    $data->tempat_lahir = $request->tempat_lahir;
    $data->tanggal_lahir = $request->tanggal_lahir;
    $data->ayah = $request->ayah;
    $data->ibu = $request->ibu;
    $data->tanggal_baptis = $request->tanggal_baptis;
    $data->ketua_majelis = $request->ketua_majelis;
    $data->sekretaris_majelis = $request->sekretaris_majelis;
    $data->save();

    return response()->json($data);
}
// POST BAPTIS SIDI END
    // API for posting data END

    // API for updating data
// UPDATE WILAYAH
public function ApiUpdateWilayah(Request $request)
{
    if ($request->id != $request->id_wilayah && Wilayah::where('id_wilayah', $request->id_wilayah)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }
    $data = Wilayah::find($request->id);
    $data->id_wilayah = $request->id_wilayah;
    $data->nama_wilayah = $request->nama_wilayah;
    $data->alamat_wilayah = $request->alamat_wilayah;
    $data->kota_wilayah = $request->kota_wilayah;
    $data->email_wilayah = $request->email_wilayah;
    $data->telepon_wilayah = $request->telepon_wilayah;
    $data->save();

    return response()->json($data);
}
// UPDATE WILAYAH END

// UPDATE JABATAN MAJELIS
public function ApiUpdateJabatanMajelis(Request $request)
{
    if ($request->id != $request->id_jabatan && JabatanMajelis::where('id_jabatan', $request->id_jabatan)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }
    $data = JabatanMajelis::find($request->id);
    $data->id_jabatan = $request->id_jabatan;
    $data->jabatan_majelis = $request->jabatan_majelis;
    $data->periode = $request->periode;
    $data->save();

    return response()->json($data);
}
// UPDATE JABATAN MAJELIS END

// UPDATE JABATAN NON MAJELIS
public function ApiUpdateJabatanNonMajelis(Request $request)
{
    if ($request->id != $request->id_jabatan_non && JabatanNonMajelis::where('id_jabatan_non', $request->id_jabatan_non)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data = JabatanNonMajelis::find($request->id);
    $data->id_jabatan_non = $request->id_jabatan_non;
    $data->jabatan_nonmajelis = $request->jabatan_nonmajelis;
    $data->periode = $request->periode;
    $data->save();

    return response()->json($data);
}
// UPDATE JABATAN NON MAJELIS END

// UPDATE USER
// public function ApiUpdateUser(Request $request)
// {
//     $validatedData = $request->validate([
//         'id' => 'required|exists:users,id', // Validate that the user exists
//         'username' => 'sometimes|string|max:255|unique:users,username,' . $request->id,
//         'nama_user' => 'sometimes|string|max:255',
//         'role_id' => 'sometimes|exists:roles,id', // Assuming you have a role relationship
//         'password' => 'sometimes|string|min:6', // Password validation
//     ]);

//     // Find the user and update
//     $user = User::find($validatedData['id']);

//     if (isset($validatedData['username'])) {
//         $user->username = $validatedData['username'];
//     }

//     if (isset($validatedData['nama_user'])) {
//         $user->nama_user = $validatedData['nama_user'];
//     }

//     if (isset($validatedData['role_id'])) {
//         $user->role_id = $validatedData['role_id'];
//     }

//     if (isset($validatedData['password'])) {
//         $user->password = Hash::make($validatedData['password']); // Hash the new password
//     }

//     $user->save();

//     return response()->json([
//         'message' => 'User updated successfully',
//         'user' => [
//             'username' => $user->username,
//             'nama_user' => $user->nama_user,
//             'role' => $user->role ? $user->role->nama_role : null,
//         ]
//     ]);
// }
// UPDATE USER END

// UPDATE PEKERJAAN
public function ApiUpdatePekerjaan(Request $request)
{
    $data = Pekerjaan::find($request->id_pekerjaan);

    if ($request->id_pekerjaan != $data->id_pekerjaan && Pekerjaan::where('id_pekerjaan', $request->id_pekerjaan)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data->id_pekerjaan = $request->id_pekerjaan;
    $data->pekerjaan = $request->pekerjaan;
    $data->save();

    return response()->json($data);
}
// UPDATE PEKERJAAN END

// UPDATE JEMAAT
public function ApiUpdateJemaat(Request $request)
{
    $data = Jemaat::find($request->id_jemaat);

    if ($request->id_jemaat != $data->id_jemaat && Jemaat::where('id_jemaat', $request->id_jemaat)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data->id_wilayah = $request->id_wilayah;
    $data->id_status = $request->id_status;
    $data->stamboek = $request->stamboek;
    $data->nama_jemaat = $request->nama_jemaat;
    $data->tempat_lahir = $request->tempat_lahir;
    $data->tanggal_lahir = $request->tanggal_lahir;
    $data->agama = $request->agama;
    $data->kelamin = $request->kelamin;
    $data->alamat_jemaat = $request->alamat_jemaat;
    $data->id_kelurahan = $request->id_kelurahan;
    $data->id_kecamatan = $request->id_kecamatan;
    $data->id_kabupaten = $request->id_kabupaten;
    $data->id_provinsi = $request->id_provinsi;
    $data->kodepos = $request->kodepos;
    $data->telepon = $request->telepon;
    $data->hp = $request->hp;
    $data->email = $request->email;
    $data->nik = $request->nik;
    $data->no_kk = $request->no_kk;
    $data->photo = $request->photo;
    $data->tanggal_baptis = $request->tanggal_baptis;
    $data->golongan_darah = $request->golongan_darah;
    $data->id_pendidikan = $request->id_pendidikan;
    $data->id_ilmu = $request->id_ilmu;
    $data->id_pekerjaan = $request->id_pekerjaan;
    $data->instansi = $request->instansi;
    $data->penghasilan = $request->penghasilan;
    $data->gereja_baptis = $request->gereja_baptis;
    $data->alat_transportasi = $request->alat_transportasi;
    $data->save();

    return response()->json($data);
}
// UPDATE JEMAAT END

// UPDATE KELUARGA
public function ApiUpdateKeluarga(Request $request)
{
    $data = Keluarga::find($request->id_keluarga);

    if ($request->id_keluarga != $data->id_keluarga && Keluarga::where('id_keluarga', $request->id_keluarga)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data->id_jemaat = $request->id_jemaat;
    $data->id_gereja = $request->id_gereja;
    $data->save();

    return response()->json($data);
}
// UPDATE KELUARGA END

// UPDATE MAJELIS
public function apiUpdateMajelis(Request $request)
{
    $data = Majelis::find($request->id_majelis);
    if ($request->id_majelis != $data->id_majelis && Majelis::where('id_majelis', $request->id_majelis)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data->id_jemaat = $request->id_jemaat;
    $data->nama_majelis = $request->nama_majelis;
    $data->id_gereja = $request->id_gereja;
    $data->tanggal_mulai = $request->tanggal_mulai;
    $data->tanggal_selesai = $request->tanggal_selesai;
    $data->id_jabatan = $request->id_jabatan;
    $data->id_status = $request->id_status;
    $data->no_sk = $request->no_sk;
    $data->berkas = $request->berkas;
    $data->save();

    return response()->json($data);
}
// UPDATE MAJELIS END

// UPDATE NON MAJELIS
public function apiUpdateNonMajelis(Request $request)
{
    $data = NonMajelis::find($request->id_nonmajelis);
    if ($request->id_nonmajelis != $data->id_nonmajelis && NonMajelis::where('id_nonmajelis', $request->id_nonmajelis)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data->id_jemaat = $request->id_jemaat;
    $data->nama_majelis_non = $request->nama_majelis_non;
    $data->id_gereja = $request->id_gereja;
    $data->tanggal_mulai = $request->tanggal_mulai;
    $data->tanggal_selesai = $request->tanggal_selesai;
    $data->id_jabatan_non = $request->id_jabatan_non;
    $data->id_status = $request->id_status;
    $data->no_sk = $request->no_sk;
    $data->berkas = $request->berkas;
    $data->save();

    return response()->json($data);
}
// UPDATE NON MAJELIS END

// UPDATE PERNIKAHAN
public function ApiUpdatePernikahan(Request $request)
{
    $data = Pernikahan::find($request->id_nikah);

    if ($request->id != $request->id_nikah && Pernikahan::where('id_nikah', $request->id_nikah)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data->id_jemaat_pria = $request->id_jemaat_pria;
    $data->id_jemaat_wanita = $request->id_jemaat_wanita;
    $data->tanggal_nikah = $request->tanggal_nikah;
    $data->tempat_nikah = $request->tempat_nikah;
    $data->save();

    return response()->json($data);
}
// UPDATE PERNIKAHAN END

// UPDATE KEMATIAN
public function ApiUpdateKematian(Request $request)
{
    $data = Kematian::find($request->id_kematian);

    if ($request->id != $request->id_kematian && Kematian::where('id_kematian', $request->id_kematian)->first() != null) {
        return response()->json([
            'message' => 'Data already exists'
        ]);
    }

    $data->id_jemaat = $request->id_jemaat;
    $data->tanggal_kematian = $request->tanggal_kematian;
    $data->tempat_kematian = $request->tempat_kematian;
    $data->save();

    return response()->json($data);
}
// UPDATE KEMATIAN END

    // API for updating data END

    // API for deleting data
    public function ApiDeleteWilayah(Request $request)
{
    $data = Wilayah::find($request->id);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Wilayah deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Wilayah not found'], 404);
}

public function ApiDeleteJabatanMajelis(Request $request)
{
    $data = JabatanMajelis::find($request->id);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Jabatan Majelis deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Jabatan Majelis not found'], 404);
}

public function ApiDeleteJabatanNonMajelis(Request $request)
{
    $data = JabatanNonMajelis::find($request->id);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Jabatan Non Majelis deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Jabatan Non Majelis not found'], 404);
}

// public function ApiDeleteUser(Request $request)
// {
//     $validatedData = $request->validate([
//         'id' => 'required|exists:users,id',
//     ]);

//     $user = User::find($validatedData['id']);
//     if ($user) {
//         $user->delete();
//         return response()->json([
//             'message' => 'User deleted successfully',
//             'data' => $user
//         ]);
//     }

//     return response()->json(['message' => 'User not found'], 404);
// }

public function ApiDeletePekerjaan(Request $request)
{
    $data = Pekerjaan::find($request->id_pekerjaan);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Pekerjaan deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Pekerjaan not found'], 404);
}

public function ApiDeleteKeluarga(Request $request)
{
    $data = Keluarga::find($request->id_keluarga);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Keluarga deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Keluarga not found'], 404);
}

public function ApiDeleteJemaat(Request $request)
{
    $data = Jemaat::find($request->id_jemaat);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Jemaat deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Jemaat not found'], 404);
}

public function apiDeleteMajelis(Request $request)
{
    $data = Majelis::find($request->id_majelis);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Majelis deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Majelis not found'], 404);
}

public function apiDeleteNonMajelis(Request $request)
{
    $data = NonMajelis::find($request->id_nonmajelis);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Non Majelis deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Non Majelis not found'], 404);
}

public function apiUser(Request $request)
{
    $data = User::find($request->username);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'User deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Non Majelis not found'], 404);
}

public function ApiDeletePernikahan(Request $request)
{
    $data = Pernikahan::find($request->id_nikah);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Pernikahan deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Pernikahan not found'], 404);
}

public function ApiDeleteKematian(Request $request)
{
    $data = Kematian::find($request->id_kematian);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Kematian deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Kematian not found'], 404);
}

public function ApiDeleteAtestasiKeluar(Request $request)
{
    $data = AtestasiKeluar::find($request->id_keluar);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Atestasi Keluar deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Atestasi Keluar not found'], 404);
}

public function ApiDeleteAtestasiMasuk(Request $request)
{
    $data = AtestasiMasuk::find($request->id_masuk);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Atestasi Masuk deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Atestasi Masuk not found'], 404);
}

public function ApiDeleteBaptisAnak(Request $request)
{
    $data = BaptisAnak::find($request->id_ba);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Baptis Anak deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Baptis Anak not found'], 404);
}

public function ApiDeleteBaptisDewasa(Request $request)
{
    $data = BaptisDewasa::find($request->id_bd);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Baptis Dewasa deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Baptis Dewasa not found'], 404);
}

public function ApiDeleteBaptisSidi(Request $request)
{
    $data = BaptisSidi::find($request->id_sidi);
    if ($data) {
        $data->delete();
        return response()->json([
            'message' => 'Baptis Sidi deleted successfully',
            'data' => $data
        ]);
    }

    return response()->json(['message' => 'Baptis Sidi not found'], 404);
}

}
