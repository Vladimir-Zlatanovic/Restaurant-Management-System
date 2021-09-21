@extends('admin.dashboard.panel')
@section('css')
<link rel="stylesheet" href="{{ asset("/datatable/css/dataTables.bootstrap.min.css") }}">
<link rel="stylesheet" href="{{ asset("/datatable/css/dataTables.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ asset("/sweetalert2/sweetalert2.min.css") }}">
<link rel="stylesheet" href="{{ asset("/toastr/toastr.min.css") }}">
<style>
  option {
    font-size: 1.2rem;
  }
  
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mt-3">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header">
                Jelovnik
            </div>
            <div class="card-body" id="tabela-wrapper">
                  <table class="table table-hover table-condensed" id="jelovnik-tabela">
                    <thead>
                      <th>#</th>
                      <th>Naziv</th>
                      <th>Cena</th>
                      <th>Slika</th>
                      <th>Potkategorija</th>
                      <th>Dodato</th>
                      <th>Ažurirano</th>
                    </thead>
                    <tbody>

                    </tbody>

                  </table>
            </div>
          </div>
      </div>
      
    </div>
  </div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
 <script src="{{ asset('/datatable/js/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('/sweetalert2/sweetalert2.min.js') }}"></script>
 <script src="{{ asset('/toastr/toastr.min.js') }}"></script>
 <script>
   toastr.options.preventDuplicates = true;
   $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
    });
   $("#jelovnik-tabela").DataTable({
        processing : true,
        info : true,
        ajax : "{{ route('admin.prikazi.jela.ajax') }}",
        columns: [
          {data: 'id', name: 'id'},
          {data: 'ime', name: 'naziv'},
          {data: 'cena', name: 'cena'},
          {
            data: 'slika',
            name: 'slika',
            searchable: false,
            orderable: false,
            render: function(data,type,row,meta){
              let url = '{{asset("/storage/slike/fullsize/") }}' + '/' + data;
              return `<img src="${url}">`;
            }
          },
          {data: 'potKategorija', name: 'potKategorija.ime'},
          {data: 'kreirano', name: 'created_at'},
          {data: 'azurirano', name: 'updated_at'},
          
        ],
        lengthMenu : [5,10,15,20]
   });

 </script>

@endsection
