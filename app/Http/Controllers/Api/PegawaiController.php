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
                ->get(config('services.pegawai.url') . '/get/data/employee');

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Gagal ambil data pegawai',
                    'status' => $response->status()
                ], $response->status());
            }

            $json = $response->json();

            return response()->json([
                'raw' => $json
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
