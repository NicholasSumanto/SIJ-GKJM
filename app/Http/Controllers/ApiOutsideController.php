<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiOutsideController extends Controller
{
    public function ApiOutsideGetWilayah(Request $request)
    {
        $response = Http::get('https://sipedas.pertanian.go.id/api/wilayah/list_wilayah?thn=2024&lvl=10');
        return $response->json();
    }
}
