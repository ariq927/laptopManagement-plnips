<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\LaptopData;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isGuest = !$user;

        // Total & tersedia laptop
        $totalLaptop = LaptopData::count();
        $tersedia = LaptopData::where('status', 'tersedia')->count();
        $diarsip = LaptopData::where('status', 'diarsip')->count();

        // Laptop yang dipinjam user (hanya jika user login)
        $pinjamanUser = collect();
        if ($user) {
            $pinjamanUser = Peminjaman::with('laptop')
                ->where('user_id', $user->username) // pakai username LDAP
                ->get();
        }

        // Ambil jumlah laptop per merek
        $laptopStats = LaptopData::select('merek', DB::raw('COUNT(*) as total'))
            ->groupBy('merek')
            ->orderByDesc('total')
            ->get();

        return view('content.dashboard.dashboards-analytics', [
            'user' => $user,
            'isGuest' => $isGuest,
            'totalLaptop' => $totalLaptop,
            'tersedia' => $tersedia,
            'diarsip' => $diarsip,
            'pinjamanUser' => $pinjamanUser,
            'laptopStats' => $laptopStats, // <-- kirim ke Blade
        ]);
    }
}
