@extends('admin.dashboard.panel')
@section('css')
<link rel="stylesheet" href="{{ asset("/sweetalert2/sweetalert2.min.css") }}">
<link rel="stylesheet" href="{{ asset("/toastr/toastr.min.css") }}">
<link rel="stylesheet" href="{{ asset("/admin/assets/dodaj_jelo/css/dodaj_jelo.css") }}">
@endsection


@section('content')
    <div class="container w-75">
       <h3 class="text-center mb-4">Dodajte novu stavku u meni</h3>
       <form action="{{ route('admin.jelovnik.store') }}"  method="post" 
             enctype="multipart/form-data" id="dodaj-jelo-forma" novalidate
       >
            <div class="form-row justify-content-between  gx-1 mb-3">
                <div class="col-md-6 h-100 d-flex flex-column">
                    <div class="slika-wrapper mb-3 ml-1">
                            
                    </div>
                    
                </div>
               
                <div class="col-md-6 h-100 d-flex flex-column justify-content-center">
                    <div class="form-group">
                        <label for="ime">Naziv:</label>
                        <input type="text" name="ime" id="ime" class="form-control text-light">
                        <p class="invalid-feedback ime-error"></p>
                    </div>
                    <div class="form-group ml-0">
                          <label for="cena">Cena:</label>
                          <input type="number" name="cena" id="cena" class="form-control text-light"
                           min="0" max="999999.99" step="1"
                          >
                           <p class="invalid-feedback cena-error"></p>
                    </div>
                    <div class="form-group">
                        <label for="kategorija">Izaberite kategoriju</label>
                        <select class="form-control text-light" name="kategorija" id="kategorija">
                          <optgroup>
                            <option value="" selected></option>
                            @foreach ($kategorije as $kategorija )
                              <option  value="{{ $kategorija->id }}">
                               
                                    {{ $kategorija->ime }}
                              </option>
                            @endforeach
                          </optgroup>
                        </select>
                        <p class="invalid-feedback kategorija-error"></p>
                    </div>
                        <div class="form-group">
                            <label for="potKategorija">Izaberite potkategoriju</label>
                            <select class="form-control text-light" name="potKategorija" id="potKategorija">
                                <optgroup>
                                    <option value="" selected></option>
                                    @isset($potKategorije)
                                        @foreach ($potKategorije as $potKategorija )
                                        <option  value="{{ $potKategorija->id }}">{{ $potKategorija->ime }}</option>
                                        @endforeach
                                    @endisset
                                </optgroup>
                            </select>
                            <p class="invalid-feedback potKategorija-error"></p>
                        </div>
                    
                      <div class="form-row align-items-end justify-content-between">
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success w-100 py-2 px-1">Dodaj</button>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="slika">Slika</label>
                                <input type="file" accept=".png, .jpg, .jpeg" class="form-control-file" name="slika" id="slika">
                                <p class="invalid-feedback slika-error"></p>
                            </div>
                      </div>
                    </div>
                    
            </div>
            <div class="row px-0 d-flex ">
               <div class="col">
                    <label for="opis">Opis</label>
                    <textarea name="opis" id="opis" class="w-100" rows="5" placeholder="Dodajte opis..."></textarea>
                    <p class="invalid-feedback opis-error"></p>
               </div>
            </div>
            
       </form>
    </div>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script src="{{ asset('/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/toastr/toastr.min.js') }}"></script>
<script>
     toastr.options.preventDuplicates = true;
   $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              
   $("#dodaj-jelo-forma").submit(function(event){
      event.preventDefault();
      var forma = this;
      $.ajax({
          url: $(forma).attr('action'),
          method: $(forma).attr('method'),
          data: new FormData(forma),
          processData: false,
          dataType: 'json',
          contentType: false,
          beforeSend: function(){
            $(forma).find(".invalid-feedback").text('');
            $(forma).find(".is-invalid").removeClass('is-invalid');
            
          },
          success: function(response){
              
              if('errors' in response){
                $.each(response.errors, function(prefix, val){
                    $(forma).find(".invalid-feedback." + prefix +"-error").text(val[0]);
                
                    $(forma).find("[name='"+prefix+"']").addClass('is-invalid');
                });
                if('error' in response){
                    toastr.error(response['error']);
                }
              } else {
                $(".slika-wrapper").first().empty();
                $(forma)[0].reset();
                toastr.success(response.message);
              }
          }

      });

   });
   $("[name='slika']").change(function(event){
        
            if(this.files[0] != undefined){
            
            $slikaWrapper = $(".slika-wrapper").first();
            $slika = null;
            if($slikaWrapper.children("img").length !== 0){
                    $slika = $slikaWrapper.children("img").first();
                    
            } else {
                $slika = $(new Image());
                
                $slikaWrapper.append($slika);
            }

            $slika.attr('src',URL.createObjectURL(this.files[0]));
            } else {

                if($slikaWrapper.children('img').length !== 0){
                    $slikaWrapper.empty();
                }
            }
      

   });

   $("select[name='kategorija']").change(function(){
        $select = $(this);
        $potKategorijeSelect = $("select[name='potKategorija']");
        var url = '{{ route("admin.prikazi.potkategorije.ajax",":kategorija") }}';
        url = url.replace(":kategorija",$select.val());
      $.ajax({
          type: "get",
          url: url,
          data: {kategorija : $select.val()},
          dataType: "json",
          contentType : false,
          processData : false,
          beforeSend: function(){
            $potKategorijeSelect.find('optgroup').html('');
          },
          success: function (response) {
             $.each(response['potKategorije'], function (indexInArray, potKategorija) { 
                  $opcija = $("<option>");
                  $opcija.val(potKategorija['id']);
                  $opcija.text(potKategorija['ime']);
                  $potKategorijeSelect.find('optgroup').append($opcija);
             });
          }
      });
   })
 </script>
@endsection