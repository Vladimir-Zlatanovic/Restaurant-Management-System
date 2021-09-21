@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Izmeni korisnika {{ $user->name }} ({{ $user->email }})</div>

                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="post">
                        @method('PUT')
                        @csrf
                        @foreach ( $roles as $role )
                            <div class="form-check">
                                <input type="checkbox" name="roles[]" id="roles" value={{$role->id}}
                                 @if ($user->hasRole($role->ime))
                                     checked
                                 @endif>
                                <label for="">{{ $role->ime;  }}</label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">{{ __('Izmeni') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
