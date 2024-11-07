<?php

namespace App\Http\Controllers;


use App\Models\Gereja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule as Rule;

// PENGATURAN
use App\Models\Wilayah as Wilayah;
use App\Models\JabatanMajelis as JabatanMajelis;
use App\Models\JabatanNonMajelis as JabatanNonMajelis;
use App\Models\User as User;
use App\Models\RolePengguna as Role;
use App\Models\Pekerjaan as Pekerjaan;
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
                        return [
                            'username' => $item->username,
                            'nama_user' => $item->nama_user,
                            'role' => $item->role ? $item->role->nama_role : null,
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
                        return [
                            'username' => $item->username,
                            'nama_user' => $item->nama_user,
                            'role' => $item->role ? $item->role->nama_role : null,
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
    public function ApiGetPekerjaan(Request $request)
    {
        if ($request->has('id')) {
            $data = Pekerjaan::where('id_pekerjaan', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Pekerjaan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_pekerjaan' => $item->id_pekerjaan,
                            'pekerjaan' => $item->pekerjaan,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = Pekerjaan::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Pekerjaan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_pekerjaan' => $item->id_pekerjaan,
                            'pekerjaan' => $item->pekerjaan,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
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
    if ($request->has('nama_jemaat') || $request->has('id')) {
            if ($request->has('nama_jemaat')) {
                $data = Jemaat::where('nama_jemaat', $request->nama_jemaat)->get();
            } else {
                $data = Jemaat::where('id_jemaat', $request->id)->get();
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
                            'id_pendidikan' => $item->id_pendidikan,
                            'nama_pendidikan' => $item->pendidikan ? $item->pendidikan->nama_pendidikan : null,
                            'id_ilmu' => $item->id_ilmu,
                            'bidang_ilmu' => $item->ilmu ? $item->ilmu->nama_ilmu : null,
                            'id_pekerjaan' => $item->id_pekerjaan,
                            'pekerjaan' => $item->pekerjaan ? $item->pekerjaan->pekerjaan : null,
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
            if ($request->has('id_role')) {
                $nama_wilayah = Role::where('id_role', $request->id_role)->first()->nama_role;
                $parseWilayahString = preg_replace('/Admin\s*/', '', $nama_wilayah);
                $idWilayah = Wilayah::where('nama_wilayah', $parseWilayahString)->first()->id_wilayah;

                $data = Jemaat::where('id_wilayah', $idWilayah)->get();
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
                            'id_pendidikan' => $item->id_pendidikan,
                            'nama_pendidikan' => $item->pendidikan ? $item->pendidikan->nama_pendidikan : null,
                            'id_ilmu' => $item->id_ilmu,
                            'bidang_ilmu' => $item->ilmu ? $item->ilmu->nama_ilmu : null,
                            'id_pekerjaan' => $item->id_pekerjaan,
                            'pekerjaan' => $item->pekerjaan ? $item->pekerjaan->pekerjaan : null,
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

    public function ApiGetJemaatById($id_jemaat)
    {
        // Retrieve the Jemaat record by ID
        $jemaat = Jemaat::with(['wilayah', 'status', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'pendidikan', 'ilmu', 'pekerjaan', 'pernikahan'])->find($id_jemaat);

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
            'id_kelurahan' => $jemaat->id_kelurahan,
            'nama_kelurahan' => $jemaat->kelurahan ? $jemaat->kelurahan->nama_kelurahan : null,
            'id_kecamatan' => $jemaat->id_kecamatan,
            'nama_kecamatan' => $jemaat->kecamatan ? $jemaat->kecamatan->nama_kecamatan : null,
            'id_kabupaten' => $jemaat->id_kabupaten,
            'nama_kabupaten' => $jemaat->kabupaten ? $jemaat->kabupaten->nama_kabupaten : null,
            'id_provinsi' => $jemaat->id_provinsi,
            'nama_provinsi' => $jemaat->provinsi ? $jemaat->provinsi->nama_provinsi : null,
            'kodepos' => $jemaat->kodepos,
            'telepon' => $jemaat->telepon,
            'hp' => $jemaat->hp,
            'email' => $jemaat->email,
            'nik' => $jemaat->nik,
            'no_kk' => $jemaat->no_kk,
            'photo' => $jemaat->photo,
            'tanggal_baptis' => $jemaat->tanggal_baptis,
            'golongan_darah' => $jemaat->golongan_darah,
            'id_pendidikan' => $jemaat->id_pendidikan,
            'pendidikan' => $jemaat->pendidikan ? $jemaat->pendidikan->nama_pendidikan : null,
            'id_ilmu' => $jemaat->id_ilmu,
            'bidang_ilmu' => $jemaat->ilmu ? $jemaat->ilmu->bidangilmu : null,
            'id_pekerjaan' => $jemaat->id_pekerjaan,
            'pekerjaan' => $jemaat->pekerjaan ? $jemaat->pekerjaan->pekerjaan : null,
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
                'rows' => $data->map(function ($item) {
                    return [
                        'id_keluarga' => $item->id_keluarga,
                        'id_jemaat' => $item->id_jemaat,
                        'kepala_keluarga' => $item->kepala_keluarga,
                        'id_wilayah' => $item->id_wilayah,
                        'nama_wilayah' => $item->wilayah ? $item->wilayah->nama_wilayah : null,
                    ];
                })->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            // Mengambil semua data keluarga
            $data = Keluarga::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Keluarga::count(),
                'rows' => $data->map(function ($item) {
                    return [
                        'id_keluarga' => $item->id_keluarga,
                        'id_jemaat' => $item->id_jemaat,
                        'kepala_keluarga' => $item->kepala_keluarga,
                        'id_wilayah' => $item->id_wilayah,
                        'nama_wilayah' => $item->wilayah ? $item->wilayah->nama_wilayah : null,
                    ];
                })->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET KELUARGA END

    // GET ANGGOTA KELUARGA
    public function ApiGetAnggotaKeluarga(Request $request)
    {
        if ($request->has('id_keluarga')) {
            $anggotaKeluarga = AnggotaKeluarga::where('id_keluarga', $request->id_keluarga)
                ->with(['jemaat', 'status'])
                ->get();

            $formattedData = $anggotaKeluarga->map(function ($item) {
                return [
                    'id_jemaat' => $item->jemaat ? $item->jemaat->id_jemaat : null,
                    'nama_anggota' => $item->nama_anggota,
                    'keterangan_status' => $item->status ? $item->status->keterangan_status : null,
                ];
            });

            return response()->json($formattedData);
        }
    }
    // GET ANGGOTA KELUARGA END

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
                            'id_wilayah' => $item->id_wilayah,
                            'nama_wilayah' => $item->wilayah ? $item->wilayah->nama_wilayah : null,
                            'nama_gereja' => $item->nama_gereja,
                            'nama_jemaat' => $item->nama_jemaat,
                            'kelamin' => $item->kelamin,
                            'alamat_jemaat' => $item->alamat_jemaat,
                            'titipan' => $item->titipan,
                            'surat' => $item->surat,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        } else {
            $data = JemaatTitipan::all();
            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Pekerjaan::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_titipan' => $item->id_titipan,
                            'id_wilayah' => $item->id_wilayah,
                            'nama_wilayah' => $item->wilayah ? $item->wilayah->nama_wilayah : null,
                            'nama_gereja' => $item->nama_gereja,
                            'nama_jemaat' => $item->nama_jemaat,
                            'kelamin' => $item->kelamin,
                            'alamat_jemaat' => $item->alamat_jemaat,
                            'titipan' => $item->titipan,
                            'surat' => $item->surat,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET JEMAAT TITTIPAN END

    // GET PENDETA START
    public function ApiGetPendeta(Request $request) {
        if ($request->has('id')) {
            $data = Pendeta::where('id_pendeta', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Pendeta::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $item->nama_pendeta,
                            'jenjang'=> $item->jenjang,
                            'sekolah' => $item->sekolah,
                            'tahun_lulus' => $item->tahun_lulus,
                            'keterangan' => $item->keterangan,
                            'ijazah' => $item->ijazah,
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
                        return [
                           'id_pendeta' => $item->id_pendeta,
                            'nama_pendeta' => $item->nama_pendeta,
                            'jenjang'=> $item->jenjang,
                            'sekolah' => $item->sekolah,
                            'tahun_lulus' => $item->tahun_lulus,
                            'keterangan' => $item->keterangan,
                            'ijazah' => $item->ijazah,
                        ];
                    })
                    ->toArray(),
            ];

            return response()->json($formattedData);
        }
    }
    // GET PENDETA END

    // API GET GEREJA
    public function ApiGetGereja(Request $request) {
        $gerejaFromAtestasiKeluar = AtestasiKeluar::select('nama_gereja')->distinct()->get();
        $gerejaFromAtestasiMasuk = AtestasiMasuk::select('nama_gereja')->distinct()->get();
        $gerejaFromKematian = Kematian::select('nama_gereja')->distinct()->get();
        $gerejaFromMajelis = Majelis::select('nama_gereja')->distinct()->get();
        $gerejaFromNonMajelis = NonMajelis::select('nama_gereja')->distinct()->get();
        $gerejaFromPernikahan = Pernikahan::select('nama_gereja')->distinct()->get();

        $gereja = collect($gerejaFromAtestasiKeluar)
            ->merge($gerejaFromAtestasiMasuk)
            ->merge($gerejaFromKematian)
            ->merge($gerejaFromMajelis)
            ->merge($gerejaFromNonMajelis)
            ->merge($gerejaFromPernikahan)
            ->unique('nama_gereja')
            ->values();

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
                            'nama_gereja' => $item->nama_gereja,
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
                            'nama_gereja' => $item->nama_gereja,
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
                        return [
                            'id_nikah' => $item->id_nikah,
                            'nomor' => $item->nomor,
                            'nama_gereja' => $item->nama_gereja,
                            'tanggal_nikah' => $item->tanggal_nikah,
                            'id_pendeta' => $item->id_pendeta,
                            'pendeta' => $pendeta->nama_pendeta,
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
                        return [
                            'id_nikah' => $item->id_nikah,
                            'nomor' => $item->nomor,
                            'nama_gereja' => $item->nama_gereja,
                            'tanggal_nikah' => $item->tanggal_nikah,
                            'id_pendeta' => $item->id_pendeta,
                            'pendeta' => $pendeta->nama_pendeta,
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
        if ($request->has('id')) {
            $data = Kematian::where('id_kematian', $request->id)->get();

            $formattedData = [
                'total' => $data->count(),
                'totalNotFiltered' => Kematian::count(),
                'rows' => $data
                    ->map(function ($item) {
                        return [
                            'id_kematian' => $item->id_kematian,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_gereja' => $item->nama_gereja,
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
                        return [
                            'id_kematian' => $item->id_kematian,
                            'id_jemaat' => $item->id_jemaat,
                            'nama_gereja' => $item->nama_gereja,
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
                            'id_jemaat' => $item->id_jemaat,
                            'id_pendeta' => $item->id_pendeta,
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
                            'id_jemaat' => $item->id_jemaat,
                            'id_pendeta' => $item->id_pendeta,
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
                        return [
                            'id_masuk' => $item->id_masuk,
                            'id_wilayah' => $item->id_wilayah,
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
                        return [
                            'id_masuk' => $item->id_masuk,
                            'id_wilayah' => $item->id_wilayah,
                            'nama_gereja' => $item->nama_gereja,
                            'no_surat' => $item->no_surat,
                            'tanggal' => $item->tanggal,
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
    public function ApiPostPekerjaan(Request $request)
    {
        if (Pekerjaan::where('id_pekerjaan', $request->id_pekerjaan)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data = new Pekerjaan();
        $data->id_pekerjaan = $request->id_pekerjaan;
        $data->pekerjaan = $request->pekerjaan;
        $data->save();

        return response()->json($data);
    }
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
                'message' => 'Data already exists',
            ]);
        }

        $data = new Keluarga();
        $data->id_jemaat = $request->id_jemaat;
        $data->kepala_keluarga = $request->kepala_keluarga;
        $data->id_wilayah = $request->id_wilayah;
        $data->save();

        return response()->json($data);
    }
    // POST KELUARGA END

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
        $data->keterangan = $request->keterangan;
        $data->ijazah = $request->ijazah;
        $data->save();

        return response()->json($data);
    }
    // POST PENDETA END

    // POST MAJELIS
    public function ApiPostMajelis(Request $request)
    {
        // Check if id_majelis already exists
        if (Majelis::where('id_majelis', $request->id_majelis)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        // Create a new Majelis instance
        $data = new Majelis();
        $data->id_jemaat = $request->id_jemaat;
        $data->nama_majelis = $request->nama_majelis;
        $data->nama_gereja = $request->nama_gereja;
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
                'message' => 'Data already exists',
            ]);
        }

        $data = new NonMajelis();
        $data->id_nonmajelis = $request->id_nonmajelis;
        $data->id_jemaat = $request->id_jemaat;
        $data->nama_majelis_non = $request->nama_majelis_non;
        $data->nama_gereja = $request->nama_gereja;
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
        $data->warga = $request->warga;
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

        $data = new Kematian();
        $data->id_jemaat = $request->id_jemaat;
        $data->nama_gereja = $request->nama_gereja;
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

        $data = new AtestasiKeluar();
        $data->id_jemaat = $request->id_jemaat;
        $data->id_pendeta = $request->id_pendeta;
        $data->nama_gereja = $request->nama_gereja;
        $data->no_surat = $request->no_surat;
        $data->tanggal = $request->tanggal;
        $data->keterangan = $request->keterangan;
        $data->save();

        return response()->json($data);
    }
    // POST ATESTASI KELUAR END

    // POST ATESTASI MASUK
    public function ApiPostAtestasiMasuk(Request $request)
    {
        if (AtestasiMasuk::where('id_masuk', $request->id_masuk)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data = new AtestasiMasuk();
        $data->id_wilayah = $request->id_wilayah;
        $data->nama_gereja = $request->nama_gereja;
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
                'message' => 'Data already exists',
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
                'message' => 'Data already exists',
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
                'message' => 'Data already exists',
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
    public function ApiUpdatePekerjaan(Request $request)
    {
        $data = Pekerjaan::find($request->id_pekerjaan);

        if ($request->id_pekerjaan != $data->id_pekerjaan && Pekerjaan::where('id_pekerjaan', $request->id_pekerjaan)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
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
                'message' => 'Data already exists',
            ]);
        }

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
                'message' => 'Data already exists',
            ]);
        }

        $data = new Keluarga();
        $data->id_jemaat = $request->id_jemaat;
        $data->kepala_keluarga = $request->kepala_keluarga;
        $data->id_wilayah = $request->id_wilayah;
        $data->save();

        return response()->json($data);
    }
    // UPDATE KELUARGA END

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
        $data->keterangan = $request->keterangan;
        $data->ijazah = $request->ijazah;
        $data->save();

        return response()->json($data);
    }
    // UPDATE PENDETA END

    // UPDATE MAJELIS
    public function apiUpdateMajelis(Request $request)
    {
        $data = Majelis::find($request->id_majelis);
        if ($request->id_majelis != $data->id_majelis && Majelis::where('id_majelis', $request->id_majelis)->first() != null) {
            return response()->json([
                'message' => 'Data already exists',
            ]);
        }

        $data->id_jemaat = $request->id_jemaat;
        $data->nama_majelis = $request->nama_majelis;
        $data->nama_gereja = $request->nama_gereja;
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
                'message' => 'Data already exists',
            ]);
        }

        $data->id_jemaat = $request->id_jemaat;
        $data->nama_majelis_non = $request->nama_majelis_non;
        $data->nama_gereja = $request->nama_gereja;
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
        if($request->old_nomor != $request->nomor && Pernikahan::where('nomor', $request->nomor)->first() != null){
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
        $data->warga = $request->warga;
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

    public function ApiDeletePekerjaan(Request $request)
    {
        $data = Pekerjaan::find($request->id_pekerjaan);
        if ($data) {
            $data->delete();
            return response()->json([
                'message' => 'Pekerjaan deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Pekerjaan not found'], 404);
    }

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

    public function ApiDeleteJemaat(Request $request)
    {
        $data = Jemaat::find($request->id_jemaat);
        if ($data) {
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
        $data = Pendeta::find($request->id_pendeta);
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
            $data->delete();
            return response()->json([
                'message' => 'Majelis deleted successfully',
                'data' => $data,
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

    public function ApiDeleteAtestasiMasuk(Request $request)
    {
        $data = AtestasiMasuk::find($request->id_masuk);
        if ($data) {
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
        if ($data) {
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
        if ($data) {
            $data->delete();
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
        if ($data) {
            $data->delete();
            return response()->json([
                'message' => 'Baptis Sidi deleted successfully',
                'data' => $data,
            ]);
        }

        return response()->json(['message' => 'Baptis Sidi not found'], 404);
    }
}
