@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Peminjam Laptop')

{{-- CSS khusus background halaman daftar peminjam --}}
@section('page-style')
<style>
  .layout-wrapper {
    background: url('/assets/img/backgrounds/plnn.jpg') no-repeat center center fixed !important;
    background-size: cover !important;
  }

  .layout-page,
  .content-wrapper {
    background: transparent !important;
  }
</style>
@endsection

@section('content')
  @if(!Auth::check())
    <div class="card" style="background: rgba(255, 255, 255, 0.95);">
      <div class="text-center p-4">
        <p>Silakan login untuk melihat daftar peminjam laptop.</p>
        <a href="{{ route('auth-login-basic') }}" class="btn btn-primary">Login</a>
      </div>
    </div>
  @else
    <div id="react-peminjam-table"
         data-search="{{ request('search') }}"
         data-per-page="{{ $perPage ?? 10 }}">
    </div>
  @endif
@endsection

@push('scripts')
    @viteReactRefresh
    @vite('resources/js/app.jsx')
@endpush
