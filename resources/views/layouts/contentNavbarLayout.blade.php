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

  {{-- 🌗 Dark/Light Mode Styles --}}
  <style>
    :root {
      --bg-color: #ffffff;
      --text-color: #222222;
    }

    [data-theme='dark'] {
      --bg-color: #121212;
      --text-color: #f5f5f5;
    }

    body {
      background-color: var(--bg-color) !important;
      color: var(--text-color) !important;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
  </style>

  <script>
  (function () {
    // -- STEP 1: ambil preferensi dari localStorage, default 'light'
    const savedTheme = localStorage.getItem('theme') || 'light';
    const html = document.documentElement;

    // -- STEP 2: terapkan langsung ke <html> sebelum page render
    html.setAttribute('data-theme', savedTheme);

    // -- STEP 3: saat halaman sudah siap, sinkronkan toggle & event listener
    window.addEventListener('DOMContentLoaded', () => {
      const checkbox = document.getElementById('theme-toggle-checkbox');
      if (!checkbox) return;

      // pastikan toggle status sesuai tema aktif
      checkbox.checked = html.getAttribute('data-theme') === 'dark';

      // pas toggle diklik
      checkbox.addEventListener('change', (e) => {
        const newTheme = e.target.checked ? 'dark' : 'light';
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
      });

      // --- tambahan penting: pastikan semua class dark dihapus kalau light ---
      if (savedTheme === 'light') {
        html.removeAttribute('data-theme');
        html.setAttribute('data-theme', 'light');
      }
    });
  })();
</script>

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
