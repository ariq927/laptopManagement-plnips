@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Laptop')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Data Laptop</h4>

    <form action="{{ route('laptop.update', $laptop->id) }}" method="POST">
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
            <input type="text" class="form-control" 
                value="{{ ucfirst($laptop->status) }}" readonly>
        </div>


        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('laptop.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
