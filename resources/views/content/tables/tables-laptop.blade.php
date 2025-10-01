@extends('layouts/contentNavbarLayout')


@section('title', 'Daftar Laptop')

@section('page-style')
<style>
  .layout-wrapper {
    background: url('/assets/img/backgrounds/plnn.jpg') no-repeat center center fixed !important;
    background-size: cover !important;
  }

  .layout-page,
  .content-wrapper {
    background: transparent !important;
  }
</style>
@endsection

@section('content')
@viteReactRefresh
@vite(['resources/js/app.jsx'])

<div id="laptop-table"></div>
@endsection
