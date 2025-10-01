<!DOCTYPE html>
<html class="light-style layout-menu-fixed"
  data-theme="theme-default"
  data-assets-path="{{ asset('/assets') . '/' }}"
  data-base-url="{{ url('/') }}"
  data-framework="laravel"
  data-template="vertical-menu-laravel-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title')</title>
  <meta name="description" content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/plnfavicon.ico') }}" />

  <script>
  window.activeMenu = "{{ Route::currentRouteName() }}";
  </script>

  
  {{-- Theme utama --}}
  @vite(['resources/assets/vendor/scss/theme-default.scss'])

  {{-- Include default styles --}}
  @include('layouts/sections/styles')

  {{-- ✅ Tempat inject CSS tambahan dari child layout/page --}}
  @stack('styles')

  {{-- Script helper Sneat --}}
  @include('layouts/sections/scriptsIncludes')

  {{-- ✅ Tambahin CSS khusus sidebar React --}}
  <style>
    #react-sidebar {
      width: 0px;       /* Lebar fix sidebar */
      flex-shrink: 0;     /* Biar sidebar ga mengecil */
      background: #ffffff; /* Default background */
      border-right: 1px solid #e0e0e0;
      min-height: 100vh; /* Full tinggi layar */
    }
    main {
      flex-grow: 1;
      min-width: 0; /* Supaya konten fleksibel */
    }
  </style>
</head>

<body data-active-menu="{{ request()->path() }}">
  <div class="d-flex">
    {{-- ✅ Sidebar akan di-render dengan React --}}
    <div id="react-sidebar"></div>

    
    {{-- ✅ Konten utama tiap halaman --}}
    <main>
      @yield('layoutContent')
    </main>
  </div>

  {{-- Include default scripts --}}
  @include('layouts/sections/scripts')

  {{-- ✅ Tempat inject JS tambahan dari child layout/page --}}
  @stack('scripts')
</body>
</html>
