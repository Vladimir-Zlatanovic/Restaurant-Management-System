<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title>{{ config('app.name', 'Laravel') }}</title>
<!--
    
TemplateMo 558 Klassy Cafe

https://templatemo.com/tm-558-klassy-cafe

-->
    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{asset("/assets/pocetna/css/bootstrap.min.css")}}">

    <link rel="stylesheet" type="text/css" href="{{asset("/assets/pocetna/css/font-awesome.css")}}">

    <link rel="stylesheet" href="{{asset("/assets/pocetna/css/templatemo-klassy-cafe.css")}}">

    <link rel="stylesheet" href="{{asset("/assets/pocetna/css/owl-carousel.css")}}">

    <link rel="stylesheet" href="{{asset("/assets/pocetna/css/lightbox.css")}}">

    <!-- CSS stranica koje nasledjuju ovu -->
    @section('css')

    @show

    </head>
    
    <body>
    
    
    
    
    

    <!-- ***** Header Area Start ***** -->
    @section('header')
        @includeIf('header')
    @show
    <!-- ***** Header Area End ***** -->

    <!-- Modal koji iskoci kad hoces da obrises nalog -->
    @auth
    <div class="modal fade" id="obrisiNalogModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Brisanje naloga</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p>
                    Da li ste sigurni da zelite da obrisete nalog? Ova akcija ne moze biti ponistena!
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
              <a id="obrisi-korisnika-triger" class="btn btn-danger">Obrisi nalog</a>
            </div>
          </div>
        </div>
    </div>
    @endauth

    <!-- ***** Main Banner Area Start ***** -->
    @section('content')
        <div id="top">
            @if(session('porudzbina-kreirana'))
                <div class=" w-50 ml-auto alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('porudzbina-kreirana') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="left-content">
                            <div class="inner-content">
                                <h4>Naruči.com</h4>
                                <h6>Najbolje iskustvo</h6>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="main-banner header-text">
                            <div class="Modern-Slider">
                            <!-- Item -->
                            <div class="item">
                                <div class="img-fill">
                                    <img src="{{ asset('/assets/pocetna/images/slide-01.jpg') }}" alt="">
                                </div>
                            </div>
                            <!-- // Item -->
                            <!-- Item -->
                            <div class="item">
                                <div class="img-fill">
                                    <img src="{{ asset('/assets/pocetna/images/slide-02.jpg') }}" alt="">
                                </div>
                            </div>
                            <!-- // Item -->
                            <!-- Item -->
                            <div class="item">
                                <div class="img-fill">
                                    <img src="{{ asset('/assets/pocetna/images/slide-03.jpg') }}" alt="">
                                </div>
                            </div>
                            <!-- // Item -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ***** Main Banner Area End ***** -->

        <!-- ***** About Area Starts ***** -->
        <section class="section" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 mx-auto">
                        <div class="left-text-content">
                            <div class="section-heading">
                                <h2>O nama</h2>
                                <p>Naručite svoju omiljenu hranu iz naše široke ponude</p>
                            </div>
                    
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- ***** About Area Ends ***** -->

        <!-- ***** Menu Area Starts ***** -->
         <section class="section" id="menu">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="section-heading">
                            <h6>Naš meni</h6>
                            <h2>Naš izbor jela i pića</h2>
                            <h4><a href="{{ route('pretraga') }}">Pogledajte ceo izbor</a></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-item-carousel">
                <div class="col-lg-12">
                    <div class="owl-menu-item owl-carousel">
                        <div class="item">
                            <div class='card card1'>
                                <div class="price"><h6>$14</h6></div>
                                <div class='info'>
                                <h1 class='title'>Chocolate Cake</h1>
                                <p class='description'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sedii do eiusmod teme.</p>
                                <div class="main-text-button">
                                    <div class="scroll-to-section"><a href="#reservation">Make Reservation <i class="fa fa-angle-down"></i></a></div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class='card card2'>
                                <div class="price"><h6>$22</h6></div>
                                <div class='info'>
                                <h1 class='title'>Klassy Pancake</h1>
                                <p class='description'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sedii do eiusmod teme.</p>
                                <div class="main-text-button">
                                    <div class="scroll-to-section"><a href="#reservation">Make Reservation <i class="fa fa-angle-down"></i></a></div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class='card card3'>
                                <div class="price"><h6>$18</h6></div>
                                <div class='info'>
                                <h1 class='title'>Tall Klassy Bread</h1>
                                <p class='description'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sedii do eiusmod teme.</p>
                                <div class="main-text-button">
                                    <div class="scroll-to-section"><a href="#reservation">Make Reservation <i class="fa fa-angle-down"></i></a></div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class='card card4'>
                                <div class="price"><h6>$10</h6></div>
                                <div class='info'>
                                <h1 class='title'>Blueberry CheeseCake</h1>
                                <p class='description'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sedii do eiusmod teme.</p>
                                <div class="main-text-button">
                                    <div class="scroll-to-section"><a href="#reservation">Make Reservation <i class="fa fa-angle-down"></i></a></div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class='card card5'>
                                <div class="price"><h6>$8.50</h6></div>
                                <div class='info'>
                                <h1 class='title'>Klassy Cup Cake</h1>
                                <p class='description'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sedii do eiusmod teme.</p>
                                <div class="main-text-button">
                                    <div class="scroll-to-section"><a href="#reservation">Make Reservation <i class="fa fa-angle-down"></i></a></div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class='card card3'>
                                <div class="price"><h6>$7.25</h6></div>
                                <div class='info'>
                                <h1 class='title'>Klassic Cake</h1>
                                <p class='description'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sedii do eiusmod teme.</p>
                                <div class="main-text-button">
                                    <div class="scroll-to-section"><a href="#reservation">Make Reservation <i class="fa fa-angle-down"></i></a></div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       
    @show
    @section('footer')
        @include('footer')
    @show
    

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous">
    </script>
    
    <!-- Bootstrap -->
    <script src="{{ asset('/assets/pocetna/js/popper.js') }}"></script>
    <script src="{{ asset('/assets/pocetna/js/bootstrap.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset("/assets/pocetna/js/owl-carousel.js") }}"></script>
    <script src="{{ asset("/assets/pocetna/js/accordions.js") }}"></script>
    <script src="{{ asset("/assets/pocetna/js/datepicker.js") }}"></script>
    <script src="{{ asset("/assets/pocetna/js/scrollreveal.min.js") }}"></script>
    <script src="{{ asset("/assets/pocetna/js/waypoints.min.js") }}"></script>
    <script src="{{ asset("/assets/pocetna/js/jquery.counterup.min.js") }}"></script>
    <script src="{{ asset("/assets/pocetna/js/imgfix.min.js") }}"></script> 
    <script src="{{ asset("/assets/pocetna/js/slick.js") }}"></script> 
    <script src="{{ asset("/assets/pocetna/js/lightbox.js") }}"></script> 
    <script src="{{ asset("/assets/pocetna/js/isotope.js") }}"></script> 
    
    <!-- Global Init -->
    <script src="{{ asset("/assets/pocetna/js/custom.js") }}"></script>
    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);
                
            });
        });
        $(document).ready( function(){
            $('#logout-link').click(function(event){
                event.preventDefault();
                $("#logout-form").submit();
            });
            $("#obrisi-korisnika-triger").click(function (event){
                    event.preventDefault();
                    $("#deleteUserForma").submit();
            });

        });

    </script>
    <!-- js stranica koje nasledjuju ovu -->
    @section('js')
    @show
  </body>
</html>