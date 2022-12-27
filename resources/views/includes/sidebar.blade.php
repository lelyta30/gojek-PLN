<div class="sidebar" id="sidebar" data-color="" data-image="{{ asset('assets/img/sidebar-5.jpg')}}">
  <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
  <div class="sidebar-wrapper">
      <div class="logo">
          <a href="#" class="simple-text">
              IKET <small>(IT Ticketing)</small>
          </a>
      </div>
      <ul class="nav">

          @if (Auth::user()->role == 'USER')
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.dashboard') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item {{ request()->is('request') ? 'active' : '' }}">
              <a class="nav-link " href="{{ route('user.request') }}">
                  <i class="nc-icon nc-bullet-list-67"></i>
                  <p>List Request</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{ route('user.request.daftarpekerja') }}">
                  <i class="nc-icon nc-bullet-list-67"></i>
                  <p>List Pekerja</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{ route('user.profile') }}">
                  <i class="nc-icon nc-fav-remove"></i>
                  <p>Profil</p>
              </a>
            </li>  
          @endif
          
          @if (Auth::user()->role == 'TECHNICIAN')
            <li class="nav-item {{ request()->is('t') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('technician.dashboard') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <hr>

            <li class="nav-item">
              <a class="nav-link " href="{{ route('technician.profile') }}">
                  <i class="nc-icon nc-fav-remove"></i>
                  <p>Profil</p>
              </a>
            </li>
          @endif

          @if (Auth::user()->role == 'DRIVER')
            <li class="nav-item {{ request()->is('d') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('driver.dashboard') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <hr>

            <li class="nav-item">
              <a class="nav-link " href="{{ route('driver.profile') }}">
                  <i class="nc-icon nc-fav-remove"></i>
                  <p>Profil</p>
              </a>
            </li>
          @endif

          @if (Auth::user()->role == 'CLEANING')
            <li class="nav-item {{ request()->is('cl') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('cleaning.dashboard') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <hr>

            <li class="nav-item">
              <a class="nav-link " href="{{ route('cleaning.profile') }}">
                  <i class="nc-icon nc-fav-remove"></i>
                  <p>Profil</p>
              </a>
            </li>
          @endif

          @if (Auth::user()->role == 'SECURITY')
          <li class="nav-item {{ request()->is('sc') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('security.dashboard') }}">
                  <i class="nc-icon nc-chart-pie-35"></i>
                  <p>Dashboard</p>
              </a>
          </li>
          <hr>

          <li class="nav-item">
            <a class="nav-link " href="{{ route('security.profile') }}">
                <i class="nc-icon nc-fav-remove"></i>
                <p>Profil</p>
            </a>
          </li>
        @endif
          

          @if (Auth::user()->role == 'MANAGER')
            <li class="nav-item {{ request()->is('m') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('manager.dashboard') }}">
                  <i class="nc-icon nc-chart-pie-35"></i>
                  <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item {{ request()->is('m/verified-request') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('manager.verified-request') }}">
                  <i class="nc-icon nc-check-2"></i>
                  <p>Daftar Permintaan</p>
              </a>
            </li>

            <li class="nav-item {{ request()->is('m/technician') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('technician.index') }}">
                  <i class="nc-icon nc-circle-09"></i>
                  <p>List User</p>
              </a>
            </li>
          @endif

      </ul>
  </div>
  <div class="sidebar-background" style="background-image: url('{{ asset('assets/img/sidebar-5.jpg')}}') "></div>
</div>
