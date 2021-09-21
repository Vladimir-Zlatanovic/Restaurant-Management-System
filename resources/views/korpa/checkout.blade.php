@extends('pocetna')

@section('css')
<link rel="stylesheet" href="{{ asset("/assets/korpa/checkout.css") }}">
@endsection


@section('content')
<div id="top">
    <div id="korpa-wrapper" class="container korpa-wrapper border rounded my-4 pt-2">
            @include('korpa.sadrzaj_korpe')
            <div id="potvrdi-porudzbinu-wrapper" class="container my-3 py-3 px-2">
                <form id="poruciForma" action="{{ route('korisnik.checkout.poruci') }}#poruciForma" method="post">
                    @csrf
                    <div class="row d-flex justify-content-center">
                        
                            <div class="col-md-5 pb-0">
                                <div class="h-100 d-flex flex-column">
                                    <div class="mb-2">
                                        <label for="telefon">Broj telefona</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">+381</div>
                                            </div>
                                            <input type="text" class="form-control @error('telefon') is-invalid @enderror"
                                             name="telefon"
                                             value="{{ old('telefon') ? old('telefon') : (auth()->user()->telefon ? substr(auth()->user()->telefon, 3) : '')}}" 
                                             id="telefon">
                                             @error('telefon')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                       
                                    <button id="checkout" type="submit" class="btn rounded">
                                            Potvrdi kupovinu
                                    </button>
                                </div>
                                
                            </div>
                            <div class="col-md-7">
                                <label for="adresa">Adresa</label>
                                <textarea class="form-control @error('adresa') is-invalid @enderror" name="adresa" id="adresa"
                                          cols="10" rows="4" value="{{ old('adresa') }}"
                                 ></textarea>
                                @error('adresa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                    </div>
                </form>
            </div>
    </div>
</div>
@endsection

@section('js')

@endsection