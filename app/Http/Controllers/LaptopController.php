<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaptopData;

class LaptopController extends Controller
{
    // Tampilkan semua laptop dengan pagination dan search
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // default 10
        $search = $request->input('search');

        $laptops = LaptopData::when($search, function($query, $search) {
                        return $query->where('merek', 'like', "%{$search}%")
                                     ->orWhere('tipe', 'like', "%{$search}%")
                                     ->orWhere('spesifikasi', 'like', "%{$search}%")
                                     ->orWhere('serial_number', 'like', "%{$search}%");
                    })
                    ->paginate($perPage) // gunakan paginate, bukan get
                    ->withQueryString(); // query string search tetap terbawa

        return view('content.tables.tables-laptop', compact('laptops', 'perPage'));
    }

    // Form tambah laptop
    public function create()
    {
        return view('content.laptop.create');
    }

    // Simpan laptop baru
    public function store(Request $request)
    {
        $request->validate([
            'merek' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'spesifikasi' => 'required|string',
            'serial_number' => 'required|string|unique:laptop_data,serial_number',
            'status' => 'required|in:tersedia,dipinjam,maintenance',
        ]);

        LaptopData::create($request->all());

        return redirect()->route('laptop.index')->with('success', 'Laptop berhasil ditambahkan!');
    }
}
