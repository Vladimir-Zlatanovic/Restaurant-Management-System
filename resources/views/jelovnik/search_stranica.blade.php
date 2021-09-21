@extends('pocetna')

@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/search stranica/style.css') }}">
    
    <link rel="stylesheet" href="{{ asset("/toastr/toastr.min.css") }}">
@endsection

@section('content')
    <div id="top" class="border-bottom pb-3">
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-6 offset-md-3 text-center">
                    <form action="{{ route('pretraga') }}" id="searchForma" method="get">
                        <input type="search" class=" form-control rounded d-inline-block w-75 mr-1"
                               id="pretraga" name="pretraga" placeholder="Pretražite naš jelovnik..."
                        >
                        <a href="" id="pretraga-dugme">
                            <span class="fa fa-search text-muted"></span>
                        </a>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3 mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="ml-3 mb-2">
                    <button id="filter-button" class="btn btn-default" type="button" data-toggle="collapse" data-target="#mobile-filter"
                            aria-expanded="true" aria-controls="mobile-filter"
                    >
                       <h3 class="d-inline-block mr-2">Filteri</h3><span class="fa fa-filter pl-1"></span>
                    </button>
                </div>
                <div id="mobile-filter">
                    <div class="card">
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" data-toggle="collapse" data-target="#kategorija-filter" data-abc="true" aria-expanded="false" class="collapsed">
                                    <span class="arrow-down"><i class="icon-control fa fa-chevron-down"></i></span> 
                                    <h6 class="title">Kategorije </h6>
                                </a> </header>
                            <div class="filter-content collapse" id="kategorija-filter">
                                <div class="card-body">
                                    <ul class="list-menu">
                                        @foreach($kategorije as $kategorija)
                                        <li>
                                            <div class="form-group">
                                                <input  form = "searchForma" type="checkbox" id="{{ $kategorija->slug }}" name="kategorija[]" value="{{ $kategorija->id }}">
                                                <label  for="{{ $kategorija->slug }}">{{ $kategorija->ime }}</label>
                                            </div>
                                        </li>
                                        @endforeach
                                        
                                    </ul>
                                </div>
                            </div>
                        </article>
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" data-toggle="collapse" data-target="#potKategorija-filter" data-abc="true" aria-expanded="false" class="collapsed">
                                     <span class="arrow-down"><i class="icon-control fa fa-chevron-down"></i></span>
                                    <h6 class="title">Potkategorije</h6>
                                </a> </header>
                            <div class="filter-content collapse" id="potKategorija-filter">
                                <div class="card-body">
                                    <ul class="list-menu">
                                        @foreach($kategorije as $kategorija)
                                        <li>
                                            <p class="font-weight-bold mt-3 mb-1 border-bottom">{{ $kategorija->ime }}</p>
                                            @foreach ($kategorija->potKategorije as $potKategorija)
                                                
                                           
                                            <div class="form-group">
                                                <input  form = "searchForma" type="checkbox" id="{{ $potKategorija->slug }}"
                                                    data-kategorija="{{ $kategorija->id }}" name="potKategorija[]" value="{{ $potKategorija->id }}"
                                                 >
                                                <label  for="{{ $potKategorija->slug }}">{{ $potKategorija->ime }}</label>
                                            </div>
                                            @endforeach
                                        </li>
                                        @endforeach
                                        
                                    </ul>
                                </div>
                            </div>
                        </article>
                        
                        
                        
                        
                    </div>
                    
                    
                </div>
                
                
            </div>
            <div class="col">
                <section id="products">
                    <div class="container">
                        <div class="d-flex flex-row align-items-center mb-2">
                            <div class="text-muted m-2" id="res">
                                @if($svaJela->count() !== 0)
                                    Ukupno {{$svaJela->total()  }} rezultata.
                                @else
                                    Nema rezultata.
                                @endif
                            </div>
                            <div class="ml-auto mr-lg-4">
                                <div class="border rounded px-3 py-2 m-1" id="sort-cena-wrapper">
                                        <label for="sort-cena" clas>Cena:</label>                                        
                                            <select form="searchForma" class="select-sort" name="sort-cena" id="sort-cena">
                                                <option value="asc"><b>Rastuca</b></option>
                                                <option value="desc"><b>Opadajuca</b></option>
                                            </select> 
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row my-2 d-flex mr-2 align-items-stretch py-3 rounded" id="rezultati-wrapper">
                            @if(count($svaJela) > 0)
                                @include('jelovnik.paginacija')
                            @endif
                        </div>
                       
                            
                           
                            
                    </div>
                    
                </section>
            </div>
        </div>
       
    </div>



@endsection

