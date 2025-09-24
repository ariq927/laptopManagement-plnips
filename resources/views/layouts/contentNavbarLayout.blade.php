@extends('layouts/commonMaster')

@php
  $contentNavbar = $contentNavbar ?? true;
  $containerNav = $containerNav ?? 'container-xxl';
  $isNavbar = $isNavbar ?? true;
  $isMenu = $isMenu ?? true;
  $isFlex = $isFlex ?? false;
  $isFooter = $isFooter ?? true;
  $navbarDetached = 'navbar-detached';
  $container = $container ?? 'container-xxl';
@endphp


@section('layoutContent')
<div class="layout-wrapper layout-content-navbar {{ $isMenu ? '' : 'layout-without-menu' }}">
  <div class="layout-container">

    @if ($isMenu)
      @include('layouts/sections/menu/verticalMenu')
    @endif

    <!-- Layout page -->
    <div class="layout-page">
      @if ($isNavbar)
        @include('layouts/sections/navbar/navbar')
      @endif

      <div class="content-wrapper">
        <div class="{{ $container }} flex-grow-1 container-p-y">
          @yield('content')
        </div>

        @if ($isFooter)
          @include('layouts/sections/footer/footer')
        @endif
      </div>
    </div>
  </div>

  @if ($isMenu)
    <div class="layout-overlay layout-menu-toggle"></div>
  @endif
  <div class="drag-target"></div>
</div>
@endsection

{{-- ✅ Taruh asset library di luar layoutContent --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@yield('page-script')
@endpush
