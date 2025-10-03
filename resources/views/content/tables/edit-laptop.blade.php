@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Laptop')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Data Laptop</h4>

    <form action="{{ route('laptop.update', $laptop->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

        <div class="mb-3">
            <label class="form-label">Merek</label>
            <input type="text" class="form-control" name="merek" value="{{ $laptop->merek }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipe</label>
            <input type="text" class="form-control" name="tipe" value="{{ $laptop->tipe }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Spesifikasi</label>
            <textarea class="form-control" name="spesifikasi">{{ $laptop->spesifikasi }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Serial Number</label>
            <input type="text" class="form-control" name="serial_number" value="{{ $laptop->serial_number }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <input type="text" class="form-control" value="{{ ucfirst($laptop->status) }}" readonly>
        </div>

        {{-- Tampilkan foto laptop --}}
<div class="mb-3">
    <label class="form-label">Foto Laptop</label><br>

        <div class="card shadow-sm p-2 border border-2" style="width: 400px; height: 400px;">
            @if($laptop->foto)
                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                    <img src="{{ $laptop->foto }}" 
                        class="img-fluid" 
                        style="max-height: 100%; max-width: 100%; object-fit: contain;">
                </div>
                <div class="card-body p-3">
                    <input type="checkbox" name="hapus_foto" value="1"> Hapus foto
                </div>
            @else
            <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                <img src="{{ asset('images/nophoto.png') }}" 
                     style="height: 50px; width: 50px; object-fit: contain; opacity: 0.3;">
            </div>
            <div class="card-body text-center text-muted p-2">
                <small>Tidak ada foto</small>
            </div>
        @endif
    </div>
</div>


    <input type="file" class="form-control mt-3" name="foto">
    <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
</div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('laptop.index') }}" class="btn btn-secondary">Kembali</a>
</form>
</div>
@endsection