@section('js')

    
    <script src="{{ asset('/toastr/toastr.min.js') }}"></script>
    <script>
        toastr.options.preventDuplicates = true;
        $(document).ready(function () {
            
            $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});

            $(document).on('click', '.povecaj-kolicinu', function(){
                $kolicinaSpan = $(this).siblings('span.kolicina').first();
                var novaKolicina = parseInt($kolicinaSpan.text());
                ++novaKolicina;
                $kolicinaSpan.text(novaKolicina);
                $kolicinaHidden = $(this).parents('div.card-body').find('form > input[type="hidden"][name="kolicina"]');
                $kolicinaHidden.val(novaKolicina);
            });

           $(document).on('click', '.smanji-kolicinu', function(){
                $kolicinaSpan = $(this).siblings('span.kolicina').first();
                var novaKolicina = parseInt($kolicinaSpan.text());
                --novaKolicina;
                if(novaKolicina >= 0){
                    $kolicinaSpan.text(novaKolicina);
                    $kolicinaHidden = $(this).parents('div.card-body').find('form > input[type="hidden"][name="kolicina"]');
                    $kolicinaHidden.val(novaKolicina);
                    
                }
            });
           $potKategorije = $("input[type='checkbox'][name='potKategorija[]']");
           $potKategorije.prop('disabled',true);
           $potKategorije.siblings('label').addClass('text-muted');

            $("input[type='checkbox'][name='kategorija[]']").change(function(){
                $kategorija = $(this);
                $potKategorije = $("input[type='checkbox'][name='potKategorija[]']").filter(function(){
                    return $(this).data('kategorija') == $kategorija.val();
                });
                $potKategorije.siblings('label').toggleClass('text-muted');
                $potKategorije.prop('checked',$(this).prop('checked'));
                $potKategorije.prop("disabled",!$(this).prop('checked'));
                
                
            });
            $searchForma = $("#searchForma");
            $searchForma.submit(function(event){
               event.preventDefault();
               pretrazi(this);
           });

           $("input[name='kategorija[]'],input[name='potKategorija[]'],select[name='sort-cena']")
            .change(function(){
                    pretrazi($searchForma[0]);
            });

           //funkcija koja salje xHr zahtev za pretragu
           //ovu funkciju koriste sva polja unutar forme
            function pretrazi(forma){
                var formData = new FormData(forma);
               var queryStr = "?";
               for(var par of formData.entries()){
                   queryStr += par[0] + '=' +par[1] + '&';
               }
               var urlParametri = new URLSearchParams(window.location.search);
               queryStr += "page=" + urlParametri.get('page');
               var url = $(forma).attr('action') + queryStr;
               $.ajax({
                   type: $(forma).attr('method'),
                   url: url,
                   success: function (response) {
                      
                        $("#rezultati-wrapper").html(response);
                        var brojRezultata = parseInt($("input[name='ajax-broj-rezultata']").first().val());
                        var text = "";
                        if(brojRezultata > 0)
                            text = `Ukupno ${brojRezultata} rezultata.`;
                        else
                            text = "Nema rezultata.";
                        $("#res").text(text);

                    },
                    error: function(response){
                            toastr.error('Došlo je do greške');
                    }
               });
            }
           $('#pretraga-dugme').click(function(event){
                event.preventDefault();
                $searchForma.submit();
            });

          $(document).on('click', 'button.add-to-cart', function(){
               $ovoDugme = $(this);
               $forma = $(this).siblings('form').first();
               var formData = new FormData($forma[0]);
                $.ajax({
                    type: $forma.attr('method'),
                    url: $forma.attr('action'),
                    dataType: "json",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#korpa-broj").text(response['korpa-broj']);
                        if('kolicina-promenjena' in response){
                            var poruka = `${response.kolicina} "${response.jelo}" je dodato u korpu!`;
                            toastr.success(poruka);
                        }
                        $ovoDugme.parents('div.card-body').first().find('span.kolicina').text('0');
                        $ovoDugme.siblings('form.addToCartForma').find("input[type='hidden'][name='kolicina']").val(0);
                    }
                });
           });
           $(document).on('click', "ul.pagination a.page-link", function(e){
               e.preventDefault();
               var formData = new FormData($searchForma[0]);
               var queryStr = "?";
               for(var par of formData.entries()){
                   queryStr += par[0] + '=' +par[1] + '&';
               }
               var page = $(this).attr('href').split('page=')[1];
               queryStr += "page=" + page;
               var url = $searchForma.attr('action') + queryStr;
              
                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "html",
                    success: function (response) {
                        $("#rezultati-wrapper").html(response);
                    },
                    error: function(response){
                            toastr.error('Došlo je do greške');
                    }
                });
            }); 
               
           
        });
    </script>
@endsection
