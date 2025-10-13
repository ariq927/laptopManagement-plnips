@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Laptop Management PLN IPS')

@section('vendor-style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.css">
@endsection

@section('vendor-script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0"></script>
@endsection

@section('page-style')
<style>
  .layout-wrapper {
    background: url('/assets/img/backgrounds/bg2.jpg') no-repeat center center fixed !important;
    background-size: cover !important;
  }
  .layout-page,
  .content-wrapper {
    background: transparent !important;
  }
</style>
@endsection

@section('content')
<script>
  window.dashboardData = {
    user: @json($user),
    totalLaptop: {{ $totalLaptop ?? 0 }},
    tersedia: {{ $tersedia ?? 0 }},
    diarsip: {{ $diarsip ?? 0 }},
    laptopStats: @json($laptopStats),
    isGuest: {{ $isGuest ? 'true' : 'false' }}
  };
</script>

<div id="react-dashboard"></div>

@viteReactRefresh
@vite('resources/js/app.jsx')
@endsection
