<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wilayah as Wilayah;
use App\Models\JabatanMajelis as JabatanMajelis;
use App\Models\JabatanNonMajelis as JabatanNonMajelis;

class ApiController extends Controller
{
    // API for getting all data
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
    // API for getting all data END

    // API for posting data
    public function ApiPostWilayah(Request $request)
    {
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

    public function ApiPostJabatanMajelis(Request $request)
    {
        $data = new JabatanMajelis();
        $data->id_jabatan = $request->id_jabatan;
        $data->jabatan_majelis = $request->jabatan_majelis;
        $data->periode = $request->periode;
        $data->save();

        return response()->json($data);
    }

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
    // API for posting data ENS

    // API for updating data
    public function ApiUpdateWilayah(Request $request)
    {
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

    public function ApiUpdateJabatanMajelis(Request $request)
    {
        $data = JabatanMajelis::find($request->id);
        $data->id_jabatan = $request->id_jabatan;
        $data->jabatan_majelis = $request->jabatan_majelis;
        $data->periode = $request->periode;
        $data->save();

        return response()->json($data);
    }

    public function ApiUpdateJabatanNonMajelis(Request $request)
    {
        if ( $request->id != $request->id_jabatan_non && JabatanNonMajelis::where('id_jabatan_non', $request->id_jabatan_non)->first() != null ) {
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
    // API for updating data END

    // API for deleting data
    public function ApiDeleteWilayah(Request $request)
    {
        $data = Wilayah::find($request->id);
        $data->delete();

        return response()->json($data);
    }

    public function ApiDeleteJabatanMajelis(Request $request)
    {
        $data = JabatanMajelis::find($request->id);
        $data->delete();

        return response()->json($data);
    }

    public function ApiDeleteJabatanNonMajelis(Request $request)
    {
        $data = JabatanNonMajelis::find($request->id);
        $data->delete();

        return response()->json($data);
    }
    // API for deleting data END
}
