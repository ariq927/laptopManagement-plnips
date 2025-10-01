<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaptopData;
use App\Models\DataPeminjam;
use App\Models\HistoriPeminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanNewController extends Controller
{
    // Form peminjaman
    public function create($id)
    {
        $laptop = LaptopData::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 
        return view('content.peminjaman.form', compact('laptop', 'user'));
    }

    // Simpan peminjaman
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 

        $request->validate([
            'laptop_id' => 'required|exists:laptop_data,id',
            'department' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'nomor_telepon' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $user) {
            DataPeminjam::create([
                'user_id' => $user->id,
                'laptop_id' => $request->laptop_id,
                'nama' => $request->nama,
                'department' => $request->department,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'nomor_telepon' => $request->nomor_telepon,
            ]);

            HistoriPeminjaman::create([
                'user_id' => $user->id,
                'laptop_id' => $request->laptop_id,
                'nama' => $request->nama,
                'department' => $request->department,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'nomor_telepon' => $request->nomor_telepon,
                'status' => 'aktif',
            ]);

            // Update status laptop
            $laptop = LaptopData::find($request->laptop_id);
            $laptop->status = 'dipinjam';
            $laptop->save();
        });

        return redirect()->route('laptop.index')->with('success', 'Peminjaman berhasil disimpan!');
    }

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

        DB::transaction(function () use ($pinjam) {
            // Update status laptop
            if ($pinjam->laptop) {
                $pinjam->laptop->status = 'tersedia';
                $pinjam->laptop->save();
            }

            // Update histori jadi selesai
            HistoriPeminjaman::where('laptop_id', $pinjam->laptop_id)
                ->where('user_id', $pinjam->user_id)
                ->where('status', 'aktif')
                ->update([
                    'status' => 'selesai',
                    'tanggal_selesai' => now(),
                ]);

            // Hapus dari tabel aktif
            $pinjam->delete();
        });

        return redirect()->back()->with('success', 'Peminjaman selesai, laptop sekarang tersedia.');
    }

    // Cari peminjaman aktif
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

    // API untuk fetch peminjaman
    public function apiIndex(Request $request)
    {
        $query = DataPeminjam::with('laptop');

        if ($request->filled('search')) {
            $query->where('nama', 'like', "%{$request->search}%")
                ->orWhere('department', 'like', "%{$request->search}%");
        }

        $perPage = $request->per_page ?? 10;
        return $query->paginate($perPage);
    }

    // API untuk selesai peminjaman
    public function apiSelesai($id)
    {
        $pinjam = DataPeminjam::findOrFail($id);

        if ($pinjam->laptop) {
            $pinjam->laptop->status = 'tersedia';
            $pinjam->laptop->save();
        }

        $pinjam->delete();

        return response()->json(['success' => true]);
    }

    public function apirIndex(Request $request)
    {
        try {
            $query = DataPeminjam::with('laptop');

            if ($request->filled('search')) {
                $query->where('nama', 'like', "%{$request->search}%")
                    ->orWhere('department', 'like', "%{$request->search}%");
            }

            $perPage = $request->per_page ?? 10;
            return $query->paginate($perPage);
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
