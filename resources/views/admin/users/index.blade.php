@extends('layouts.app')

@section('css')
<style>
    a, a:hover {
        text-decoration: none;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (session()->has('poruka-uspeh-brisanje'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Korisnik je uspesno obrisan!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card-header">{{ __('Korisnici') }}</div>
                @if(!empty($users))
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ime</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Akcije</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $user )
                          <tr>
                             <th scope="row">{{ $user->id }}</th>
                             <td>{{ $user->name }}</td>
                             <td>{{ $user->email }}</td>
                             <td>{{implode(', ', $user->roles()->pluck('ime')->toArray())  }}</td>
                             <td>
                                <a href="{{ route('admin.users.edit', ['user' => $user]) }}" 
                                    class="btn btn-primary float-left mr-1"
                                >
                                    Izmeni
                                </a>
                                @if(auth()->user()->id !== $user->id)
                                    <form action="{{ route('admin.users.destroy', ['user' => $user]) }}" method="post"
                                        class="float-left"
                                    >
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Obrisi</button>
                                    </form>
                                @endif
                             </td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
