<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
      <a href="" class="sidebar-brand brand-logo text-light">Naruci.com</a>
      <a class="sidebar-brand brand-logo-mini text-light" href="{{ route('pocetna') }}">N</a>
    </div>
    <ul class="nav">
      <li class="nav-item profile">
        <div class="profile-desc">
          <div class="profile-pic">
            <div class="count-indicator">
              <img class="img-xs rounded-circle " src="{{ asset('/admin/assets/images/faces/face15.jpg') }}" alt="">
              <span class="count bg-success"></span>
            </div>
            <div class="profile-name">
              <h5 class="mb-0 font-weight-normal">{{ auth()->user()->name }}</h5>
              <span>Admin</span>
            </div>
          </div>
        </div>
      </li>
      <li class="nav-item nav-category">
        <span class="nav-link">Navigacija</span>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-account"></i>
          </span>
          <span class="menu-title">Korisnici</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="">
          <span class="menu-icon">
            <i class="mdi mdi-calendar"></i>
          </span>
          <span class="menu-title">Rezervacije</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{ route('pocetna') }}">
          <span class="menu-icon">
            <i class="mdi mdi-home"></i>
          </span>
          <span class="menu-title">Pocetna</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" data-toggle="collapse" href="#jelovnik" aria-expanded="false" aria-controls="auth">
          <span class="menu-icon">
             <i class="mdi mdi-food"></i>
             
          </span>
          <span class="menu-title">Jelovnik</span>
          <i class="menu-arrow"></i>
          
        </a>
        <div class="collapse" id="jelovnik">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('admin.jelovnik.index') }}"> Prikazi Jelovnik</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('admin.jelovnik.create') }}">Dodaj Novo jelo</a></li>
            
          </ul>
        </div>
      </li>
    </ul>
  </nav>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
       
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown">
            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
              <div class="navbar-profile">
                <img class="img-xs rounded-circle" src="{{ asset('/admin/assets/images/faces/face15.jpg') }}" alt="">
                <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ auth()->user()->name }}</p>
                <i class="mdi mdi-menu-down d-none d-sm-block"></i>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
              <h6 class="p-3 mb-0">Profil</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item" id="logout-link" href="{{ route('logout') }}">
                <form action="{{ route('logout') }}" id="logout-form" class="d-none" method="post">
                  @csrf
                </form>
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-dark rounded-circle">
                    <i class="mdi mdi-logout text-danger"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="preview-subject mb-1">Log out</p>
                </div>
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-format-line-spacing"></span>
        </button>
      </div>
    </nav>
    <script>
      document.getElementById('logout-link').addEventListener('click',function(event){
          event.preventDefault();
          document.getElementById('logout-form').submit();
      });
    </script>