<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- App Brand / Logo -->
  <div class="app-brand demo">
    <a href="{{ Auth::check() 
      ? (Auth::user()->role === 'admin' 
          ? route('admin.dashboard') 
          : route('dashboard-analytics')) 
      : url('/') }}"
      class="app-brand-link gap-2">
      
      <!-- Logo PLN -->
      <span class="app-brand-logo demo">
        <img src="{{ asset('assets/img/white-pln2.png') }}" alt="PLN Logo" class="app-brand-logo">
      </span>
            <!-- <span class="app-brand-text demo menu-text fw-bold text-heading">Laptop Rent</span> -->
    </a>

    <!-- Toggle menu for small screens -->
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <!-- Menu Items -->
  <ul class="menu-inner py-1">
    @foreach ($menuData[0]->menu as $menu)

      {{-- Menu Headers --}}
      @if (isset($menu->menuHeader))
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
        </li>
      @else
        @php
          $activeClass = null;
          $currentRouteName = Route::currentRouteName();

          if ($currentRouteName === $menu->slug) {
            $activeClass = 'active';
          } elseif (isset($menu->submenu)) {
            if (gettype($menu->slug) === 'array') {
              foreach($menu->slug as $slug){
                if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
                  $activeClass = 'active open';
                }
              }
            } else {
              if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
                $activeClass = 'active open';
              }
            }
          }
        @endphp

        {{-- Main Menu Item --}}
        <li class="menu-item {{$activeClass}}">
          <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
            @isset($menu->icon)
              <i class="{{ $menu->icon }}"></i>
            @endisset
            <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
            @isset($menu->badge)
              <div class="badge rounded-pill bg-{{ $menu->badge[0] }} text-uppercase ms-auto">{{ $menu->badge[1] }}</div>
            @endisset
          </a>

          {{-- Submenu --}}
          @isset($menu->submenu)
            @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
          @endisset
        </li>
      @endif

    @endforeach
  </ul>

</aside>
