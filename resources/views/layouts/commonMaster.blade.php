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

  <title>@yield('title') </title>
  <meta name="description" content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/plnfavicon.ico') }}" />

  <!-- Include default styles -->
  @include('layouts/sections/styles')

  {{-- ✅ Tempat inject CSS tambahan dari child layout/page --}}
  @stack('styles')

  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts/sections/scriptsIncludes')
</head>

<body>
  <!-- Layout Content -->
  @yield('layoutContent')
  <!--/ Layout Content -->

  <!-- Include default scripts -->
  @include('layouts/sections/scripts')

  {{-- ✅ Tempat inject JS tambahan dari child layout/page --}}
  @stack('scripts')
</body>
</html>
