<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiOutsideController extends Controller
{
    public function ApiOutsideGetWilayah(Request $request)
    {
        if ($request->has('id_provinsi')) {
            if ($request->has('id_kabupaten')) {
                if ($request->has('id_kecamatan')) {
                    $response = Http::get('https://sipedas.pertanian.go.id/api/wilayah/list_wilayah?thn=2024&lvl=13&pro=' . $request->id_provinsi . '&kab=' . $request->id_kabupaten . '&kec=' . $request->id_kecamatan);
                    return $response->json();
                }

                $response = Http::get('https://sipedas.pertanian.go.id/api/wilayah/list_wilayah?thn=2024&lvl=12&pro=' . $request->id_provinsi . '&kab=' . $request->id_kabupaten);
                return $response->json();
            }

            $response = Http::get('https://sipedas.pertanian.go.id/api/wilayah/list_wilayah?thn=2024&lvl=11&pro=' . $request->id_provinsi);
            return $response->json();
        } else {
            $response = Http::get('https://sipedas.pertanian.go.id/api/wilayah/list_wilayah?thn=2024&lvl=10');
            return $response->json();
        }
    }
}
