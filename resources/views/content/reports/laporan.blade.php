@extends('layouts/contentNavbarLayout')

@section('title', 'Laporan Peminjaman Laptop')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0" style="color: #fff;">📄 Laporan Peminjaman Laptop</h5>
        </div>

        <div class="card-body">
            @if(session('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bx bx-info-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('laporan.export') }}" method="get" class="row g-4 mt-4">
                <div class="col-md-6">
                    <label for="department" class="form-label fw-semibold">Department</label>
                    <input type="text" name="department" id="department" class="form-control py-2" placeholder="Masukkan nama departemen">
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select name="status" id="status" class="form-select py-2">
                        <option value="">Semua</option>
                        <option value="aktif">Aktif</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="from" class="form-label fw-semibold">Dari Tanggal</label>
                    <input type="date" name="from" id="from" class="form-control py-2">
                </div>

                <div class="col-md-6">
                    <label for="to" class="form-label fw-semibold">Sampai Tanggal</label>
                    <input type="date" name="to" id="to" class="form-control py-2">
                </div>

                <div class="col-md-6">
                    <label for="format" class="form-label fw-semibold">Format Laporan</label>
                    <select name="format" id="format" class="form-select py-2">
                        <option value="excel">Excel (.xlsx)</option>
                        <option value="pdf">PDF (.pdf)</option>
                    </select>
                </div>

                <div class="col-md-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="bx bx-download"></i> Generate Laporan
                    </button>
                    <button type="reset" class="btn btn-outline-secondary ms-2 px-4 py-2">
                        <i class="bx bx-reset"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
