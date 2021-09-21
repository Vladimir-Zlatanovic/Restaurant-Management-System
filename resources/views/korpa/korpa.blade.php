@extends('pocetna')

@section('css')
    <link rel="stylesheet" href="{{ asset("/toastr/toastr.min.css") }}">
    <link rel="stylesheet" href="{{ asset('/assets/korpa/korpa.css') }}">
@endsection
@section('content')
        <div id="top">
            <div id="korpa-wrapper" class="container korpa-wrapper border rounded my-4 pt-2">
                @if($jelaIzKorpe->count()>0)
                    @include('korpa.sadrzaj_korpe')
                    <div class="container border-top mt-3">
                        <div class="row d-flex justify-content-end">
                            <div class="col-sm-6 col-md-3 py-2">
                                <a href="{{ route('korisnik.checkout.prikazi') }}" id="checkout" class="btn w-100 rounded">Poruči</a>   
                            </div>
                        </div>
                    </div>
                   
                @else
                    <p class="text-center">Korpa je prazna!</p>
                @endif
            </div>
        </div>
@endsection
@section('js')
    <script src="{{ asset('/toastr/toastr.min.js') }}"></script>
    <script>
       
        
         $(document).on('click', '.povecaj-kolicinu', function(){
                if($(this).siblings('.smanji-kolicinu').attr('disabled'))
                    $(this).siblings('.smanji-kolicinu').attr('disabled',false);
                $kolicinaPolje =$(this).siblings('form').children('input[name="kolicina"]'); 
                var novaKolicina = parseInt($kolicinaPolje.val());
                $kolicinaPolje.val(++novaKolicina);
                $(this).siblings('form').first().submit();
            });

           $(document).on('click', '.smanji-kolicinu', function(){
            $kolicinaPolje = $(this).siblings('form').children('input[name="kolicina"]'); 
                var staraKolicina = parseInt($kolicinaPolje.val());
                if(staraKolicina > 1){
                    $kolicinaPolje.val(--staraKolicina);
                    $(this).siblings('form').first().submit();
                }
                //ako je nova kolicina 1, onesposobi dugme da ne moze da se smanjuje dalje
                if(staraKolicina == 1){
                    $(this).attr('disabled',true);
                }
            });
        $(document).ready(function(){
            toastr.options.preventDuplicates = true;
            $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});
            $("#poruciForma").submit(function(event){
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                    }
                });
            });
           
           $("#korpa-wrapper").bind("ispraznjen",function(){
               if($(this).find('form.ukloni-forma').length == 0){
                    $(this).children().fadeOut('normal',function(){
                        $(this).remove();
                    });
                    $korpaPrazna = $("<p>");
                    $korpaPrazna.addClass('text-center');
                    $korpaPrazna.text('Korpa je prazna!');
                   $(this).append($korpaPrazna);
               }
           });
            $("#korpa-wrapper").on('submit', 'form.ukloni-forma', function(event){
                event.preventDefault();
                var formData = new FormData(this);
                $forma = $(this);
                $.ajax({
                    type: formData.get("_method"),
                    url: $forma.attr('action'),
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if('poruka-uspeh' in response){
                           $forma.parents('tr').first().fadeOut('normal',function(){
                                $(this).remove();
                                $("#korpa-broj").text(response['korpa-broj']);
                                $("#korpa-wrapper").trigger("ispraznjen");
                            });
                        }
                    }
                });
            });
            $("#korpa-wrapper").on('submit', 'form.azuriraj-kolicinu-forma', function(event){
                event.preventDefault();
                var formData = new FormData(this);
                $forma = $(this);
                $.ajax({
                    type: formData.get('_method'),
                    url: $forma.attr('action'),
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if('poruka-uspeh' in response){
                            $forma.siblings('span.kolicina').text(response.kolicina);
                            $forma.parents('tr').first().find('td.ukupno > span.ukupno').text(response.ukupno);
                            $("#ceo-zbir").text(response['ceo-zbir']);
                        } else {
                            toastr.error(response.greska);
                        }
                    }
                });
            });
            
        });
    </script>
@endsection