@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Peminjam Laptop')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <form action="{{ route('cari.nama') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari nama, departemen..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <form action="{{ route('tables.basic') }}" method="GET">
        <label for="per_page" class="form-label me-2">Tampilkan:</label>
        <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
            <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ ($perPage ?? 10) == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ ($perPage ?? 10) == 20 ? 'selected' : '' }}>20</option>
        </select>
        <input type="hidden" name="search" value="{{ request('search') }}">
    </form>
  </div>

<div class="card">
  <h5 class="card-header">Daftar Peminjam Laptop</h5>

  {{-- Kalau belum login --}}
  @if(!Auth::check())
    <div class="text-center p-4">
      <p>Silakan login untuk melihat daftar peminjam laptop.</p>
      <a href="{{ route('auth-login-basic') }}" class="btn btn-primary">Login</a>
    </div>
  @else

      <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>No Telepon</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Selesai</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($peminjams as $peminjam)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $peminjam->nama }}</td>
            <td>{{ $peminjam->department }}</td>
            <td>{{ $peminjam->nomor_telepon }}</td>
            <td>{{ $peminjam->tanggal_mulai }}</td>
            <td>{{ $peminjam->tanggal_selesai }}</td>
            <td>
              <form action="{{ route('peminjaman.selesai', $peminjam->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyelesaikan peminjaman ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-success">Selesai</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center">Belum ada data peminjam</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
