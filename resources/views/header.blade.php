



<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="" class="logo">
                        <img src="{{ asset('/assets/pocetna/images/klassy-logo.png') }}" alt="klassy cafe html template">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li class="scroll-to-section"><a href="{{ route('pocetna') }}#top" class="active">Pocetna</a></li>
                        <li class="scroll-to-section"><a href="{{ route('pocetna') }}#about">O nama</a></li>
                        <li class="scroll-to-section"><a href="{{ route('pocetna') }}#menu">Jelovnik</a></li>
                        @guest
                            @if(Route::has('login'))
                                <li><a href="{{ route('login') }}">Login</a></li>
                            @endif
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}">Registracija</a></li>
                            @endif
                            
                        @endguest

                        @auth
                        <li class="submenu">
                            <a href=""><span>{{ Auth::user()->name }}&nbsp;<i class="fa fa-user" aria-hidden="true"></i></span></a>
                            <ul>
                                @can('view-admin-dashboard')
                                    <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                @endcan
                                <li>
                                   <a href="{{ route('korisnik.profil.prikazi') }}">Moj Profil</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" id="logout-link">
                                         Logout           
                                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                             @csrf
                                         </form>
                                    </a>
                                </li>
                                <li>
                                    <a href="" data-toggle="modal" data-target="#obrisiNalogModal">
                                         Obrisi nalog
                                    </a>
                                 </li>
                            </ul>
                            
        
                        </li>
                        <li><a href="{{ route('korisnik.korpa.prikazi') }}"><span><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;Korpa (<span id="korpa-broj">{{ \Gloudemans\Shoppingcart\Facades\Cart::content()->count() }}</span>)</span></a></li>
                        @endauth
                        
                    </ul>        
                    <a class='menu-trigger'>
                        <span>Meni</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>