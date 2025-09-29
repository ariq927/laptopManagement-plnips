<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PegawaiController extends Controller
{
    public function index(Request $request)
{
    try {
        $response = Http::withOptions(['verify' => false])
            ->get('https://i-morning.plnipservices.co.id/api/get/data/employee');

        if ($response->failed()) {
            return response()->json([
                'error' => 'Gagal ambil data pegawai',
                'status' => $response->status()
            ], $response->status());
        }

        $json = $response->json();

        // 🔥 Debug dulu biar kita tahu format aslinya
        return response()->json([
            'raw' => $json
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
