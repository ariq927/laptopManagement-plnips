<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaptopData;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaptopsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\HistoriPeminjaman;

class ReportController extends Controller
{
    public function export(Request $request)
{
    $filters = $request->only(['department', 'status', 'from', 'to', 'format']);
    $query = HistoriPeminjaman::query();

    if($filters['department'] ?? false) {
        $query->where('department', $filters['department']);
    }
    if($filters['status'] ?? false) {
        $query->where('status', $filters['status']);
    }
    if($filters['from'] ?? false) {
        $query->whereDate('tanggal_mulai', '>=', $filters['from']);
    }
    if($filters['to'] ?? false) {
        $query->whereDate('tanggal_selesai', '<=', $filters['to']);
    }

    $peminjaman = $query->get();

    if(($filters['format'] ?? '') === 'pdf') {
        dd($peminjaman);
        $pdf = Pdf::loadView('content.reports.laptops_pdf', ['laptops' => $peminjaman]);
        return $pdf->stream('laporan_peminjaman.pdf');
    } else {
        return Excel::download(new LaptopsExport($peminjaman), 'laporan_peminjaman.xlsx');
    }
    }

    public function previewPDF(Request $request)
{
    $filters = $request->only(['department', 'status', 'from', 'to']);
    $query = HistoriPeminjaman::query();

    if($filters['department'] ?? false) $query->where('department', $filters['department']);
    if($filters['status'] ?? false) $query->where('status', $filters['status']);
    if($filters['from'] ?? false) $query->whereDate('tanggal_mulai', '>=', $filters['from']);
    if($filters['to'] ?? false) $query->whereDate('tanggal_selesai', '<=', $filters['to']);

    $peminjaman = $query->get();

    $pdf = Pdf::loadView('content.reports.laptops_pdf', ['laptops' => $peminjaman]);

    return $pdf->stream('laporan_peminjaman.pdf'); // langsung stream ke browser
}

}
