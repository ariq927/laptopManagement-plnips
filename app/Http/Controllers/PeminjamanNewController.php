<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaptopData;
use App\Models\DataPeminjam;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PeminjamanNewController extends Controller
{
    // Form peminjaman
    public function create($id)
    {
        $laptop = LaptopData::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); // ambil user yg lagi login

        return view('content.peminjaman.form', compact('laptop', 'user'));
    }

    // Simpan peminjaman
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); // ini model User yang login

        $request->validate([
            'laptop_id' => 'required|exists:laptop_data,id',
            'department' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'nomor_telepon' => 'required|string',
        ]);

        // Simpan peminjaman
        DataPeminjam::create([
            'user_id' => $user->id,                  // ambil ID user login
            'laptop_id' => $request->laptop_id,
            'nama' => $request->nama, // ambil dari user login, fallback request
            'department' => $request->department,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        // Update status laptop
        $laptop = LaptopData::find($request->laptop_id);
        $laptop->status = 'dipinjam';
        $laptop->save();

        return redirect()->route('laptop.index')->with('success', 'Peminjaman berhasil disimpan!');
    }

    // Tampilkan semua peminjaman (tabel)
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $peminjams = DataPeminjam::where('user_id', $user->id)->get();
        } else {
            $peminjams = collect();
        }

        return view('content.tables.tables-basic', compact('peminjams'));
    }

    // Selesai peminjaman
    public function selesai($id)
    {
        $pinjam = DataPeminjam::findOrFail($id);

        if ($pinjam->laptop) {
            $pinjam->laptop->status = 'tersedia';
            $pinjam->laptop->save();
        }

        $pinjam->delete();

        return redirect()->back()->with('success', 'Peminjaman selesai, laptop sekarang tersedia.');
    }

    // Debug session
    public function sore(Request $request)
    {
        dd($request->all(), Session::get('user'));
    }

    public function cari(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        
        $peminjams = DataPeminjam::where('user_id', $user->id)
                        ->when($search, function ($query, $search) {
                            return $query->where('nama', 'like', "%{$search}%")
                                         ->orWhere('department', 'like', "%{$search}%");
                        })
                        ->paginate($perPage)
                        ->withQueryString();

        return view('content.tables.tables-basic', compact('peminjams', 'perPage', 'user'));
    }

}
