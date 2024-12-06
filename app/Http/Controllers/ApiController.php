<?php

namespace App\Http\Controllers;

use App\Models\AtestasiKeluarDtl;
use App\Models\JemaatBaru;
use App\Models\Gereja;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule as Rule;
use Illuminate\Support\Facades\Storage;

// PENGATURAN
use App\Models\Wilayah as Wilayah;
use App\Models\JabatanMajelis as JabatanMajelis;
use App\Models\JabatanNonMajelis as JabatanNonMajelis;
use App\Models\User as User;
use App\Models\RolePengguna as Role;
// use App\Models\Pekerjaan as Pekerjaan;
use App\Models\Provinsi as Provinsi;
use App\Models\Kabupaten as Kabupaten;
use App\Models\Kecamatan as Kecamatan;
use App\Models\Kelurahan as Kelurahan;
// daerah

// DATA
use App\Models\Jemaat as Jemaat;
use App\Models\Keluarga as Keluarga;
use App\Models\AnggotaKeluarga as AnggotaKeluarga;
use App\Models\JemaatTitipan as JemaatTitipan;
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
use App\Models\Pendeta as Pendeta;

class ApiController extends Controller
{
    // API for getting all data
    // GET Status
    public function ApiGetStatus(Request $request)
    {
        if ($request->has('id')) {
            $data = Status::where('id_status', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Status::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_status' => $item->id_status,
                            'keterangan_status' => $item->keterangan_status,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Status::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Status::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_status' => $item->id_status,
                            'keterangan_status' => $item->keterangan_status,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET Status END

    // GET DAERAH
    public function ApiGetDaerah(Request $request)
    {
        if ($request->has('id_provinsi')) {
            if ($request->has('id_kabupaten')) {
                if ($request->has('id_kecamatan')) {
                    $data = Kelurahan::where('id_kecamatan', $request->id_kecamatan)->get();

                    $formattedData = [
                        'total' => $data->count(),
                        'totalNotFiltered' => Kelurahan::count(),
                        'rows' => $data
                            ->map(function ($item) {
                                return [
                                    'id_kelurahan' => $item->id_kelurahan,
                                    'kelurahan' => $item->kelurahan,
                                    'id_kecamatan' => $item->id_kecamatan,
                                ];
                            })
                            ->toArray(),
                    ];

                    return response()->json($formattedData);
                }
                $data = Kecamatan::where('id_kabupaten', $request->id_kabupaten)->get();

                $formattedData = [
                    'total' => $data->count(),
                    'totalNotFiltered' => Kecamatan::count(),
                    'rows' => $data
                        ->map(function ($item) {
                            return [
                                'id_kecamatan' => $item->id_kecamatan,
                                'kecamatan' => $item->kecamatan,
                                'id_kabupaten' => $item->id_kabupaten,
                            ];
                        })
                        ->toArray(),
                ];

                return response()->json($formattedData);
            }

            $data = Kabupaten::where('id_provinsi', $request->id_provinsi)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Kabupaten::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_kabupaten' => $item->id_kabupaten,
                            'kabupaten' => $item->kabupaten,
                            'id_provinsi' => $item->id_provinsi,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Provinsi::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Wilayah::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_provinsi' => $item->id_provinsi,
                            'nama_provinsi' => $item->nama_provinsi,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }

    // GET WILAYAH
    public function ApiGetWilayah(Request $request)
    {
        if ($request->has('id')) {
            $data = Wilayah::where('id_wilayah', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Wilayah::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_wilayah' => $item->id_wilayah,
                            'nama_wilayah' => $item->nama_wilayah,
                            'alamat_wilayah' => $item->alamat_wilayah,
                            'kota_wilayah' => $item->kota_wilayah,
                            'email_wilayah' => $item->email_wilayah,
                            'telepon_wilayah' => $item->telepon_wilayah,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Wilayah::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Wilayah::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_wilayah' => $item->id_wilayah,
                            'nama_wilayah' => $item->nama_wilayah,
                            'alamat_wilayah' => $item->alamat_wilayah,
                            'kota_wilayah' => $item->kota_wilayah,
                            'email_wilayah' => $item->email_wilayah,
                            'telepon_wilayah' => $item->telepon_wilayah,
                        ];
                    })
                    ->toArray(),
            ];
            return response()->json($data);
        }
    }
    // GET WILAYAH END

    // GET JABATAN MAJELIS
    public function ApiGetJabatanMajelis(Request $request)
    {
        if ($request->has('id')) {
            $data = JabatanMajelis::where('id_jabatan', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => JabatanMajelis::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_jabatan' => $item->id_jabatan,
                            'jabatan_majelis' => $item->jabatan_majelis,
                            'periode' => $item->periode,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = JabatanMajelis::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => JabatanMajelis::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_jabatan' => $item->id_jabatan,
                            'jabatan_majelis' => $item->jabatan_majelis,
                            'periode' => $item->periode,
                        ];
                    })
                    ->toArray(),
            ];
            return response()->json($data);
        }
    }
    // GET JABATAN MAJELIS END

    // GET JABATAN NON MAJELIS
    public function ApiGetJabatanNonMajelis(Request $request)
    {
        if ($request->has('id')) {
            $data = JabatanNonMajelis::where('id_jabatan_non', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => JabatanMajelis::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_jabatan_non' => $item->id_jabatan_non,
                            'jabatan_nonmajelis' => $item->jabatan_nonmajelis,
                            'periode' => $item->periode,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = JabatanNonMajelis::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => JabatanMajelis::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_jabatan_non' => $item->id_jabatan_non,
                            'jabatan_nonmajelis' => $item->jabatan_nonmajelis,
                            'periode' => $item->periode,
                        ];
                    })
                    ->toArray(),
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
                'rows' => $data
                    ->map(function ($item) {
                        if ($item->id_wilayah == null) {
                            $namaWilayah = null;
                        } else {
                            $namaWilayah = Wilayah::where('id_wilayah', $item->id_wilayah)->first()->nama_wilayah;
                        }
                        return [
                            'username' => $item->username,
                            'nama_user' => $item->nama_user,
                            'role' => $item->role ? $item->role->nama_role : null,
                            'wilayah' => $namaWilayah,
                            'id_wilayah' => $item->id_wilayah,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = User::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => User::count(),
                'rows' => $data
                    ->map(function ($item) {
                        if ($item->id_wilayah == null) {
                            $namaWilayah = null;
                        } else {
                            $namaWilayah = Wilayah::where('id_wilayah', $item->id_wilayah)->first()->nama_wilayah;
                        }
                        return [
                            'username' => $item->username,
                            'nama_user' => $item->nama_user,
                            'role' => $item->role ? $item->role->nama_role : null,
                            'wilayah' => $namaWilayah,
                            'id_wilayah' => $item->id_wilayah,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET USER END

    // GET ROLE USER START
    public function ApiGetRole(Request $request)
    {
        if ($request->has('id')) {
            $data = Role::where('id_role', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Role::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_role' => $item->id_role,
                            'nama_role' => $item->nama_role,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Role::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Role::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_role' => $item->id_role,
                            'nama_role' => $item->nama_role,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET ROLE USER END

    // GET PEKERJAAN
    // public function ApiGetPekerjaan(Request $request)
    // {
    //     if ($request->has('id')) {
    //         $data = Pekerjaan::where('id_pekerjaan', $request->id)->get();

    //         $formattedData = [
    //             'total' => $data->count(),
    //             'totalNotFiltered' => Pekerjaan::count(),
    //             'rows' => $data
    //                 ->map(function ($item) {
    //                     return [
    //                         'id_pekerjaan' => $item->id_pekerjaan,
    //                         'pekerjaan' => $item->pekerjaan,
    //                     ];
    //                 })
    //                 ->toArray(),
    //         ];

    //         return response()->json($formattedData);
    //     } else {
    //         $data = Pekerjaan::all();
    //         $formattedData = [
    //             'total' => $data->count(),
    //             'totalNotFiltered' => Pekerjaan::count(),
    //             'rows' => $data
    //                 ->map(function ($item) {
    //                     return [
    //                         'id_pekerjaan' => $item->id_pekerjaan,
    //                         'pekerjaan' => $item->pekerjaan,
    //                     ];
    //                 })
    //                 ->toArray(),
    //         ];

    //         return response()->json($formattedData);
    //     }
    // }
    // GET PEKERJAAN END

    //  GET DAERAH START
    public function ApiGetDaerahProvinsi(Request $request)
    {
        if ($request->has('id')) {
            $data = Provinsi::where('id_provinsi', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Provinsi::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_provinsi' => $item->id_provinsi,
                            'nama_provinsi' => $item->nama_provinsi,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Provinsi::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Provinsi::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_provinsi' => $item->id_provinsi,
                            'nama_provinsi' => $item->nama_provinsi,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }

    public function ApiGetDaerahKabupaten(Request $request)
    {
        if ($request->has('id')) {
            $data = Kabupaten::where('id_kabupaten', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Kabupaten::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_kabupaten' => $item->id_kabupaten,
                            'kabupaten' => $item->kabupaten,
                            'id_provinsi' => $item->id_provinsi,
                            'nama_provinsi' => $item->provinsi ? $item->provinsi->nama_provinsi : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Kabupaten::where('id_provinsi', $request->id_provinsi)->get();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Kabupaten::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_kabupaten' => $item->id_kabupaten,
                            'kabupaten' => $item->kabupaten,
                            'id_provinsi' => $item->id_provinsi,
                            'nama_provinsi' => $item->provinsi ? $item->provinsi->nama_provinsi : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }

    public function ApiGetDaerahKecamatan(Request $request)
    {
        if ($request->has('id')) {
            $data = Kecamatan::where('id_kecamatan', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Kecamatan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_kecamatan' => $item->id_kecamatan,
                            'nama_kecamatan' => $item->nama_kecamatan,
                            'id_kabupaten' => $item->id_kabupaten,
                            'nama_kabupaten' => $item->kabupaten ? $item->kabupaten->nama_kabupaten : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Kecamatan::where('id_kabupaten', $request->id_kabupaten)->get();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Kecamatan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_kecamatan' => $item->id_kecamatan,
                            'kecamatan' => $item->kecamatan,
                            'id_kabupaten' => $item->id_kabupaten,
                            'nama_kabupaten' => $item->kabupaten ? $item->kabupaten->nama_kabupaten : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    public function ApiGetDaerahKelurahan(Request $request)
    {
        if ($request->has('id')) {
            $data = Kelurahan::where('id_kelurahan', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Kelurahan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_kelurahan' => $item->id_kelurahan,
                            'kelurahan' => $item->kelurahan,
                            'id_kecamatan' => $item->id_kecamatan,
                            'nama_kecamatan' => $item->kecamatan ? $item->kecamatan->nama_kecamatan : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Kelurahan::where('id_kecamatan', $request->id_kecamatan)->get();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Kelurahan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_kelurahan' => $item->id_kelurahan,
                            'kelurahan' => $item->kelurahan,
                            'id_kecamatan' => $item->id_kecamatan,
                            'nama_kecamatan' => $item->kecamatan ? $item->kecamatan->nama_kecamatan : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }

    //  GET DAERAH END

    // GET JEMAAT
    public function ApiGetJemaat(Request $request)
    {
        if ($request->has('onlyName')) {
            if ($request->has('status')) {
                $jemaat = Jemaat::where('id_status', $request->status)
                    ->select(['id_jemaat', 'nama_jemaat'])
                    ->get();
                $data = $jemaat;
            } else if ($request->has('baru')) {
                $jemaat = JemaatBaru::select(['id_jemaat', 'nama_jemaat'])->where('validasi', 'tidak valid')->get();
                $data = $jemaat;
            } else {
                $data = Jemaat::select(['id_jemaat', 'nama_jemaat'])->get();
            }
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Jemaat::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_jemaat' => $item->id_jemaat,
                            'nama_jemaat' => $item->nama_jemaat,
                        ];
                    })
                    ->toArray(),
            ];
            return response()->json($formattedData);
        }

        if ($request->has('nama_jemaat') || $request->has('id')) {
            if ($request->has('nama_jemaat')) {
                $data = Jemaat::where('nama_jemaat', $request->nama_jemaat)->get();
                if ($request->validasi == 'tidak valid') {
                    JemaatBaru::where('nama_jemaat', $request->nama_jemaat)->get();
                }
            } else {
                $data = Jemaat::where('id_jemaat', $request->id)->get();
                if ($request->validasi == 'tidak valid') {
                    JemaatBaru::where('id_jemaat', $request->id_jemaat)->get();
                }
            }

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Jemaat::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_jemaat' => $item->id_jemaat,
                            'id_wilayah' => $item->id_wilayah,
                            'nama_wilayah' => $item->wilayah ? $item->wilayah->nama_wilayah : null,
                            'id_status' => $item->id_status,
                            'keterangan_status' => $item->status ? $item->status->keterangan_status : null,
                            'stamboek' => $item->stamboek,
                            'nama_jemaat' => $item->nama_jemaat,
                            'tempat_lahir' => $item->tempat_lahir,
                            'tanggal_lahir' => $item->tanggal_lahir,
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
                            'pendidikan' => $item->pendidikan,
                            'ilmu' => $item->ilmu,
                            'pekerjaan' => $item->pekerjaan,
                            'instansi' => $item->instansi,
                            'penghasilan' => $item->penghasilan,
                            'gereja_baptis' => $item->gereja_baptis,
                            'alat_transportasi' => $item->alat_transportasi,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            if ($request->has('username')) {
                $data = User::where('username', $request->username)->first();
                $idWilayah = Wilayah::where('id_wilayah', $data->id_wilayah)->first();

                // Ambil data dari JemaatBaru
                $jemaatBaru = JemaatBaru::where('id_wilayah', $idWilayah->id_wilayah)->get();

                // Ambil data dari Jemaat dan tetapkan 'validasi' sebagai 'valid'
                $jemaat = Jemaat::where('id_wilayah', $idWilayah)->get()->map(function ($item) {
                    $item->validasi = 'valid';
                    return $item;
                });

                $data = $jemaatBaru->merge($jemaat);
            } else if ($request->has('baru')) {
                $jemaat = JemaatBaru::where('validasi', '!=', 'valid')->get();
                $data = $jemaat;
            } else {
                $data = Jemaat::all();
            }
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Jemaat::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_jemaat' => $item->id_jemaat,
                            'id_wilayah' => $item->id_wilayah,
                            'nama_wilayah' => $item->wilayah ? $item->wilayah->nama_wilayah : null,
                            'id_status' => $item->id_status,
                            'keterangan_status' => $item->status ? $item->status->keterangan_status : null,
                            'stamboek' => $item->stamboek,
                            'nama_jemaat' => $item->nama_jemaat,
                            'validasi' => $item->validasi,
                            'tempat_lahir' => $item->tempat_lahir,
                            'tanggal_lahir' => $item->tanggal_lahir,
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
                            'pendidikan' => $item->pendidikan,
                            'ilmu' => $item->ilmu,
                            'pekerjaan' => $item->pekerjaan,
                            'instansi' => $item->instansi,
                            'penghasilan' => $item->penghasilan,
                            'gereja_baptis' => $item->gereja_baptis,
                            'alat_transportasi' => $item->alat_transportasi,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET JEMAAT END

    public function ApiGetJemaatById(Request $request, $id_jemaat)
    {
        // Retrieve the Jemaat record by ID
        if ($request->validasi == 'valid') {
            $jemaat = Jemaat::find($id_jemaat);
        } else {
            $jemaat = JemaatBaru::with(['wilayah', 'status', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'pendidikan', 'ilmu', 'pekerjaan', 'pernikahan'])->find($id_jemaat);
        }

        $jemaat->photo_url = $jemaat->photo ? Storage::url($jemaat->photo) : null;

        // Check if Jemaat exists
        if (!$jemaat) {
            return response()->json(['message' => 'Jemaat not found'], 404);
        }
        // Prepare formatted data for response
        $formattedData = [
            'id_jemaat' => $jemaat->id_jemaat,
            'id_wilayah' => $jemaat->id_wilayah,
            'nama_wilayah' => $jemaat->wilayah ? $jemaat->wilayah->nama_wilayah : null,
            'id_status' => $jemaat->id_status,
            'keterangan_status' => $jemaat->status ? $jemaat->status->keterangan_status : null,
            'id_nikah' => $jemaat->id_nikah,
            'nomor' => $jemaat->pernikahan ? $jemaat->pernikahan->nomor : null,
            'stamboek' => $jemaat->stamboek,
            'nama_jemaat' => $jemaat->nama_jemaat,
            'tempat_lahir' => $jemaat->tempat_lahir,
            'tanggal_lahir' => $jemaat->tanggal_lahir,
            'kelamin' => $jemaat->kelamin,
            'alamat_jemaat' => $jemaat->alamat_jemaat,
            'id_kelurahan' => $jemaat->id_kelurahan ? $jemaat->id_kelurahan : null,
            'nama_kelurahan' => $jemaat->kelurahan ? $jemaat->kelurahan->nama_kelurahan : null,
            'id_kecamatan' => $jemaat->id_kecamatan ? $jemaat->id_kecamatan : null,
            'nama_kecamatan' => $jemaat->kecamatan ? $jemaat->kecamatan->nama_kecamatan : null,
            'id_kabupaten' => $jemaat->id_kabupaten ? $jemaat->id_kabupaten : null,
            'nama_kabupaten' => $jemaat->kabupaten ? $jemaat->kabupaten->nama_kabupaten : null,
            'id_provinsi' => $jemaat->id_provinsi ? $jemaat->id_provinsi : null,
            'nama_provinsi' => $jemaat->provinsi ? $jemaat->provinsi->nama_provinsi : null,
            'kodepos' => $jemaat->kodepos,
            'telepon' => $jemaat->telepon,
            'hp' => $jemaat->hp,
            'email' => $jemaat->email,
            'nik' => $jemaat->nik,
            'no_kk' => $jemaat->no_kk,
            'photo' => $jemaat->photo,
            'photo_url' => $jemaat->photo_url,
            'tanggal_baptis' => $jemaat->tanggal_baptis,
            'golongan_darah' => $jemaat->golongan_darah ? $jemaat->golongan_darah : null,
            'pendidikan' => $jemaat->pendidikan,
            'ilmu' => $jemaat->ilmu,
            'pekerjaan' => $jemaat->pekerjaan,
            'instansi' => $jemaat->instansi,
            'penghasilan' => $jemaat->penghasilan,
            'gereja_baptis' => $jemaat->gereja_baptis,
            'alat_transportasi' => $jemaat->alat_transportasi,
        ];

        // Return formatted data as JSON response
        return response()->json($formattedData, 200);
    }

    // GET KELUARGA
    public function ApiGetKeluarga(Request $request)
    {
        if ($request->has('id')) {
            $data = Keluarga::where('id_keluarga', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Keluarga::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $kepalaKeluarga = Jemaat::where('id_jemaat', $item->id_jemaat)
                            ->select('nama_jemaat')
                            ->first();
                        return [
                            'id_keluarga' => $item->id_keluarga,
                            'id_jemaat' => $item->id_jemaat,
                            'kepala_keluarga' => $kepalaKeluarga,
                            'keterangan_hubungan' => $item->keterangan_hubungan,
                            'id_wilayah' => $item->id_wilayah,
                            'nama_wilayah' => $item->wilayah ? $item->wilayah->nama_wilayah : null,
                        ];
                    })
                    ->toArray(),
            ];
            return response()->json($formattedData);
        } else {
            if ($request->has('id_wilayah')) {
                $data = Keluarga::where('id_wilayah', $request->id_wilayah)->get();
            } else {
                // Mengambil semua data keluarga
                $data = Keluarga::all();
            }
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Keluarga::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $kepalaKeluarga = Jemaat::where('id_jemaat', $item->id_jemaat)
                            ->select('nama_jemaat')
                            ->first();
                        return [
                            'id_keluarga' => $item->id_keluarga,
                            'id_jemaat' => $item->id_jemaat,
                            'kepala_keluarga' => $kepalaKeluarga,
                            'keterangan_hubungan' => $item->keterangan_hubungan,
                            'id_wilayah' => $item->id_wilayah,
                            'nama_wilayah' => $item->wilayah ? $item->wilayah->nama_wilayah : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET KELUARGA END

    // GET ANGGOTA KELUARGA
    public function ApiGetAnggotaKeluarga(Request $request)
    {
        if ($request->has('id_keluarga')) {
            $anggotaKeluarga = AnggotaKeluarga::where('id_keluarga', $request->id_keluarga)->get();
            $formattedData = $anggotaKeluarga->map(function ($item) {
                if ($item->id_jemaat == null) {
                    $namaAnggota = new \stdClass();
                    $namaAnggota->nama_jemaat = $item->nama_anggota;
                    $keteranganStatus = null;
                } else {
                    $namaAnggota = Jemaat::where('id_jemaat', $item->id_jemaat)
                        ->select('nama_jemaat', 'id_status')
                        ->first();
                    $keteranganStatus = Status::where('id_status', $namaAnggota->id_status)
                        ->select('keterangan_status')
                        ->first();
                }
                return [
                    'id_anggota_keluarga' => $item->id_anggota_keluarga,
                    'id_jemaat' => $item->jemaat ? $item->jemaat->id_jemaat : null,
                    'nama_anggota' => $namaAnggota,
                    'keterangan_status' => $keteranganStatus,
                    'keterangan_hubungan' => $item->keterangan_hubungan,
                ];
            });

            return response()->json($formattedData);
        }
    }
    // GET ANGGOTA KELUARGA END

    // GET PENDETA START
    public function ApiGetPendeta(Request $request)
    {
        if ($request->has('id')) {
            $data = Pendeta::where('id_pendeta', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Pendeta::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $item->ijazah_url = $item->ijazah ? Storage::url($item->ijazah) : null;
                        return [
                            'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $item->nama_pendeta,
                            'jenjang' => $item->jenjang,
                            'sekolah' => $item->sekolah,
                            'tahun_lulus' => $item->tahun_lulus,
                            'keterangan' => $item->keterangan,
                            'tanggal_mulai' => $item->tanggal_mulai,
                            'tanggal_selesai' => $item->tanggal_selesai,
                            'ijazah' => $item->ijazah,
                            'ijazah_url' => $item->ijazah_url,
                            'id_status' => $item->id_status,
                            'keterangan_status' => $item->status ? $item->status->keterangan_status : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Pendeta::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Pendeta::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $item->ijazah_url = $item->ijazah ? Storage::url($item->ijazah) : null;
                        return [
                            'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $item->nama_pendeta,
                            'jenjang' => $item->jenjang,
                            'sekolah' => $item->sekolah,
                            'tahun_lulus' => $item->tahun_lulus,
                            'keterangan' => $item->keterangan,
                            'tanggal_mulai' => $item->tanggal_mulai,
                            'tanggal_selesai' => $item->tanggal_selesai,
                            'ijazah' => $item->ijazah,
                            'id_status' => $item->id_status,
                            'keterangan_status' => $item->status ? $item->status->keterangan_status : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET PENDETA END

    // API GET GEREJA
    public function ApiGetGereja(Request $request)
    {
        $gerejaFromAtestasiKeluar = AtestasiKeluar::select('nama_gereja')->distinct()->get();
        $gerejaFromAtestasiMasuk = AtestasiMasuk::select('nama_gereja')->distinct()->get();
        $gerejaFromKematian = Kematian::select('nama_gereja')->distinct()->get();
        $gerejaFromPernikahan = Pernikahan::select('nama_gereja')->distinct()->get();

        $gereja = collect($gerejaFromAtestasiKeluar)->merge($gerejaFromAtestasiMasuk)->merge($gerejaFromKematian)->merge($gerejaFromPernikahan)->unique('nama_gereja')->values();

        return response()->json($gereja);
    }

    // GET MAJELIS
    public function apiGetMajelis(Request $request)
    {
        if ($request->has('id')) {
            $data = Majelis::where('id_majelis', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Majelis::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_majelis' => $item->id_majelis,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_majelis' => $item->nama_majelis,
                            'tanggal_mulai' => $item->tanggal_mulai,
                            'tanggal_selesai' => $item->tanggal_selesai,
                            'id_jabatan' => $item->id_jabatan,
                            'jabatan_majelis' => $item->jabatanMajelis ? $item->jabatanMajelis->jabatan_majelis : null,
                            'id_status' => $item->id_status,
                            'keterangan_status' => $item->status ? $item->status->keterangan_status : null,
                            'no_sk' => $item->no_sk,
                            'berkas' => $item->berkas,
                            'berkas_url' => $item->berkas ? Storage::url($item->berkas) : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Majelis::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Majelis::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_majelis' => $item->id_majelis,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_majelis' => $item->nama_majelis,
                            'tanggal_mulai' => $item->tanggal_mulai,
                            'tanggal_selesai' => $item->tanggal_selesai,
                            'id_jabatan' => $item->id_jabatan,
                            'jabatan_majelis' => $item->JabatanMajelis ? $item->JabatanMajelis->jabatan_majelis : null,
                            'id_status' => $item->id_status,
                            'keterangan_status' => $item->status ? $item->status->keterangan_status : null,
                            'no_sk' => $item->no_sk,
                            'berkas' => $item->berkas,
                        ];
                    })
                    ->toArray(),
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
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_nonmajelis' => $item->id_nonmajelis,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_majelis_non' => $item->nama_majelis_non,
                            'tanggal_mulai' => $item->tanggal_mulai,
                            'tanggal_selesai' => $item->tanggal_selesai,
                            'id_jabatan_non' => $item->id_jabatan_non,
                            'jabatan_non' => $item->jabatanNonMajelis ? $item->jabatanNonMajelis->jabatan_nonmajelis : null,
                            'id_status' => $item->id_status,
                            'keterangan_status' => $item->status ? $item->status->keterangan_status : null,
                            'no_sk' => $item->no_sk,
                            'berkas' => $item->berkas,
                            'berkas_url' => $item->berkas ? Storage::url($item->berkas) : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = NonMajelis::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => NonMajelis::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_nonmajelis' => $item->id_nonmajelis,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_majelis_non' => $item->nama_majelis_non,
                            'tanggal_mulai' => $item->tanggal_mulai,
                            'tanggal_selesai' => $item->tanggal_selesai,
                            'id_jabatan_non' => $item->id_jabatan_non,
                            'jabatan_non' => $item->jabatanNonMajelis ? $item->jabatanNonMajelis->jabatan_nonmajelis : null,
                            'id_status' => $item->id_status,
                            'keterangan_status' => $item->status ? $item->status->keterangan_status : null,
                            'no_sk' => $item->no_sk,
                            'berkas' => $item->berkas,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }

    // GET NON MAJELIS END

    // GET JEMAAT TITIPAN
    public function ApiGetJemaatTitipan(Request $request)
    {
        if ($request->has('id')) {
            $data = JemaatTitipan::where('id_titipan', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => JemaatTitipan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_titipan' => $item->id_titipan,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_gereja_asal' => $item->nama_gereja_asal,
                            'nama_gereja_tujuan' => $item->nama_gereja_titipan,
                            'nama_jemaat' => $item->nama_jemaat ? $item->nama_jemaat : Jemaat::where('id_jemaat', $item->id_jemaat)->first()->nama_jemaat,
                            'tanggal_titipan' => $item->tanggal_titipan,
                            'tanggal_selesai' => $item->tanggal_selesai,
                            'kelamin' => $item->kelamin,
                            'alamat_jemaat' => $item->alamat_jemaat,
                            'titipan' => $item->titipan,
                            'surat' => $item->surat,
                            'status_titipan' => $item->status_titipan,
                            'berkas_url' => $item->surat ? Storage::url($item->surat) : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = JemaatTitipan::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => JemaatTitipan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_titipan' => $item->id_titipan,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_gereja_asal' => $item->nama_gereja_asal,
                            'nama_gereja_tujuan' => $item->nama_gereja_tujuan,
                            'nama_jemaat' => $item->nama_jemaat ? $item->nama_jemaat : Jemaat::where('id_jemaat', $item->id_jemaat)->first()->nama_jemaat,
                            'tanggal_titipan' => $item->tanggal_titipan,
                            'tanggal_selesai' => $item->tanggal_selesai,
                            'kelamin' => $item->kelamin,
                            'alamat_jemaat' => $item->alamat_jemaat,
                            'titipan' => $item->titipan,
                            'surat' => $item->surat,
                            'status' => $item->status,
                            'status_titipan' => $item->status_titipan,
                            'berkas_url' => $item->surat ? Storage::url($item->surat) : null,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET JEMAAT TITTIPAN END

    // GET PERNIKAHAN
    public function ApiGetPernikahan(Request $request)
    {
        if ($request->has('nomor')) {
            $data = Pernikahan::where('nomor', $request->nomor)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Pernikahan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $pendeta = Pendeta::where('id_pendeta', $item->id_pendeta)->first();
                        if ($item->id_wilayah != null || $item->id_wilayah != '') {
                            $wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)->first();
                        } else {
                            $wilayah = null;
                        }
                        return [
                            'id_nikah' => $item->id_nikah,
                            'nomor' => $item->nomor,
                            'id_wilayah' => $item->id_wilayah,
                            'nama_wilayah' => $wilayah->nama_wilayah ? $item->wilayah->nama_wilayah : null,
                            'nama_gereja' => $item->nama_gereja,
                            'tanggal_nikah' => $item->tanggal_nikah,
                            'id_pendeta' => $item->id_pendeta,
                            'pendeta' => $pendeta->pendeta ? $item->pendeta->nama_pendeta : null,
                            'pengantin_pria' => $item->pengantin_pria,
                            'pengantin_wanita' => $item->pengantin_wanita,
                            'ayah_pria' => $item->ayah_pria,
                            'ibu_pria' => $item->ibu_pria,
                            'ayah_wanita' => $item->ayah_wanita,
                            'ibu_wanita' => $item->ibu_wanita,
                            'saksi1' => $item->saksi1,
                            'saksi2' => $item->saksi2,
                            'tempat' => $item->tempat,
                            'ketua_majelis' => $item->ketua_majelis,
                            'sekretaris_majelis' => $item->sekretaris_majelis,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Pernikahan::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Pernikahan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $pendeta = Pendeta::where('id_pendeta', $item->id_pendeta)->first();
                        if ($item->id_wilayah != null || $item->id_wilayah != '') {
                            $wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)->first();
                        } else {
                            $wilayah = null;
                        }
                        return [
                            'id_nikah' => $item->id_nikah,
                            'nomor' => $item->nomor,
                            'nama_gereja' => $item->nama_gereja,
                            'id_wilayah' => $item->id_wilayah,
                            'nama_wilayah' => $wilayah->nama_wilayah ?? null,
                            'tanggal_nikah' => $item->tanggal_nikah,
                            'id_pendeta' => $item->id_pendeta,
                            'pendeta' => $pendeta->nama_pendeta ? $item->pendeta->nama_pendeta : null,
                            'pengantin_pria' => $item->pengantin_pria,
                            'pengantin_wanita' => $item->pengantin_wanita,
                            'ayah_pria' => $item->ayah_pria,
                            'ibu_pria' => $item->ibu_pria,
                            'ayah_wanita' => $item->ayah_wanita,
                            'ibu_wanita' => $item->ibu_wanita,
                            'saksi1' => $item->saksi1,
                            'saksi2' => $item->saksi2,
                            'tempat' => $item->tempat,
                            'ketua_majelis' => $item->ketua_majelis,
                            'sekretaris_majelis' => $item->sekretaris_majelis,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }

    // GET PERNIKAHAN END

    // GET KEMATIAN
    public function ApiGetKematian(Request $request)
    {
        if ($request->has('id_jemaat')) {
            $data = Kematian::where('id_jemaat', $request->id_jemaat)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Kematian::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama = Jemaat::where('id_jemaat', $item->id_jemaat)
                            ->select('nama_jemaat')
                            ->first();
                        return [
                            'id_kematian' => $item->id_kematian,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_gereja' => $item->nama_gereja,
                            'nama_jemaat' => $nama ? $nama->nama_jemaat : null, // pastikan untuk mengecek jika $nama null
                            'id_pendeta' => $item->id_pendeta,
                            'tanggal_meninggal' => $item->tanggal_meninggal,
                            'tanggal_pemakaman' => $item->tanggal_pemakaman,
                            'tempat_pemakaman' => $item->tempat_pemakaman,
                            'keterangan' => $item->keterangan,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Kematian::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Kematian::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama = Jemaat::where('id_jemaat', $item->id_jemaat)
                            ->select('nama_jemaat')
                            ->first();
                        return [
                            'id_kematian' => $item->id_kematian,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_gereja' => $item->nama_gereja,
                            'nama_jemaat' => $nama ? $nama->nama_jemaat : null,
                            'id_pendeta' => $item->id_pendeta,
                            'tanggal_meninggal' => $item->tanggal_meninggal,
                            'tanggal_pemakaman' => $item->tanggal_pemakaman,
                            'tempat_pemakaman' => $item->tempat_pemakaman,
                            'keterangan' => $item->keterangan,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }

    // GET KEMATIAN END

    // GET ATESTASI KELUAR
    public function ApiGetAtestasiKeluar(Request $request)
    {
        if ($request->has('id')) {
            $data = AtestasiKeluar::where('id_keluar', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => AtestasiKeluar::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_keluar' => $item->id_keluar,
                            'nama_gereja' => $item->nama_gereja,
                            'no_surat' => $item->no_surat,
                            'tanggal' => $item->tanggal,
                            'keterangan' => $item->keterangan,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = AtestasiKeluar::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => AtestasiKeluar::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_keluar' => $item->id_keluar,
                            'nama_gereja' => $item->nama_gereja,
                            'no_surat' => $item->no_surat,
                            'tanggal' => $item->tanggal,
                            'keterangan' => $item->keterangan,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET ATESTSI KELUAR END

    // GET ATESTASI KELUAR DETAIL START
    public function ApiGetAtestasiKeluarDetail(Request $request)
    {
        if ($request->has('id_keluar')) {
            if ($request->has('id_jemaat')) {
                $data = AtestasiKeluarDtl::where('id_keluar', $request->id_keluar)
                    ->where('id_jemaat', $request->id_jemaat)
                    ->get();
            } else {
                $data = AtestasiKeluarDtl::where('id_keluar', $request->id_keluar)->get();
            }

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => AtestasiKeluarDtl::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $namaJemaat = Jemaat::where('id_jemaat', $item->id_jemaat)
                            ->select('nama_jemaat')
                            ->first();
                        return [
                            'id_keluar_dtl' => $item->id_keluar_dtl,
                            'id_keluar' => $item->id_keluar,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_jemaat' => $namaJemaat,
                            'keterangan' => $item->keterangan,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET ATESTASI KELUAR DETAIL END

    // GET ATESTASI MASUK
    public function ApiGetAtestasiMasuk(Request $request)
    {
        if ($request->has('id')) {
            $data = AtestasiMasuk::where('id_masuk', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => AtestasiMasuk::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama_wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)
                            ->select('nama_wilayah')
                            ->first();
                        $nama_jemaat = Jemaat::where('id_jemaat', $item->id_jemaat)
                            ->select('nama_jemaat')
                            ->first();
                        return [
                            'id_masuk' => $item->id_masuk,
                            'id_wilayah' => $item->id_wilayah,
                            'nama_jemaat' => $nama_jemaat->nama_jemaat,
                            'nama_wilayah' => $nama_wilayah ? $nama_wilayah->nama_wilayah : null,
                            'nama_gereja' => $item->nama_gereja,
                            'no_surat' => $item->no_surat,
                            'tanggal' => $item->tanggal,
                            'surat' => $item->surat,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = AtestasiMasuk::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => AtestasiMasuk::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama_wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)
                            ->select('nama_wilayah')
                            ->first();
                        $nama_jemaat = Jemaat::where('id_jemaat', $item->id_jemaat)
                            ->select('nama_jemaat')
                            ->first();
                        return [
                            'id_masuk' => $item->id_masuk,
                            'id_wilayah' => $item->id_wilayah,
                            'nama_jemaat' => $nama_jemaat->nama_jemaat,
                            'nama_wilayah' => $nama_wilayah ? $nama_wilayah->nama_wilayah : null,
                            'nama_gereja' => $item->nama_gereja,
                            'no_surat' => $item->no_surat,
                            'tanggal_masuk' => $item->tanggal_masuk,
                            'surat' => $item->surat,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET ATESTASI MASUK END

    // GET BAPTIS ANAK
    public function ApiGetBaptisAnak(Request $request)
    {
        if ($request->has('id')) {
            $data = BaptisAnak::where('id_ba', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => BaptisAnak::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama_wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)
                            ->select('nama_wilayah')
                            ->first();
                        $nama_pendeta = Pendeta::where('id_pendeta', $item->id_pendeta)
                            ->select('nama_pendeta')
                            ->first();
                        return [
                            'status' => $item->status,
                            'id_jemaat' => $item->id_jemaat,
                            'id_ba' => $item->id_ba,
                            'id_wilayah' => $item->id_wilayah,
                            'alamat' => $item->alamat,
                            'kelamin' => $item->kelamin,
                            'nama_wilayah' => $nama_wilayah ? $nama_wilayah->nama_wilayah : null,
                            'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $nama_pendeta ? $nama_pendeta->nama_pendeta : null,
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
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else if ($request->has('id_jemaat')) {
            $data = BaptisAnak::where('id_jemaat', $request->id_jemaat)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => BaptisAnak::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama_wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)
                            ->select('nama_wilayah')
                            ->first();
                        $nama_pendeta = Pendeta::where('id_pendeta', $item->id_pendeta)
                            ->select('nama_pendeta')
                            ->first();
                        return [
                            'status' => $item->status,
                            'id_jemaat' => $item->id_jemaat,
                            'id_ba' => $item->id_ba,
                            'id_wilayah' => $item->id_wilayah,
                            'alamat' => $item->alamat,
                            'kelamin' => $item->kelamin,
                            'nama_wilayah' => $nama_wilayah ? $nama_wilayah->nama_wilayah : null,
                            'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $nama_pendeta ? $nama_pendeta->nama_pendeta : null,
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
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = BaptisAnak::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => BaptisAnak::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama_wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)
                            ->select('nama_wilayah')
                            ->first();
                        $nama_pendeta = Pendeta::where('id_pendeta', $item->id_pendeta)
                            ->select('nama_pendeta')
                            ->first();
                        return [
                            'id_ba' => $item->id_ba,
                            'id_jemaat' => $item->id_jemaat,
                            'id_wilayah' => $item->id_wilayah,
                            'alamat' => $item->alamat,
                            'kelamin' => $item->kelamin,
                            'nama_wilayah' => $nama_wilayah ? $nama_wilayah->nama_wilayah : null,
                            'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $nama_pendeta ? $nama_pendeta->nama_pendeta : null,
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
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }

    // GET BAPTIS ANAK END

    // GET BAPTIS DEWASA
    public function ApiGetBaptisDewasa(Request $request)
    {
        if ($request->has('id')) {
            $data = BaptisDewasa::where('id_bd', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => BaptisDewasa::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama_wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)
                            ->select('nama_wilayah')
                            ->first();
                        $nama_pendeta = Pendeta::where('id_pendeta', $item->id_pendeta)
                            ->select('nama_pendeta')
                            ->first();
                        return [
                            'status' => $item->status,
                            'id_jemaat' => $item->id_jemaat,
                            'id_bd' => $item->id_bd,
                            'id_wilayah' => $item->id_wilayah,
                            'alamat' => $item->alamat,
                            'kelamin' => $item->kelamin,
                            'nama_wilayah' => $nama_wilayah ? $nama_wilayah->nama_wilayah : null,
                            'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $nama_pendeta ? $nama_pendeta->nama_pendeta : null,
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
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = BaptisDewasa::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => BaptisDewasa::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama_wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)
                            ->select('nama_wilayah')
                            ->first();
                        $nama_pendeta = Pendeta::where('id_pendeta', $item->id_pendeta)
                            ->select('nama_pendeta')
                            ->first();
                        return [
                            'id_bd' => $item->id_bd,
                            'id_jemaat' => $item->id_jemaat,
                            'id_wilayah' => $item->id_wilayah,
                            'alamat' => $item->alamat,
                            'kelamin' => $item->kelamin,
                            'nama_wilayah' => $nama_wilayah ? $nama_wilayah->nama_wilayah : null,
                            'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $nama_pendeta ? $nama_pendeta->nama_pendeta : null,
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
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }

    // GET BAPTIS DEWASA END

    // GET BAPTIS SIDI
    public function ApiGetBaptisSidi(Request $request)
    {
        if ($request->has('id')) {
            $data = BaptisSidi::where('id_sidi', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => BaptisSidi::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama_wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)
                            ->select('nama_wilayah')
                            ->first();
                        $nama_pendeta = Pendeta::where('id_pendeta', $item->id_pendeta)
                            ->select('nama_pendeta')
                            ->first();
                        return [
                            'status' => $item->status,
                            'id_jemaat' => $item->id_jemaat,
                            'id_sidi' => $item->id_sidi,
                            'id_wilayah' => $item->id_wilayah,
                            'alamat' => $item->alamat,
                            'kelamin' => $item->kelamin,
                            'nama_wilayah' => $nama_wilayah ? $nama_wilayah->nama_wilayah : null,
                            'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $nama_pendeta ? $nama_pendeta->nama_pendeta : null,
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
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = BaptisSidi::all();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => BaptisSidi::count(),
                'rows' => $data
                    ->map(function ($item) {
                        $nama_wilayah = Wilayah::where('id_wilayah', $item->id_wilayah)
                            ->select('nama_wilayah')
                            ->first();
                        $nama_pendeta = Pendeta::where('id_pendeta', $item->id_pendeta)
                            ->select('nama_pendeta')
                            ->first();
                        return [
                            'id_sidi' => $item->id_sidi,
                            'id_jemaat' => $item->id_jemaat,
                            'id_wilayah' => $item->id_wilayah,
                            'alamat' => $item->alamat,
                            'kelamin' => $item->kelamin,
                            'nama_wilayah' => $nama_wilayah ? $nama_wilayah->nama_wilayah : null,
                            'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $nama_pendeta ? $nama_pendeta->nama_pendeta : null,
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
                    })
                    ->toArray(),
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
                'message' => 'Data already exists',
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
                'message' => 'Data already exists',
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
        if (JabatanNonMajelis::where('id_jabatan_non', $request->id_jabatan_non)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
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
    public function ApiPostUser(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'nama_user' => 'required|string|max:255',
            'role_user' => 'string|max:255|nullable',
            'new_role' => 'strng|max:255|nullable',
            'password' => 'required|string',
            'id_wilayah' => 'integer|nullable',
        ]);

        if ($validatedData['role_user'] != null) {
            $role = Role::where('id_role', $validatedData['role_user'])->first();
            if ($role == null) {
                return response()->json(
                    [
                        'message' => 'Role not found',
                    ],
                    404,
                );
            }
            $validatedData['role_id'] = $validatedData['role_user'];
        } else {
            $new_role = Role::create([
                'nama_role' => $validatedData['new_role'],
            ]);
            $validatedData['role_id'] = $new_role->id;
        }

        $user = User::create([
            'username' => $validatedData['username'],
            'nama_user' => $validatedData['nama_user'],
            'id_role' => $validatedData['role_id'],
            'password' => Hash::make($validatedData['password']),
            'id_wilayah' => $validatedData['id_wilayah'] ?? null,
        ]);

        return response()->json(
            [
                'message' => 'User created successfully',
                'user' => [
                    'username' => $user->username,
                    'nama_user' => $user->nama_user,
                    'role' => $user->role ? $user->role->nama_role : null,
                ],
            ],
            201,
        );
    }
    // POST USER END

    // POST PEKERJAAN
    // public function ApiPostPekerjaan(Request $request)
    // {
    //     if (Pekerjaan::where('id_pekerjaan', $request->id_pekerjaan)->first() != null) {
    //         return response()->json([
    //             'message' => 'Data already exists',
    //         ]);
    //     }

    //     $data = new Pekerjaan();
    //     $data->id_pekerjaan = $request->id_pekerjaan;
    //     $data->pekerjaan = $request->pekerjaan;
    //     $data->save();

    //     return response()->json($data);
    // }
    // POST PEKERJAAN END

    // POST PROVINSI START
    public function ApiPostProvinsi(Request $request)
    {
        if (Provinsi::where('id_provinsi', $request->id_provinsi)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data = new Provinsi();
        $data->id_provinsi = $request->id_provinsi;
        $data->nama_provinsi = $request->nama_provinsi;
        $data->save();

        return response()->json($data);
    }
    // POST PROVINSI END

    // POST KABUPATEN START
    public function ApiPostKabupaten(Request $request)
    {
        if (Kabupaten::where('id_kabupaten', $request->id_kabupaten)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data = new Kabupaten();
        $data->id_kabupaten = $request->id_kabupaten;
        $data->id_provinsi = $request->id_provinsi;
        $data->kabupaten = $request->kabupaten;
        $data->save();

        return response()->json($data);
    }
    // POST KABUPATEN END

    // POST KECAMATAN START
    public function ApiPostKecamatan(Request $request)
    {
        if (Kecamatan::where('id_kecamatan', $request->id_kecamatan)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data = new Kecamatan();
        $data->id_kecamatan = $request->id_kecamatan;
        $data->id_kabupaten = $request->id_kabupaten;
        $data->kecamatan = $request->nama_kecamatan;
        $data->save();

        return response()->json($data);
    }
    // POST KECAMATAN END

    // POST KELURAHAN START
    public function ApiPostKelurahan(Request $request)
    {
        if (Kelurahan::where('id_kelurahan', $request->id_kelurahan)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data = new Kelurahan();
        $data->id_kelurahan = $request->id_kelurahan;
        $data->id_kecamatan = $request->id_kecamatan;
        $data->kelurahan = $request->nama_kelurahan;
        $data->save();

        return response()->json($data);
    }
    // POST KELURAHAN END

    // POST JEMAAT
    public function ApiPostJemaat(Request $request)
    {
        $data = new Jemaat();
        $data->id_wilayah = $request->id_wilayah;
        $data->id_status = $request->id_status;
        $data->stamboek = $request->stamboek;
        $data->nama_jemaat = $request->nama_jemaat;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
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

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photo', 'public');
            $data->photo = $path;
        }

        $data->tanggal_baptis = $request->tanggal_baptis;
        $data->golongan_darah = $request->golongan_darah;
        $data->pendidikan = $request->pendidikan;
        $data->ilmu = $request->ilmu;
        $data->pekerjaan = $request->pekerjaan;
        $data->instansi = $request->instansi;
        $data->penghasilan = $request->penghasilan;
        $data->gereja_baptis = $request->gereja_baptis;
        $data->alat_transportasi = $request->alat_transportasi;
        $data->save();

        $jemaat = Jemaat::where('id_jemaat', $data->id_jemaat)->first();

        return response()->json($jemaat);
    }
    // POST JEMAAT END

    // POST JEMAAT DAERAH
    public function ApiPostJemaatDaerah(Request $request)
    {

        $data = new JemaatBaru();
        $data->validasi = "tidak valid";
        $data->id_wilayah = $request->id_wilayah;
        $data->id_status = $request->id_status;
        $data->stamboek = $request->stamboek;
        $data->nama_jemaat = $request->nama_jemaat;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
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

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photo/jemaat_baru', 'public');
            $data->photo = $path;
        }

        $data->tanggal_baptis = $request->tanggal_baptis;
        $data->golongan_darah = $request->golongan_darah;
        $data->pendidikan = $request->pendidikan;
        $data->ilmu = $request->ilmu;
        $data->pekerjaan = $request->pekerjaan;
        $data->instansi = $request->instansi;
        $data->penghasilan = $request->penghasilan;
        $data->gereja_baptis = $request->gereja_baptis;
        $data->alat_transportasi = $request->alat_transportasi;
        $data->save();

        return response()->json($data);
    }
    // POST JEMAAT DAERAH END

    // POST VALIDASI JEMAAT
    public function ApiPostValidasiJemaat(Request $request)
    {
        $data = JemaatBaru::where('id_jemaat', $request->id_jemaat)->first();
        $jemaat = new Jemaat();
        $jemaat->id_wilayah = $data->id_wilayah;
        $jemaat->id_status = $data->id_status;
        $jemaat->stamboek = $data->stamboek;
        $jemaat->nama_jemaat = $data->nama_jemaat;
        $jemaat->tempat_lahir = $data->tempat_lahir;
        $jemaat->tanggal_lahir = $data->tanggal_lahir;
        $jemaat->kelamin = $data->kelamin;
        $jemaat->alamat_jemaat = $data->alamat_jemaat;
        $jemaat->id_kelurahan = $data->id_kelurahan;
        $jemaat->id_kecamatan = $data->id_kecamatan;
        $jemaat->id_kabupaten = $data->id_kabupaten;
        $jemaat->id_provinsi = $data->id_provinsi;
        $jemaat->kodepos = $data->kodepos;
        $jemaat->telepon = $data->telepon;
        $jemaat->hp = $data->hp;
        $jemaat->email = $data->email;
        $jemaat->nik = $data->nik;
        $jemaat->no_kk = $data->no_kk;
        $jemaat->photo = $data->photo;
        $jemaat->tanggal_baptis = $data->tanggal_baptis;
        $jemaat->golongan_darah = $data->golongan_darah;
        $jemaat->pendidikan = $data->pendidikan;
        $jemaat->ilmu = $data->ilmu;
        $jemaat->pekerjaan = $data->pekerjaan;
        $jemaat->instansi = $data->instansi;
        $jemaat->penghasilan = $data->penghasilan;
        $jemaat->gereja_baptis = $data->gereja_baptis;
        $jemaat->alat_transportasi = $data->alat_transportasi;
        $jemaat->save();

        $data->delete();

        return response()->json($data);
    }

    // POST KELUARGA
    public function ApiPostKeluarga(Request $request)
    {
        if (Keluarga::where('id_keluarga', $request->id_keluarga)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data = new Keluarga();
        $data->id_jemaat = $request->id_jemaat;
        $data->id_wilayah = $request->id_wilayah;
        $data->keterangan_hubungan = $request->keterangan_hubungan;
        $data->save();

        return response()->json($data);
    }
    // POST KELUARGA END

    // POST ANGGOTA KELUARGA
    public function ApiPostAnggotaKeluarga(Request $request)
    {
        $data = new AnggotaKeluarga();
        $data->id_jemaat = $request->id_jemaat;
        $data->nama_anggota = $request->nama_anggota;
        $data->id_keluarga = $request->id_keluarga;
        $data->keterangan_hubungan = $request->keterangan_hubungan;
        $data->save();

        return response()->json($data);
    }
    // POST ANGGOTA KELUARGA END

    // POST PENDETA
    public function ApiPostPendeta(Request $request)
    {
        if (Pendeta::where('id_pendeta', $request->id_pendeta)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data = new Pendeta();
        $data->nama_pendeta = $request->nama_pendeta;
        $data->jenjang = $request->jenjang;
        $data->sekolah = $request->sekolah;
        $data->tahun_lulus = $request->tahun_lulus;
        $data->tanggal_mulai = $request->tanggal_mulai;
        $data->tanggal_selesai = $request->tanggal_selesai;
        $data->id_status = $request->id_status;
        $data->keterangan = $request->keterangan;
        if ($request->hasFile('ijazah')) {
            $file = $request->file('ijazah');
            $path = $file->store('ijazah', 'public');
            $data->ijazah = $path;
        }
        $data->save();

        return response()->json($data);
    }
    // POST PENDETA END

    // POST MAJELIS
    public function ApiPostMajelis(Request $request)
    {
        if (Majelis::where('id_majelis', $request->id_majelis)->exists()) {
            return response()->json(
                [
                    'message' => 'Data already exists',
                ],
                409,
            );
        }

        $data = new Majelis();
        $data->id_jemaat = $request->id_jemaat;
        $data->nama_majelis = Jemaat::where('id_jemaat', $request->id_jemaat)->first()->nama_jemaat;
        $data->tanggal_mulai = $request->tanggal_mulai;
        $data->tanggal_selesai = $request->tanggal_selesai;
        $data->id_jabatan = $request->id_jabatan;
        $data->id_status = $request->id_status;
        $data->no_sk = $request->no_sk;

        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            $path = $file->store('berkas', 'public');
            $data->berkas = $path;
        }

        $data->save();

        return response()->json($data, 201);
    }

    // POST MAJELIS END

    // POST NON MAJELIS
    public function ApiPostNonMajelis(Request $request)
    {
        if (NonMajelis::where('id_nonmajelis', $request->id_nonmajelis)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data = new NonMajelis();
        $data->id_jemaat = $request->id_jemaat;
        $data->nama_majelis_non = Jemaat::where('id_jemaat', $request->id_jemaat)->first()->nama_jemaat;
        $data->tanggal_mulai = $request->tanggal_mulai;
        $data->tanggal_selesai = $request->tanggal_selesai;
        $data->id_jabatan_non = $request->id_jabatan_non;
        $data->id_status = $request->id_status;
        $data->no_sk = $request->no_sk;

        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            $path = $file->store('berkas', 'public');
            $data->berkas = $path;
        }

        $data->save();


        return response()->json($data);
    }
    // POST NON MAJELIS END

    // POST JEMAAT TITIPAN
    public function ApiPostJemaatTitipan(Request $request)
    {
        // Cek apakah id_titipan sudah ada dalam database
        if (JemaatTitipan::where('id_titipan', $request->id_titipan)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $namaGereja = '';
        $data = new JemaatTitipan();
        if ($request->titipan == 'Keluar') {
            if ($request->nama_gereja_tujuan == null) {
                $namaGereja = $request->new_gereja_tujuan;
            } else {
                $namaGereja = $request->nama_gereja_tujuan;
            }
            $data->nama_gereja_tujuan = $namaGereja;
        } else {
            if ($request->nama_gereja_asal == null) {
                $namaGereja = $request->new_gereja_asal;
            } else {
                $namaGereja = $request->nama_gereja_asal;
            }
            $data->nama_gereja_asal = $namaGereja;
        }

        if ($request->has('id_jemaat')) {
            $data->id_jemaat = $request->id_jemaat;
        }
        if ($request->titipan == 'Keluar') {
            $data->id_jemaat = $request->id_jemaat;
        } else {
            $data->nama_jemaat = $request->nama_jemaat;
        }
        $data->tanggal_titipan = $request->tanggal_titipan;
        $data->tanggal_selesai = $request->tanggal_selesai;
        $data->kelamin = $request->kelamin;
        $data->alamat_jemaat = $request->alamat_jemaat;
        $data->titipan = $request->titipan;
        $data->status_titipan = $request->status_titipan;


        if ($request->hasFile('surat')) {
            $file = $request->file('surat');
            $path = $file->store('surat', 'public');
            $data->surat = $path;
        }

        $data->save();

        return response()->json($data);
    }
    // POST JEMAAT TITIPAN END

    // POST PERNIKAHAN
    public function ApiPostPernikahan(Request $request)
    {
        if (Pernikahan::where('id_nikah', $request->id_nikah)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $namaGereja = '';

        if ($request->nama_gereja == null) {
            $namaGereja = $request->new_gereja;
        } else {
            $namaGereja = $request->nama_gereja;
        }

        $data = new Pernikahan();
        $data->nomor = $request->nomor;
        $data->id_wilayah = $request->id_wilayah;
        $data->nama_gereja = $namaGereja;
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
        $data->tempat = $request->tempat;
        $data->ketua_majelis = $request->ketua_majelis;
        $data->sekretaris_majelis = $request->sekretaris_majelis;
        $data->save();

        return response()->json($data);
    }

    // POST PERNIKAHAN END

    // POST KEMATIAN
    public function ApiPostKematian(Request $request)
    {
        if (Kematian::where('id_kematian', $request->id_kematian)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $namaGereja = '';

        if ($request->nama_gereja == null) {
            $namaGereja = $request->new_gereja;
        } else {
            $namaGereja = $request->nama_gereja;
        }

        $data = new Kematian();
        $data->id_jemaat = $request->id_jemaat;
        $data->nama_gereja = $namaGereja;
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
    public function ApiPostAtestasiKeluar(Request $request)
    {
        if (AtestasiKeluar::where('id_keluar', $request->id_keluar)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $namaGereja = '';

        if ($request->nama_gereja == null) {
            $namaGereja = $request->new_gereja;
        } else {
            $namaGereja = $request->nama_gereja;
        }

        $data = new AtestasiKeluar();
        $data->nama_gereja = $namaGereja;
        $data->no_surat = $request->no_surat;
        $data->tanggal = $request->tanggal;
        $data->keterangan = $request->keterangan;
        $data->save();

        return response()->json($data);
    }
    // POST ATESTASI KELUAR END

    // POST ATESTASI DETAIL KELUAR START
    public function ApiPostAtestasiKeluarDetail(Request $request)
    {
        if (AtestasiKeluarDtl::where('id_keluar_dtl', $request->id_detail_keluar)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data = new AtestasiKeluarDtl();
        $data->id_keluar = $request->id_keluar;
        $data->id_jemaat = $request->id_jemaat;
        $data->keterangan = $request->keterangan;
        $jemaat = Jemaat::find($request->id_jemaat);
        $jemaat->id_status = '3';
        $jemaat->save();
        $data->save();

        return response()->json($data);
    }
    // POST ATESTASI DETAIL KELUAR END

    // POST ATESTASI MASUK
    public function ApiPostAtestasiMasuk(Request $request)
    {
        // Simpan data ke tabel Jemaat
        $jemaat = new Jemaat();
        $jemaat->id_wilayah = $request->id_wilayah;
        $jemaat->id_status = $request->id_status;
        $jemaat->nama_jemaat = $request->nama_jemaat;
        $jemaat->tempat_lahir = $request->tempat_lahir;
        $jemaat->tanggal_lahir = $request->tanggal_lahir;
        $jemaat->kelamin = $request->kelamin;
        $jemaat->alamat_jemaat = $request->alamat_jemaat;
        $jemaat->id_kelurahan = $request->id_kelurahan;
        $jemaat->id_kecamatan = $request->id_kecamatan;
        $jemaat->id_kabupaten = $request->id_kabupaten;
        $jemaat->id_provinsi = $request->id_provinsi;
        $jemaat->kodepos = $request->kodepos;
        $jemaat->telepon = $request->telepon;
        $jemaat->hp = $request->hp;
        $jemaat->email = $request->email;
        $jemaat->nik = $request->nik;
        $jemaat->no_kk = $request->no_kk;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photo', 'public');
            $jemaat->photo = $path;
        }

        $jemaat->tanggal_baptis = $request->tanggal_baptis;
        $jemaat->golongan_darah = $request->golongan_darah;
        $jemaat->pendidikan = $request->pendidikan;
        $jemaat->ilmu = $request->ilmu;
        $jemaat->pekerjaan = $request->pekerjaan;
        $jemaat->instansi = $request->instansi;
        $jemaat->penghasilan = $request->penghasilan;
        $jemaat->gereja_baptis = $request->gereja_baptis;
        $jemaat->alat_transportasi = $request->alat_transportasi;
        $jemaat->save(); // Simpan data Jemaat

        // Simpan data ke tabel AtestasiMasuk
        $namaGereja = '';
        if ($request->nama_gereja == null) {
            $namaGereja = $request->new_gereja;
        } else {
            $namaGereja = $request->nama_gereja;
        }

        // dd($namaGereja);
        $data = new AtestasiMasuk();
        $data->id_jemaat = $jemaat->id_jemaat;
        $data->id_wilayah = $request->id_wilayah;
        $data->nama_gereja = $namaGereja;
        $data->no_surat = $request->nomor_surat;
        $data->tanggal_masuk = $request->tanggal_masuk;
        if ($request->hasFile('surat')) {
            $file = $request->file('surat');
            $path = $file->store('surat', 'public');
            $data->surat = $path;
        }
        $data->save(); // Simpan data AtestasiMasuk

        return response()->json($data);
    }


    // POST ATESTASI MASUK END

    // POST BAPTIS ANAK
    public function ApiPostBaptisAnak(Request $request)
    {
        $data = new BaptisAnak();
        if ($request->nama == 'add-new-nama') {
            $jemaat = new Jemaat();
            $jemaat->nama_jemaat = $request->new_name;
            $jemaat->tempat_lahir = $request->tempat_lahir;
            $jemaat->tanggal_lahir = $request->tanggal_lahir;
            $jemaat->kelamin = $request->kelamin;
            $jemaat->alamat_jemaat = $request->alamat;
            $jemaat->tanggal_baptis = $request->tanggal_baptis;
            $jemaat->id_wilayah = $request->id_wilayah;
            $jemaat->save();

            $data->id_jemaat = $jemaat->id_jemaat;
            $data->alamat = $request->alamat_jemaat;
            $data->kelamin = $request->kelamin;
            $data->nama = $request->new_name;
            $data->tempat_lahir = $request->tempat_lahir;
            $data->tanggal_lahir = $request->tanggal_lahir;
            $data->id_wilayah = $request->id_wilayah;
        } else {
            $nama = Jemaat::find($request->nama);
            $data->id_jemaat = $request->nama;
            $data->id_wilayah = $nama->id_wilayah;
            $data->alamat = $nama->alamat;
            $data->kelamin = $nama->kelamin;
            $data->nama = $nama->nama_jemaat;
            $data->tempat_lahir = $nama->tempat_lahir;
            $data->tanggal_lahir = $nama->tanggal_lahir;
            $sidi = BaptisSidi::where('id_jemaat', $request->nama)->first();
            if (!$sidi) {
                $nama->tanggal_baptis = $request->tanggal_baptis;
            }
            $nama->save();
        }

        $data->id_pendeta = $request->id_pendeta;
        $data->nomor = $request->nomor;
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
                'message' => 'Data already exists',
            ]);
        }

        $data = new BaptisDewasa();
        if ($request->nama == 'add-new-nama') {
            $jemaat = new Jemaat();
            $jemaat->nama_jemaat = $request->new_name;
            $jemaat->tempat_lahir = $request->tempat_lahir;
            $jemaat->tanggal_lahir = $request->tanggal_lahir;
            $jemaat->kelamin = $request->kelamin;
            $jemaat->alamat_jemaat = $request->alamat;
            $jemaat->tanggal_baptis = $request->tanggal_baptis;
            $jemaat->id_wilayah = $request->id_wilayah;
            $jemaat->save();

            $data->id_jemaat = $jemaat->id_jemaat;
            $data->alamat = $request->alamat_jemaat;
            $data->kelamin = $request->kelamin;
            $data->nama = $request->new_name;
            $data->tempat_lahir = $request->tempat_lahir;
            $data->tanggal_lahir = $request->tanggal_lahir;
        } else {
            $nama = Jemaat::find($request->nama);
            $data->id_jemaat = $request->nama;
            $data->alamat = $nama->alamat;
            $data->kelamin = $nama->kelamin;
            $data->nama = $nama->nama_jemaat;
            $data->tempat_lahir = $nama->tempat_lahir;
            $data->tanggal_lahir = $nama->tanggal_lahir;
            $sidi = BaptisSidi::where('id_jemaat', $request->nama)->first();
            if (!$sidi) {
                $nama->tanggal_baptis = $request->tanggal_baptis;
            }
            $nama->save();
        }

        $data->id_wilayah = $request->id_wilayah;
        $data->id_pendeta = $request->id_pendeta;
        $data->nomor = $request->nomor;
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
            return response()->json(data: [
                'message' => 'Data already exists',
            ]);
        }

        $data = new BaptisSidi();
        $nama = Jemaat::find($request->nama);
        $nama->tanggal_baptis = $request->tanggal_baptis;
        $nama->save();

        $data->id_jemaat = $request->nama;
        $data->alamat = $nama->alamat;
        $data->kelamin = $nama->kelamin;
        $data->nama = $nama->nama_jemaat;
        $data->tempat_lahir = $nama->tempat_lahir;
        $data->tanggal_lahir = $nama->tanggal_lahir;
        $data->id_wilayah = $nama->id_wilayah;
        $data->id_pendeta = $request->id_pendeta;
        $data->nomor = $request->nomor;
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
                'message' => 'Data already exists',
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
                'message' => 'Data already exists',
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
                'message' => 'Data already exists',
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

    public function ApiUpdateUser(Request $request)
    {
        $validatedData = $request->validate([
            'old_username' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'nama_user' => 'required|string|max:255',
            'role_user' => 'string|max:255|nullable',
            'new_role' => 'strng|max:255|nullable',
            'password' => 'string|nullable',
            'id_wilayah' => 'integer|nullable',
        ]);

        $user = User::find($validatedData['old_username']);

        if ($validatedData['role_user'] != null) {
            $role = Role::where('id_role', $validatedData['role_user'])->first();
            if ($role == null) {
                return response()->json(
                    [
                        'message' => 'Role not found',
                    ],
                    404,
                );
            }
            $validatedData['role_id'] = $validatedData['role_user'];
        } else {
            $new_role = Role::create([
                'nama_role' => $validatedData['new_role'],
            ]);
            $validatedData['role_id'] = $new_role->id;
        }

        $user->username = $validatedData['username'];
        $user->nama_user = $validatedData['nama_user'];
        $user->id_role = $validatedData['role_id'];
        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->id_wilayah = $validatedData['id_wilayah'];

        $user->save();

        return response()->json(
            [
                'message' => 'User created successfully',
                'user' => [
                    'username' => $user->username,
                    'nama_user' => $user->nama_user,
                    'role' => $user->role ? $user->role->nama_role : null,
                ],
            ],
            201,
        );
    }
    // UPDATE USER END

    // UPDATE PEKERJAAN
    // public function ApiUpdatePekerjaan(Request $request)
    // {
    //     $data = Pekerjaan::find($request->id_pekerjaan);

    //     if ($request->id_pekerjaan != $data->id_pekerjaan && Pekerjaan::where('id_pekerjaan', $request->id_pekerjaan)->first() != null) {
    //         return response()->json([
    //             'message' => 'Data already exists',
    //         ]);
    //     }

    //     $data->id_pekerjaan = $request->id_pekerjaan;
    //     $data->pekerjaan = $request->pekerjaan;
    //     $data->save();

    //     return response()->json($data);
    // }
    // UPDATE PEKERJAAN END

    // UPDATE JEMAAT
    public function ApiUpdateJemaat(Request $request)
    {
        $data = Jemaat::find($request->id_jemaat);
        $data->id_wilayah = $request->id_wilayah;
        $data->id_status = $request->id_status;
        $data->stamboek = $request->stamboek;
        $data->nama_jemaat = $request->nama_jemaat;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
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

        if ($request->hasFile('photo')) {
            if ($data->photo && Storage::disk('photo')->exists($data->photo)) {
                Storage::disk('public')->delete($data->photo);
            }

            $file = $request->file('photo');
            $path = $file->store('photo', 'public');
            $data->photo = $path;
        }

        $data->tanggal_baptis = $request->tanggal_baptis;
        $data->golongan_darah = $request->golongan_darah;
        $data->pendidikan = $request->pendidikan;
        $data->ilmu = $request->ilmu;
        $data->pekerjaan = $request->pekerjaan;
        $data->instansi = $request->instansi;
        $data->penghasilan = $request->penghasilan;
        $data->gereja_baptis = $request->gereja_baptis;
        $data->alat_transportasi = $request->alat_transportasi;
        $data->save();

        return response()->json($data);
    }
    // UPDATE JEMAAT END

    // UPDATE JEMAAT DAERAH
    public function ApiUpdateJemaatDaerah(Request $request)
    {
        if ($request->validasi == "tidak valid") {
            $data = JemaatBaru::find($request->id_jemaat);
        } else {
            $data = Jemaat::find($request->id_jemaat);
        }

        $data->id_status = $request->id_status;
        $data->stamboek = $request->stamboek;
        $data->nama_jemaat = $request->nama_jemaat;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
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

        if ($request->hasFile('photo')) {
            if ($data->photo && Storage::disk('photo')->exists($data->photo)) {
                Storage::disk('public')->delete($data->photo);
            }

            $file = $request->file('photo');
            $path = $file->store('photo', 'public');
            $data->photo = $path;
        }

        $data->tanggal_baptis = $request->tanggal_baptis;
        $data->golongan_darah = $request->golongan_darah;
        $data->pendidikan = $request->pendidikan;
        $data->ilmu = $request->ilmu;
        $data->pekerjaan = $request->pekerjaan;
        $data->instansi = $request->instansi;
        $data->penghasilan = $request->penghasilan;
        $data->gereja_baptis = $request->gereja_baptis;
        $data->alat_transportasi = $request->alat_transportasi;
        $data->save();

        return response()->json($data);
    }
    // UPDATE JEMAAT DAERAH END

    // UPDATE KELUARGA
    public function ApiUpdateKeluarga(Request $request)
    {
        $data = Keluarga::find($request->old_id_keluarga);

        if ($request->id_keluarga != $data->id_keluarga && Keluarga::where('id_keluarga', $request->id_keluarga)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }
        $data->id_jemaat = $request->id_jemaat;
        $data->id_wilayah = $request->id_wilayah;
        $data->keterangan_hubungan = $request->keterangan_hubungan;
        $data->save();

        return response()->json($data);
    }
    // UPDATE KELUARGA END

    public function ApiUpdateAnggotaKeluarga(Request $request)
    {
        $data = AnggotaKeluarga::find($request->id_anggota_keluarga);

        $data = new Keluarga();
        $data->id_jemaat = $request->id_jemaat;
        $data->id_anggota_keluarga = $request->id_anggota_keluarga;
        $data->nama_anggota = $request->nama_anggota;
        $data->keterangan_hubungan = $request->keterangan_hubungan;
        $data->id_status = $request->id_status;
        $data->save();

        return response()->json($data);
    }

    // UPDATE PENDETA
    public function ApiUpdatePendeta(Request $request)
    {
        $data = Pendeta::find($request->id_pendeta);

        if ($request->id_pendeta != $data->id_pendeta && Pendeta::where('id_pendeta', $request->id_pendeta)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data->nama_pendeta = $request->nama_pendeta;
        $data->jenjang = $request->jenjang;
        $data->sekolah = $request->sekolah;
        $data->tahun_lulus = $request->tahun_lulus;
        $data->tanggal_mulai = $request->tanggal_mulai;
        $data->tanggal_selesai = $request->tanggal_selesai;
        $data->keterangan = $request->keterangan;
        $data->id_status = $request->id_status;
        if ($request->hasFile('ijazah')) {
            if ($data->ijazah && Storage::disk('public')->exists($data->ijazah)) {
                Storage::disk('public')->delete($data->ijazah);
            }

            $file = $request->file('ijazah');
            $path = $file->store('ijazah', 'public');
            $data->ijazah = $path;
        }
        $data->save();

        return response()->json($data);
    }
    // UPDATE PENDETA END

    // UPDATE MAJELIS
    public function apiUpdateMajelis(Request $request)
    {
        $data = Majelis::find($request->id_majelis);
        if (!$data) {
            return response()->json(['message' => 'Majelis not found'], 404);
        }

        $data->id_jemaat = $request->id_jemaat;
        $data->nama_majelis = Jemaat::where('id_jemaat', $request->id_jemaat)->first()->nama_jemaat;
        $data->tanggal_mulai = $request->tanggal_mulai;
        $data->tanggal_selesai = $request->tanggal_selesai;
        $data->id_jabatan = $request->id_jabatan;
        $data->id_status = $request->id_status;
        $data->no_sk = $request->no_sk;

        if ($request->hasFile('berkas')) {
            if ($data->berkas && Storage::disk('public')->exists($data->berkas)) {
                Storage::disk('public')->delete($data->berkas);
            }

            $file = $request->file('berkas');
            $path = $file->store('berkas', 'public');
            $data->berkas = $path;
        }

        $data->save();

        return response()->json($data, 201);
    }

    // UPDATE MAJELIS END

    // UPDATE NON MAJELIS
    public function apiUpdateNonMajelis(Request $request)
    {
        $data = NonMajelis::find($request->id_nonmajelis);

        $data->id_jemaat = $request->id_jemaat;
        $data->nama_majelis_non = Jemaat::where('id_jemaat', $request->id_jemaat)->first()->nama_jemaat;
        $data->tanggal_mulai = $request->tanggal_mulai;
        $data->tanggal_selesai = $request->tanggal_selesai;
        $data->id_jabatan_non = $request->id_jabatan_non;
        $data->id_status = $request->id_status;
        $data->no_sk = $request->no_sk;

        if ($request->hasFile('berkas')) {
            if ($data->berkas && Storage::disk('public')->exists($data->berkas)) {
                Storage::disk('public')->delete($data->berkas);
            }

            $file = $request->file('berkas');
            $path = $file->store('berkas', 'public');
            $data->berkas = $path;
        }

        $data->save();

        return response()->json($data);
    }
    // UPDATE NON MAJELIS END

    // UPDATE JEMAAT TITIPAN
    public function ApiUpdateJemaatTitipan(Request $request)
    {
        $data = JemaatTitipan::find($request->id_titipan);

        $namaGereja = '';

        if ($request->nama_gereja == null) {
            $namaGereja = $request->new_gereja;
        } else {
            $namaGereja = $request->nama_gereja;
        }

        if ($request->has('id_jemaat')) {
            $data->id_jemaat = $request->id_jemaat;
        } else {
            $data->nama_jemaat = $request->nama_jemaat;
        }

        $data->nama_gereja = $namaGereja;
        $data->kelamin = $request->kelamin;
        $data->alamat_jemaat = $request->alamat_jemaat;
        $data->titipan = $request->titipan;

        if ($request->hasFile('surat')) {
            if ($data->surat && Storage::disk('public')->exists($data->surat)) {
                Storage::disk('public')->delete($data->surat);
            }

            $file = $request->file('surat');
            $path = $file->store('surat', 'public');
            $data->surat = $path;
        }

        $data->save();

        return response()->json($data);
    }
    // UPDATE JEMAAT TITIPAN END

    // UPDATE PERNIKAHAN
    public function ApiUpdatePernikahan(Request $request)
    {
        if ($request->old_nomor != $request->nomor && Pernikahan::where('nomor', $request->nomor)->first() != null) {
            return response()->json([
                'message' => 'Nomor Pernikahan already used',
            ]);
        }

        $data = Pernikahan::where('nomor', $request->old_nomor)->first();
        $namaGereja = '';

        if ($request->nama_gereja == null) {
            $namaGereja = $request->new_gereja;
        } else {
            $namaGereja = $request->nama_gereja;
        }

        $data->nomor = $request->nomor;
        $data->id_wilayah = $request->id_wilayah;
        $data->nama_gereja = $namaGereja;
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
        $data->tempat = $request->tempat;
        $data->ketua_majelis = $request->ketua_majelis;
        $data->sekretaris_majelis = $request->sekretaris_majelis;
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
                'message' => 'Data already exists',
            ]);
        }

        $data->id_jemaat = $request->id_jemaat;
        $data->tanggal_kematian = $request->tanggal_kematian;
        $data->tempat_kematian = $request->tempat_kematian;
        $data->save();

        return response()->json($data);
    }
    // UPDATE KEMATIAN END

    // UPDATE ATESTASI KELUAR
    public function ApiUpdateAtestasiKeluar(Request $request)
    {
        $data = AtestasiKeluar::find($request->old_id_keluar);

        $namaGereja = '';

        if ($request->nama_gereja == null) {
            $namaGereja = $request->new_gereja;
        } else {
            $namaGereja = $request->nama_gereja;
        }

        $data->nama_gereja = $namaGereja;
        $data->no_surat = $request->no_surat;
        $data->tanggal = $request->tanggal;
        $data->keterangan = $request->keterangan;
        $data->save();

        return response()->json($data);
    }
    // UPDATE ATESTASI KELUAR END

    // UPDATE ATESTASI MASUK START
    public function ApiUpdateAtestasiMasuk(Request $request)
    {
        $data = AtestasiMasuk::find($request->old_id_masuk);
        $jemaat = Jemaat::find($data->id_jemaat);

        $namaGereja = '';

        if ($request->nama_gereja == null) {
            $namaGereja = $request->new_gereja;
        } else {
            $namaGereja = $request->nama_gereja;
        }

        $data->id_wilayah = $request->id_wilayah;
        $data->nama_gereja = $namaGereja;
        $data->no_surat = $request->no_surat;
        $data->tanggal = $request->tanggal;
        if ($request->hasFile('surat')) {
            if ($data->surat && Storage::disk('surat')->exists($data->surat)) {
                Storage::disk('public')->delete($data->surat);
            }

            $file = $request->file('surat');
            $path = $file->store('surat', 'public');
            $data->surat = $path;
        }
        $data->save();

        return response()->json($data);
    }
    // UPDATE ATESTASI MASUK END

    // UPDATE BAPTIS ANAK START
    public function ApiUpdateBaptisAnak(Request $request)
    {
        $sidi = BaptisSidi::where('id_jemaat', $request->id_jemaat)->first();
        if (!$sidi) {
            $jemaat = Jemaat::find($request->id_jemaat);
            $jemaat->tanggal_baptis = $request->tanggal_baptis;
            $jemaat->save();
        }

        $data = BaptisAnak::find($request->old_id_ba);
        $data->id_pendeta = $request->id_pendeta;
        $data->nomor = $request->nomor;
        $data->ayah = $request->ayah;
        $data->ibu = $request->ibu;
        $data->tanggal_baptis = $request->tanggal_baptis;
        $data->ketua_majelis = $request->ketua_majelis;
        $data->sekretaris_majelis = $request->sekretaris_majelis;
        $data->save();

        return response()->json($data);
    }
    // UPDATE BAPTIS ANAK END

    // UPDATE BAPTIS DEWASA START
    public function ApiUpdateBaptisDewasa(Request $request)
    {
        $sidi = BaptisSidi::where('id_jemaat', $request->id_jemaat)->first();
        if (!$sidi) {
            $jemaat = Jemaat::find($request->id_jemaat);
            $jemaat->tanggal_baptis = $request->tanggal_baptis;
            $jemaat->save();
        }

        $data = BaptisDewasa::find($request->old_id_bd);
        $data->id_pendeta = $request->id_pendeta;
        $data->nomor = $request->nomor;
        $data->ayah = $request->ayah;
        $data->ibu = $request->ibu;
        $data->tanggal_baptis = $request->tanggal_baptis;
        $data->ketua_majelis = $request->ketua_majelis;
        $data->sekretaris_majelis = $request->sekretaris_majelis;
        $data->save();

        return response()->json($data);
    }
    // UPDATE BAPTIS DEWASA END

    // UPDATE BAPTIS SIDI START
    public function ApiUpdateBaptisSidi(Request $request)
    {
        $jemaat = Jemaat::find($request->id_jemaat);
        $jemaat->tanggal_baptis = $request->tanggal_baptis;
        $jemaat->save();

        $data = BaptisSidi::find($request->old_id_sidi);
        $data->id_pendeta = $request->id_pendeta;
        $data->nomor = $request->nomor;
        $data->ayah = $request->ayah;
        $data->ibu = $request->ibu;
        $data->tanggal_baptis = $request->tanggal_baptis;
        $data->ketua_majelis = $request->ketua_majelis;
        $data->sekretaris_majelis = $request->sekretaris_majelis;
        $data->save();

        return response()->json($data);
    }
    // UPDATE BAPTIS SIDI END

    // API for updating data END

    // API for deleting data
    public function ApiDeleteWilayah(Request $request)
    {
        $data = Wilayah::find($request->id);
        if ($data) {
            $data->delete();
            return response()->json([
                'message' => 'Wilayah deleted successfully',
                'data' => $data,
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
                'data' => $data,
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
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Jabatan Non Majelis not found'], 404);
    }

    public function ApiDeleteUser(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|exists:users,username',
        ]);

        $user = User::find($validatedData['username']);
        if ($user) {
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully',
                'data' => $user,
            ]);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    // public function ApiDeletePekerjaan(Request $request)
    // {
    //     $data = Pekerjaan::find($request->id_pekerjaan);
    //     if ($data) {
    //         $data->delete();
    //         return response()->json([
    //             'message' => 'Pekerjaan deleted successfully',
    //             'data' => $data,
    //         ]);
    //     }

    //     return response()->json(['message' => 'Pekerjaan not found'], 404);
    // }

    public function ApiDeleteProvinsi(Request $request)
    {
        // Cari provinsi berdasarkan id_provinsi
        $provinsi = Provinsi::find($request->id_provinsi);

        if ($provinsi) {
            // Cari semua kabupaten yang terkait dengan provinsi
            $kabupaten = Kabupaten::where('id_provinsi', $request->id_provinsi)->get();

            if ($kabupaten->isNotEmpty()) {
                foreach ($kabupaten as $kab) {
                    $kecamatan = Kecamatan::where('id_kabupaten', $kab->id_kabupaten)->get();

                    if ($kecamatan->isNotEmpty()) {
                        foreach ($kecamatan as $kec) {
                            $kelurahan = Kelurahan::where('id_kecamatan', $kec->id_kecamatan)->get();

                            if ($kelurahan->isNotEmpty()) {
                                foreach ($kelurahan as $kel) {
                                    $kel->delete();
                                }
                            }
                            $kec->delete();
                        }
                    }
                    $kab->delete();
                }
            }
            $provinsi->delete();

            return response()->json([
                'message' => 'Provinsi deleted successfully',
                'data' => $provinsi,
            ]);
        }

        return response()->json(['message' => 'Provinsi not found'], 404);
    }

    // DELETE PROVINSI END

    // DELETE KABUPATEN START
    public function ApiDeleteKabupaten(Request $request)
    {
        $kabupaten = Kabupaten::find($request->id_kabupaten);

        if ($kabupaten) {
            $kecamatan = Kecamatan::where('id_kabupaten', $request->id_kabupaten)->get();

            if ($kecamatan->isNotEmpty()) {
                foreach ($kecamatan as $kec) {
                    $kelurahan = Kelurahan::where('id_kecamatan', $kec->id_kecamatan)->get();

                    if ($kelurahan->isNotEmpty()) {
                        foreach ($kelurahan as $kel) {
                            $kel->delete();
                        }
                    }
                    $kec->delete();
                }
            }
            $kabupaten->delete();

            return response()->json([
                'message' => 'Kabupaten deleted successfully',
                'data' => $kabupaten,
            ]);
        }

        return response()->json(['message' => 'Kabupaten not found'], 404);
    }
    // DELETE KABUPATEN END

    // DELETE KECAMATAN START
    public function ApiDeleteKecamatan(Request $request)
    {
        $kecamatan = Kecamatan::find($request->id_kecamatan);

        if ($kecamatan) {
            $kelurahan = Kelurahan::where('id_kecamatan', $request->id_kecamatan)->get();

            if ($kelurahan->isNotEmpty()) {
                foreach ($kelurahan as $kel) {
                    $kel->delete();
                }
            }
            $kecamatan->delete();

            return response()->json([
                'message' => 'Kecamatan deleted successfully',
                'data' => $kecamatan,
            ]);
        }

        return response()->json(['message' => 'Kecamatan not found'], 404);
    }
    // DELETE KECAMATAN END

    // DELETE KELURAHAN START
    public function ApiDeleteKelurahan(Request $request)
    {
        $kelurahan = Kelurahan::find($request->id_kelurahan);

        if ($kelurahan) {
            $kelurahan->delete();

            return response()->json([
                'message' => 'Kelurahan deleted successfully',
                'data' => $kelurahan,
            ]);
        }

        return response()->json(['message' => 'Kelurahan not found'], 404);
    }
    // DELETE KELURAHAN END

    public function ApiDeleteKeluarga(Request $request)
    {
        $data = Keluarga::find($request->id_keluarga);
        if ($data) {
            $data->delete();
            return response()->json([
                'message' => 'Keluarga deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Keluarga not found'], 404);
    }

    public function ApiDeleteAnggotaKeluarga(Request $request)
    {
        $data = AnggotaKeluarga::find($request->id_anggota_keluarga);
        if ($data) {
            $data->delete();
            return response()->json([
                'message' => 'Anggota Keluarga deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Anggota Keluarga not found'], 404);
    }

    public function ApiDeleteJemaat(Request $request)
    {
        if ($request->has('validasi')) {
            if ($request->validasi == "tidak valid") {
                $data = JemaatBaru::find($request->id_jemaat);
            } else {
                $data = Jemaat::find($request->id_jemaat);
            }
        } else {
            $data = Jemaat::find($request->id_jemaat);
        }

        if ($data) {
            if ($data->photo && Storage::disk('public')->exists($data->photo)) {
                Storage::disk('public')->delete($data->photo);
            }

            $data->delete();
            return response()->json([
                'message' => 'Jemaat deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Jemaat not found'], 404);
    }

    // DELETE PENDETA
    public function ApiDeletePendeta(Request $request)
    {
        $id_pendeta = $request->input('id');

        $data = Pendeta::find($id_pendeta);
        if ($data) {
            $data->delete();

            return response()->json([
                'message' => 'Pendeta deleted successfully',
                'data' => $data,
            ]);
        }
        return response()->json(['message' => 'Pendeta not found'], 404);
    }

    // DELETE PENDETA END
    public function apiDeleteMajelis(Request $request)
    {
        $data = Majelis::find($request->id_majelis);
        if ($data) {
            if ($data->berkas && Storage::disk('public')->exists($data->berkas)) {
                Storage::disk('public')->delete($data->berkas);
            }

            $data->delete();

            return response()->json([
                'message' => 'Majelis deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(
            [
                'message' => 'Majelis not found',
            ],
            404,
        );
    }

    public function apiDeleteNonMajelis(Request $request)
    {
        $data = NonMajelis::find($request->id_nonmajelis);
        if ($data) {
            if ($data->berkas && Storage::disk('public')->exists($data->berkas)) {
                Storage::disk('public')->delete($data->berkas);
            }

            $data->delete();
            return response()->json([
                'message' => 'Non Majelis deleted successfully',
                'data' => $data,
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
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Non Majelis not found'], 404);
    }

    public function ApiDeleteJemaatTitipan(Request $request)
    {
        $data = JemaatTitipan::find($request->id_titipan);
        if ($data) {
            if ($data->surat && Storage::disk('public')->exists($data->surat)) {
                Storage::disk('public')->delete($data->surat);
            }
            $data->delete();
            return response()->json([
                'message' => 'Jemaat Titipan deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Jemaat Titipan not found'], 404);
    }

    public function ApiDeletePernikahan(Request $request)
    {
        $data = Pernikahan::where('nomor', $request->nomor)->first();
        if ($data) {
            $data->delete();
            return response()->json([
                'message' => 'Pernikahan deleted successfully',
                'data' => $data,
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
                'data' => $data,
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
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Atestasi Keluar not found'], 404);
    }

    public function ApiDeleteAtestasiKeluarDetail(Request $request)
    {
        $data = AtestasiKeluarDtl::find($request->id_keluar_dtl);
        if ($data) {
            $jemaat = Jemaat::find($data->id_jemaat);
            $jemaat->id_status = '1';
            $jemaat->save();

            $data->delete();
            return response()->json([
                'message' => 'Atestasi keluar detail deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Atestasi Masuk not found'], 404);
    }

    public function ApiDeleteAtestasiMasuk(Request $request)
    {
        $data = AtestasiMasuk::find($request->id_masuk);
        if ($data) {
            if ($data->surat && Storage::disk('surat')->exists($data->surat)) {
                Storage::disk('public')->delete($data->surat);
            }

            $data->delete();
            return response()->json([
                'message' => 'Atestasi Masuk deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Atestasi Masuk not found'], 404);
    }

    public function ApiDeleteBaptisAnak(Request $request)
    {
        $data = BaptisAnak::find($request->id_ba);
        $jemaat = Jemaat::find($data->id_jemaat);

        if ($data) {
            $sidi = BaptisSidi::where('id_jemaat', $request->id_jemaat)->first();
            if (!$sidi) {
                $jemaat->tanggal_baptis = null;
                $jemaat->save();
            }
            $data->delete();
            return response()->json([
                'message' => 'Baptis Anak deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Baptis Anak not found'], 404);
    }

    public function ApiDeleteBaptisDewasa(Request $request)
    {
        $data = BaptisDewasa::find($request->id_bd);
        $jemaat = Jemaat::find($data->id_jemaat);

        if ($data) {
            $sidi = BaptisSidi::where('id_jemaat', $request->id_jemaat)->first();
            if (!$sidi) {
                $jemaat->tanggal_baptis = null;
                $jemaat->save();
            }
            $jemaat->save();
            return response()->json([
                'message' => 'Baptis Dewasa deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Baptis Dewasa not found'], 404);
    }

    public function ApiDeleteBaptisSidi(Request $request)
    {
        $data = BaptisSidi::find($request->id_sidi);
        $jemaat = Jemaat::find($data->id_jemaat);

        if ($data) {
            $jemaat->tanggal_baptis = null;
            $jemaat->save();
            $data->delete();
            return response()->json([
                'message' => 'Baptis Sidi deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Baptis Sidi not found'], 404);
    }
}
