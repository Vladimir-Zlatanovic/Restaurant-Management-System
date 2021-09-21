<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   if(!Auth::check()){
            abort(401, 'Morate da se ulogujete da bi pristupili ovoj stranici');
        }
        $korisnik = User::find(Auth::user()->id);
        if($korisnik->hasRole('admin')){
            return $next($request);
        }
        abort(403,'Morate biti admin da bi pristupili ovoj stranici');
                
        
    }
}
