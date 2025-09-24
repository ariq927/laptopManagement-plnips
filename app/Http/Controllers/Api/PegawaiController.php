<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class PegawaiController extends Controller
{
    public function index()
    {
        try {
            // Skip SSL verification biar ga error cURL 60
            $response = Http::withOptions(['verify' => false])
                ->get('https://i-morning.plnipservices.co.id/api/get/data/employee');

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Gagal ambil data pegawai',
                    'status' => $response->status()
                ], $response->status());
            }

            $json = $response->json();

            // Ambil hanya field 'data' biar frontend gampang baca
            return response()->json([
                'data' => $json['data'] ?? []
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
