@extends('layouts/contentNavbarLayout')

@section('content')
<h2>Laporan Peminjaman Laptop</h2>

<form action="{{ route('laporan.export') }}" method="get">
    <input type="text" name="department" placeholder="Department">
    <input type="text" name="status" placeholder="Status">
    <input type="date" name="from" placeholder="Dari tanggal">
    <input type="date" name="to" placeholder="Sampai tanggal">

    <select name="format">
        <option value="excel">Excel</option>
        <option value="pdf">PDF</option>
    </select>

    <button type="submit">Generate Laporan</button>
</form>
@endsection
