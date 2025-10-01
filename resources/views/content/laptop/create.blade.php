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
        <input type="text" class="form-control" value="Tersedia" readonly>
        <input type="hidden" name="status" value="tersedia">
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/tables/laptop" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection