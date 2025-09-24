<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\LaptopData;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isGuest = !$user;

        // Total & tersedia laptop
        $totalLaptop = LaptopData::count();
        $tersedia = LaptopData::where('status', 'tersedia')->count();

        // Laptop yang dipinjam user
        $pinjamanUser = collect();
        if ($user) {
            $pinjamanUser = Peminjaman::with('laptop')
                ->where('user_id', $user->username) // pakai username LDAP
                ->get();
        }

        return view('content.dashboard.dashboards-analytics', compact(
            'user',
            'isGuest',
            'totalLaptop',
            'tersedia',
            'pinjamanUser'
        ));
    }
}
