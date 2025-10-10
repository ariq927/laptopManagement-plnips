<!DOCTYPE html>
<html
  class="light-style layout-menu-fixed"
  data-theme="theme-default"
  data-assets-path="{{ asset('/assets') . '/' }}"
  data-base-url="{{ url('/') }}"
  data-framework="laravel"
  data-template="vertical-menu-laravel-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title')</title>

  <meta name="description" content="{{ config('variables.templateDescription') ?? '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ?? '' }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="canonical" href="{{ config('variables.productPage') ?? '' }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/plnfavicon.ico') }}" />

  <script>
    window.activeMenu = "{{ Route::currentRouteName() }}";
  </script>

  {{-- ============================ --}}
  {{-- 🧩 Vite Assets & Theme --}}
  {{-- ============================ --}}
  @viteReactRefresh
  @vite([
    'resources/assets/vendor/scss/theme-default.scss',
    'resources/js/app.jsx',
  ])

  {{-- Default styles include --}}
  @include('layouts/sections/styles')

  {{-- CSS tambahan dari child layout/page --}}
  @stack('styles')

  {{-- Script helper Sneat --}}
  @include('layouts/sections/scriptsIncludes')

  {{-- ✅ CSS khusus untuk sidebar React --}}
  <style>
    #react-sidebar {
      width: 0px; /* Lebar sidebar */
      flex-shrink: 0;
      background: #ffffff;
      border-right: 1px solid #e0e0e0;
      min-height: 100vh;
    }

    main {
      flex-grow: 1;
      min-width: 0;
      background-color: #f9fafb;
    }

    body {
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
  </style>
</head>

<body data-active-menu="{{ request()->path() }}">
  <div class="d-flex">
    {{-- Sidebar React --}}
    <div id="react-sidebar"></div>

    {{-- Konten utama --}}
    <main>
      @yield('layoutContent')
    </main>
  </div>

  {{-- Default scripts --}}
  @include('layouts/sections/scripts')

  {{-- Script tambahan dari page --}}
  @stack('scripts')
</body>
</html>
