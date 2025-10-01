@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Laptop Management PLN IPS')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

{{-- CSS khusus background dashboard --}}
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
@php
  use Illuminate\Support\Facades\Auth;
  $user = Auth::user();
  $isGuest = !$user;
@endphp

<script>
    window.dashboardData = {
        user: @json($isGuest ? null : $user),
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
