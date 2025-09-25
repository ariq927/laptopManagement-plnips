@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Laptop Management PLN IPS')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
@php
  use Illuminate\Support\Facades\Auth;
  $user = Auth::user();
  $isGuest = !$user;
@endphp

<div class="row">
  <!-- GREETING CARD -->
  <div class="col-12 mb-6">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-7">
          <div class="card-body">
            <h3 class="card-title text-primary mb-3">
              Hi, {{ $isGuest ? 'Guest' : ($user->name ?? 'User') }}! 🎉
            </h3>
            <p>Departemen: {{ $isGuest ? '-' : ($user->department ?? '-') }}</p>
            <p>Email: {{ $isGuest ? '-' : ($user->email ?? '-') }}</p>
            <p class="mb-6">Kelola peminjaman dan pengembalian laptop dengan mudah.</p>

            @if(!$isGuest)
              <a href="{{ route('laptop.index') }}" class="btn btn-sm btn-outline-primary me-2">Pinjam Sekarang</a>
              {{-- Tombol tambah laptop --}}
              <a href="{{ route('laptop.create') }}" class="btn btn-sm btn-outline-success">Tambah Laptop</a>
            @else
              <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Login untuk Pinjam</a>
            @endif
          </div>
        </div>

        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-6">
            <img src="{{ asset('assets/img/illustrations/man-with-laptop.png') }}" height="175" class="scaleX-n1-rtl" alt="View Badge User">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- TOTAL LAPTOP & TERSEDIA -->
 <div class="col-12 mb-6">
  <div class="row justify-content-center">
    <div class="col-lg-4 col-md-6 mb-6">
      <div class="card h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
          <p class="mb-1">Total Laptop</p>
          <h4 class="card-title mb-0">{{ $totalLaptop ?? 0 }}</h4>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-6">
      <div class="card h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
          <p class="mb-1">Tersedia</p>
          <h4 class="card-title mb-0">{{ $tersedia ?? 0 }}</h4>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-6">
      <div class="card h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
          <p class="mb-1">Diarsip</p>
          <h4 class="card-title mb-0">{{ $diarsip ?? 0 }}</h4>
        </div>
      </div>
    </div>
  </div>
</div>


  <!-- LAPTOP YANG DIPINJAM -->
  <!-- @if(!$isGuest)
    <div class="col-12 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title mb-3">Laptop yang Dipinjam</h5>

          @php
            $pinjamanUser = $user->peminjams ?? collect();
          @endphp

          @forelse ($pinjamanUser as $pinjam)
            <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
              <div>
                <strong>{{ $pinjam->laptop->merek ?? '-' }} {{ $pinjam->laptop->tipe ?? '-' }}</strong><br>
                <small>Mulai: {{ $pinjam->tanggal_mulai }} | Selesai: {{ $pinjam->tanggal_selesai }}</small>
              </div>
              <form action="{{ route('peminjaman.selesai', $pinjam->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Selesai</button>
              </form>
            </div>
          @empty
            <p class="text-muted">Tidak ada laptop yang sedang dipinjam.</p>
          @endforelse
        </div>
      </div>
    </div>
  @endif -->
</div>
@endsection
