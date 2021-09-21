<div class="container-fluid">
    <div class="row">
        @foreach ($svaJela as $jelo )
            <div class="col-lg-3 col-md-4 col-sm-10 offset-md-0 offset-sm-1 mb-3">
                <div class="card proizvod-kartica"> 
                    <img class="card-img-top" src="{{ asset("slike/fullsize/{$jelo->slika}")  }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="text-center ime-jela"><a href="#"><b>{{ $jelo->ime }}</b></a></h5>
                        <div class="d-flex flex-column align-items-center mt-3">
                            <div class="text-muted mb-1">{{ $jelo->cena }} RSD</div>
                            <div>
                                <button class="border rounded bg-white sign povecaj-kolicinu">
                                    <span class="fa fa-plus" id="orange"></span>
                                </button>
                                    <span class="px-sm-1 kolicina">0</span>
                                <button class="border rounded bg-white sign smanji-kolicinu">
                                    <span class="fa fa-minus" id="orange"></span>
                                </button>
                            </div>
                        </div>
                        <form class="addToCartForma" action="{{route('korisnik.korpa.dodaj',$jelo->id)}}" class="d-none" method="post">
                            @csrf
                            <input type="hidden" name="kolicina" value="0">
                        </form>
                        <button  class="btn w-100 mt-auto  rounded my-2 add-to-cart">Dodaj u korpu</button>   
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row mt-2">
        <div class="col-md-6 mx-auto d-flex justify-content-center" id="paginacija-nav-wrapper">
            {!! $svaJela->links() !!}
            
    </div>
    </div>
   <input type="hidden" name="ajax-broj-rezultata" value="{{ $svaJela->total() }}" />
</div>