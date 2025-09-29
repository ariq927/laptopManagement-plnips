@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Laptop')

@section('content')
@viteReactRefresh
@vite(['resources/js/app.jsx'])

<div id="laptop-table"></div>
@endsection
