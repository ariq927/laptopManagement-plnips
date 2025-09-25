@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Laptop')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Search & Per Page Filter -->
<div class="d-flex justify-content-between mb-3">
    <!-- Form Pencarian -->
    <form action="{{ route('laptop.index') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari laptop..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <!-- Form Jumlah Item Per Halaman -->
    <form action="{{ route('laptop.index') }}" method="GET">
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
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Laptop</h5>
        <a href="{{ route('laptop.create') }}" class="btn btn-custom">
            <i class="bi bi-plus-lg"></i> Tambah Laptop
        </a>

    </div>          
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th class="text-center" style="width: 60px;">No</th>
                    <th>Merek</th>
                    <th>Tipe</th>
                    <th>Spesifikasi</th>
                    <th>Nomor Seri</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laptops as $laptop)
                    <tr>
                        <td class="text-center">
                            {{ ($laptops->currentPage() - 1) * $laptops->perPage() + $loop->iteration }}
                        </td>
                        <td>{{ $laptop->merek }}</td>
                        <td>{{ $laptop->tipe }}</td>
                        <td>{{ $laptop->spesifikasi }}</td>
                        <td>{{ $laptop->serial_number }}</td>
                       <td>
    @if(Auth::check())
        @if($laptop->status === 'diarsip')
            <button type="button" class="btn btn-sm btn-secondary" disabled>
                <i class="bx bx-archive"></i> Diarsip
            </button>

            <form action="{{ route('laptop.restore', $laptop->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Kembalikan laptop ini?')">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="bx bx-undo"></i> Kembalikan
                </button>
            </form>
        @elseif($laptop->status === 'dipinjam')
            <button type="button" class="btn btn-sm btn-secondary" disabled>
                <i class="bx bx-lock"></i> Dipinjam
            </button>
        @else
            <form action="{{ route('peminjaman.create', $laptop->id) }}" method="GET" style="display:inline-block;">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bx bx-cart"></i> Pinjam
                </button>
            </form>
        @endif

      <a href="{{ route('laptop.edit', $laptop->id) }}" class="btn btn-sm btn-edit">
        <i class="bx bx-edit"></i> Edit
    </a>

        @if($laptop->status !== 'diarsip')
            <form action="{{ route('laptop.archive', $laptop->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Arsipkan laptop ini?')">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="bx bx-archive-in"></i> Arsip
                </button>
            </form>
        @endif
    @else
        <a href="{{ route('auth-login-basic') }}" class="btn btn-sm btn-outline-primary">
            <i class="bx bx-log-in"></i> Login untuk meminjam
        </a>
    @endif
</td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data laptop</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3 px-3 d-flex justify-content-center">
        {{ $laptops->links() }}
    </div>
</div>

@endsection
