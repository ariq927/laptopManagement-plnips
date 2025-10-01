@php
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = $navbarDetached ?? '';
@endphp

<style>
  /* Navbar transparan dengan warna cyan */
  .layout-navbar {
    background: rgba(20, 162, 186, 0.75) !important;
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(20, 162, 186, 0.4);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  }

  /* Text di navbar jadi putih dengan shadow */
  .layout-navbar .navbar-brand-text,
  .layout-navbar .nav-item span,
  .layout-navbar .fw-bold {
    color: #fff !important;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
    font-weight: bold;
  }

  /* Dropdown menu transparan */
  .dropdown-menu {
    background: rgba(20, 162, 186, 0.95) !important;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(20, 162, 186, 0.4);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
  }

  .dropdown-item {
    color: #fff !important;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6);
    transition: all 0.2s ease;
  }

  .dropdown-item:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    transform: translateX(5px);
  }

  .dropdown-divider {
    border-color: rgba(255, 255, 255, 0.3) !important;
  }

  .dropdown-item h6,
  .dropdown-item small {
    color: #fff !important;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6);
  }

  /* Avatar border cyan */
  .avatar {
    border: 2px solid rgba(20, 162, 186, 0.6);
    box-shadow: 0 0 10px rgba(20, 162, 186, 0.4);
  }

  /* Icon di dropdown */
  .dropdown-item i {
    color: #fff !important;
  }
</style>

<!-- Navbar -->

<!-- Navbar -->
@if($navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
@else
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="{{$containerNav}}">
@endif

  @if(isset($navbarFull))
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
  <a href="{{ url('/') }}" class="app-brand-link gap-2">
    <img src="{{ asset('assets/img/logo_plnips.png') }}" alt="PLN Logo" class="app-brand-logo">
    <span class="app-brand-text demo menu-text fw-bold text-heading">PLN</span>
  </a>
</div>
@endif

  
  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

    <div class="navbar-nav align-items-center me-3">
    <div class="nav-item d-flex align-items-center">
      <!-- <img src="{{ asset('assets/img/logo_plnips.jpg') }}" alt="PLN Logo" style="height:40px; width:auto; margin-right:10px;"> -->
      <span class="fw-bold fs-5">Laptop Management</span>
    </div>
  </div>

    <!-- Search -->
    <div class="navbar-nav align-items-center">
      <div class="nav-item d-flex align-items-center">
        
      </div>
    </div>
    <!-- /Search -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <li class="nav-item lh-1 me-4">
      </li>

      <!-- User Dropdown -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
          </div>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
          @if(Auth::check())
            <li>
              <a class="dropdown-item">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle">
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-0">{{ Auth::user()->name ?? 'User' }}</h6>
                    <small class="text-muted">{{ Auth::user()->email ?? '' }}</small>
                  </div>
                </div>
              </a>
            </li>
            <li><div class="dropdown-divider my-1"></div></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item">
                  <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                </button>
              </form>
            </li>
          @else
            <li>
              <a class="dropdown-item" href="{{ route('auth-login-basic') }}">
                <i class="bx bx-log-in bx-md me-3"></i><span>Login</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('register') }}">
                <i class="bx bx-user-plus bx-md me-3"></i><span>Register</span>
              </a>
            </li>
          @endif
        </ul>
      </li>
      <!-- /User Dropdown -->
    </ul>
  </div>

  @if($navbarDetached == '')
  </div>
  @endif
</nav>
<!-- / Navbar -->
