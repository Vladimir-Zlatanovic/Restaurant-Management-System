@extends('admin.dashboard.panel')

 @section('css')
<link rel="stylesheet" href="{{ asset("/datatable/css/dataTables.bootstrap.min.css") }}">
<link rel="stylesheet" href="{{ asset("/datatable/css/dataTables.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ asset("/sweetalert2/sweetalert2.min.css") }}">
<link rel="stylesheet" href="{{ asset("/toastr/toastr.min.css") }}">

@endsection 
@section('content')

@if(session('poruka-uspeh-brisanje'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="uspeh-brisanje-alert">
        <strong>{{ session('poruka-uspeh-brisanje') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<table id="tabela-korisnici" class="table table-dark text-light">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Id Korisnika</th>
        <th scope="col">Ime</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
        <th scope="col">Akcije</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user )
          <tr>
             <td></td>
             <td>{{ $user->id }}</td>
             <td>{{ $user->name }}</td>
             <td>{{ $user->email }}</td>
             <td>{{implode(', ', $user->roles()->pluck('ime')->toArray())  }}</td>
             <td>
                @if(auth()->user()->id !== $user->id)
                    <a href="{{ route('admin.users.edit', $user) }}" 
                        class="btn btn-primary float-left mr-1"
                    >
                        Izmeni
                    </a>
                    
                    <a 
                        href="{{ route('admin.users.destroy', ['user' => $user]) }}"class="obrisi btn btn-danger float-left mr-1"
                        data-toggle="modal" data-target="#obrisiKorisnikaModal"
                    >
                        Obrisi
                    </a>
                @endif                  
             </td>
          </tr>
      @endforeach
    </tbody>
  </table>

  <div class="modal fade" id="obrisiKorisnikaModal" tabindex="-1"
    aria-labelledby="obrisiKorisnikaLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="obrisiKorisnikaLabel">Obrisi korisnika</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p>
                Da li ste sigurni da zelite da obrisete korisnika?
                Ova akcija ne moze biti ponistena!
            </p>
            <form action="" method="post" class="d-none">
                @method('DELETE')
                @csrf      
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Odustani</button>
          <button type="button" id="obrisiKorisnikaButton" class="btn btn-danger" data-dismiss="modal">Obrisi</button>
        </div>
      </div>
    </div>
  </div>

  

@endsection

@section('js')
  <script src="{{ asset('/js/jquery/jquery 3.6.0.js') }}"></script>
 <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('/datatable/js/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('/sweetalert2/sweetalert2.min.js') }}"></script>
 <script src="{{ asset('toastr/toastr.min.js') }}"></script>
 <script>
   toastr.options.preventDuplicates = true;
   $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
   
 </script>
 <script>
      $("#tabela-korisnici").DataTable({
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
        },
        lengthMenu : [5,10,15,20]
      });

      $(document).ready(function () {
          $("a.obrisi").click(function(event){
              event.preventDefault();
              $("#obrisiKorisnikaModal form").first().attr('action', $(this).attr('href'));
          });
          $("#obrisiKorisnikaModal form").submit(function(event){
              event.preventDefault();
              var forma = $(this);
              var formData = new FormData(this);
             
              $.ajax({
                type: 'delete',
                url: forma.attr('action'),
                data: formData,
                processData : false,
                contentType : false,
                success: function (response) {
                  console.log(response);
                  $("div.alert").remove();
                  var alertBrisanje = 
                  `<div class="alert alert-success alert-dismissible fade show"
                    role="alert" id="uspeh-brisanje-alert"
                  >
                      <strong>${response.porukaUspeh}</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>`
                  $("table").first().before(alertBrisanje);
                  console.log("a[href =" + forma.attr('action') +"]");
                  $("a[href='" + forma.attr('action') + "']").closest("tr").remove();
                     
                  
                   
                }
              });
          });
          $("#obrisiKorisnikaButton").click(function(){
            $("#obrisiKorisnikaModal form").first().submit();
              
              


          });
      });
  </script>
@endsection