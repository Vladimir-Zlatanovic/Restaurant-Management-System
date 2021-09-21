<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Slika</th>
                <th scope="col">Ime</th>
                <th scope="col">Potkategorija</th>
                <th scope="col">Kategorija</th>
                <th scope="col">Cena</th>
                <th scope="col">Količina</th>
                <th scope="col">Ukupno</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jelaIzKorpe as $jelo )
                <tr>
                    <td>
                        <img src="{{ asset("slike/fullsize/{$jelo->slika}")  }}" alt="{{ $jelo->ime }}">
                    </td>
                    <td>
                        {{ $jelo->ime }}
                    </td>
                    <td>
                        {{ $jelo->potKategorija->ime }}
                    </td>
                    <td>
                        {{ $jelo->potKategorija->kategorija->ime }}
                    </td>
                    <td class="cena">
                        {{ $jelo->cena }}
                    </td>
                    <td>
                        @if(Route::current()->getName() === 'korisnik.korpa.prikazi')
                            <button class="border rounded bg-white sign povecaj-kolicinu">
                                <span class="fa fa-plus"></span>
                            </button>
                            <span class="px-sm-1 kolicina">{{ $cart[$jelo->id][0]->qty}}</span>
                            <button class="border rounded bg-white sign smanji-kolicinu">
                                <span class="fa fa-minus"></span>
                            </button>
                            <form 
                                class="azuriraj-kolicinu-forma"
                                action="{{ route('korisnik.korpa.azuriraj_kolicinu', $jelo->id) }}" method="post"
                            >   
                                @csrf
                                @method('post')
                                <input type="hidden" name="kolicina" value="{{ $cart[$jelo->id][0]->qty}}">
                            </form>
                        @else
                            <span class="px-sm-1 kolicina">{{ $cart[$jelo->id][0]->qty}}</span>
                        @endif
                    </td>
                    <td class='ukupno'>
                        <span class="ukupno">
                            {{ $jelo->cena * $cart[$jelo->id][0]->qty}}
                        </span>
                        @if(Route::current()->getName() === 'korisnik.korpa.prikazi')
                            <form action="{{ route('korisnik.korpa.ukloni',$jelo->id) }}" method='post'
                                class="ukloni-forma"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="close ukloni">
                                    <span>&times;</span>
                                </button>
                            </form>
                        @endif
                       
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-end py-2 mr-1 mt-3 border-bottom">
 <p class="mr-3"><b>Ukupno:</b><span id="ceo-zbir" class="ml-2">{{ Cart::subtotal() }}</span></p>
</div>
