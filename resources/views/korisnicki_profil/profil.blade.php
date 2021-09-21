@extends('pocetna')
@section('css')

<link rel="stylesheet" href="{{ asset("/toastr/toastr.min.css") }}">
<link rel="stylesheet" href="{{ asset("/datatable/css/dataTables.bootstrap4.min.css") }}">
<link rel="stylesheet" href="{{ asset('/assets/profil/css/profil.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/profil/css/porudzbine.css') }}">
@endsection
@section('content')
    <div id="top">
        <div id="profil-wrapper"class="container my-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="podaci-tab" data-toggle="tab" href="#podaci" role="tab" aria-controls="podaci" aria-selected="true">Podaci</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="porudzbine-tab" data-toggle="tab" href="#porudzbine" role="tab" aria-controls="porudzbine" aria-selected="false">Porudzbine</a>
                </li>
            </ul>
            <div class="tab-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active mb-4" id="podaci" role="tabpanel" aria-labelledby="podaci-tab">
                    <h3 class="text-center">Vaši podaci</h3>
                    <form id="podaci-forma" action="{{ route('korisnik.profil.izmeni_podatke') }}"
                          method="post" class="my-4" novalidate
                    >
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="form-group col">
                                <label for="ime">Ime</label>
                                <input type="text" readonly  class="form-control-plaintext" name="name" id="ime" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group col">
                                <label for="email">Email adresa</label>
                                <input type="email" readonly  class="form-control-plaintext" name="email" id="email" value="{{ auth()->user()->email }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="telefon">Telefon</label>
                                <input type="text" readonly class="form-control-plaintext" name="telefon" id="telefon" value="{{ auth()->user()->telefon ?? '-'}}">
                            </div>
                            <div class="form-group col">
                                <label for="kreiran">Nalog kreiran</label>
                                <input type="text" readonly  class="form-control-plaintext" name="kreiran" id="kreiran" value={{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('d.m.Y.')  }}>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="password">Lozinka</label>
                                <input type="password" readonly class="form-control-plaintext" name="password" id="password" value="{{ md5(rand()) }}">
                            </div>
                            <div class="form-group col">
                                <div id="confirm-password-wrapper" class="d-none">
                                    <label for="confirm-password">Potvrdi lozinku</label>
                                    <input type="password" readonly  class="form-control-plaintext" name="password_confirmation" id="confirm-password" value="{{ md5(rand()) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="button-wrapper"class="col-md-7 mx-auto d-flex justify-content-center">
                                <button type="button" id="izmeni-button" class="btn px-3 py-2 btn-primary rounded">
                                   <span>Izmeni<i class="fa fa-pencil ml-1" aria-hidden="true"></i></span>
                                </button>
                            </div>                           
                        </div>
                    </form>

                </div>
                <div class="tab-pane container-fluid fade" id="porudzbine" role="tabpanel" aria-labelledby="porudzbine-tab">
                        <h3 class="text-center">Vaše porudžbine</h3>
                        <div class="table-responsive mt-4 container-fluid 
                                d-flex justify-content-center border rounded py-3"
                        >
                            <table id="porudzbine-datatable" class="table table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Broj porudzbine</th>
                                        <th scope="col">Adresa</th>
                                        <th scope="col">Telefon</th>
                                        <th scope="col">Iznos</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Poslata</th>
                                    </tr>
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
<script src="{{ asset('/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/datatable/js/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/profil/js/izmeni_podatke.js') }}"></script>
<script>
    let tabela = $("#porudzbine-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('korisnik.profil.get_porudzbine') }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {
                data: 'id', 
                name: 'id',
                render: function(data,type,row){
                    return data;
                }
            },
            {data: 'adresa', name: 'adresa'},
            {data: 'telefon', name: 'telefon'},
            {data: 'iznos', name: 'iznos'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'poslata'}
        ],
        lengthMenu : [5,10,15,20]
    });
</script>
@endsection