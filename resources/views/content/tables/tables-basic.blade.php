@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Peminjam Laptop')

@section('content')

<div class="card">
  <h5 class="card-header">Daftar Peminjam Laptop</h5>

  @if(!Auth::check())
    <div class="text-center p-4">
      <p>Silakan login untuk melihat daftar peminjam laptop.</p>
      <a href="{{ route('auth-login-basic') }}" class="btn btn-primary">Login</a>
    </div>
  @else
    <div id="react-peminjam-table"
         data-search="{{ request('search') }}"
         data-per-page="{{ $perPage ?? 10 }}">
    </div>
  @endif
</div>

@endsection

@push('scripts')
    @vite('resources/js/components/PeminjamTable.jsx')
@endpush
