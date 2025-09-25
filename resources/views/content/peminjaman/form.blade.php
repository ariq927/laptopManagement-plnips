@extends('layouts/contentNavbarLayout')

@section('title', 'Form Peminjaman')

@section('content')
<div class="card">
  <h5 class="card-header">Pinjam Laptop {{ $laptop->merek }} {{ $laptop->tipe }}</h5>
  <div class="card-body">
    <form action="{{ route('peminjaman.store') }}" method="POST">
      @csrf
      <input type="hidden" name="laptop_id" value="{{ $laptop->id }}">

      {{-- Nama pegawai --}}
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <select id="nama" name="nama" class="form-select" required>
          <option value="" disabled selected>Pilih Nama</option>
        </select>
      </div>

      {{-- Departemen otomatis --}}
      <div class="mb-3">
        <label class="form-label">Departemen</label>
        <input type="text" id="department" name="department" class="form-control" readonly>
      </div>

      {{-- Tanggal Mulai --}}
      <div class="mb-3">
        <label class="form-label">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" class="form-control" required>
      </div>

      {{-- Tanggal Selesai --}}
      <div class="mb-3">
        <label class="form-label">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control" required>
      </div>

      {{-- Nomor Telepon otomatis --}}
      <div class="mb-3">
        <label class="form-label">Nomor Telepon</label>
        <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control" readonly>
      </div>

      {{-- Tombol Simpan & Batal --}}
      <div class="d-flex justify-content-between">
        <a href="{{ route('laptop.index') }}" class="btn btn-outline-secondary">
          <i class="bx bx-arrow-back"></i> Batal
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="bx bx-save"></i> Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection



{{-- ✅ Script Fetch + Select2 --}}
@section('page-script')
<script>
$(document).ready(function () {
    const $namaSelect = $('#nama');
    const deptInput = document.getElementById('department');
    const phoneInput = document.getElementById('nomor_telepon');

    fetch('/pegawai')
        .then(response => response.json())
        .then(res => {
            console.log('Respon Pegawai:', res);
            let employees = res.data || [];

            // Masukin data ke dropdown
            employees.forEach(emp => {
                $namaSelect.append(
                    $('<option>', {
                        value: emp.employeeName,
                        text: emp.employeeName,
                        'data-dept': emp.department || '-',
                        'data-phone': emp.phone || '-'
                    })
                );
            });

            // Aktifkan Select2 setelah data masuk
            $namaSelect.select2({
                placeholder: "Pilih Nama",
                allowClear: true,
                width: '100%' // biar full lebar
            });
        })
        .catch(error => console.error('Gagal fetch data pegawai:', error));

    // Isi dept & telepon saat pilih nama
    $namaSelect.on('change', function () {
        const selected = $(this).find(':selected');
        deptInput.value = selected.data('dept');
        phoneInput.value = selected.data('phone');
    });
});
</script>
@endsection
