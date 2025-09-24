@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Laptop')

@section('content')
<div class="card">
  <h5 class="card-header">Tambah Laptop Baru</h5>
  <div class="card-body">
    <form action="{{ route('laptop.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Merek</label>
        <input type="text" name="merek" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Tipe</label>
        <input type="text" name="tipe" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Spesifikasi</label>
        <textarea name="spesifikasi" class="form-control" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Nomor Seri</label>
        <input type="text" name="serial_number" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <option value="tersedia">Tersedia</option>
          <option value="dipinjam">Dipinjam</option>
          <option value="maintenance">Maintenance</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
