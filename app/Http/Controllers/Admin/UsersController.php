<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategorija;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Gate as AccessGate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
           
           
                Gate::authorize('view-admin-dashboard');
                $users = User::with('roles')->get();
              
                return view('admin.dashboard.prikazi_korisnike', compact('users'));
                             
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Gate::allows('update',[$user])){
        
            $roles = Role::all();
            return view('admin.users.edit',compact('user','roles'));
        }
        return abort(403,'YOU SHALL NOT PASS!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update',$user);
        $user->roles()->sync($request->roles);
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Request $request)
    {   
        
        Gate::authorize('delete',$user);
        $user->roles()->detach();
        $user->delete();
        if($request->ajax()){
            return response()->json(['porukaUspeh' => 'Korisnik je obrisan!' ]);
        }
        return back()->with('poruka-uspeh-brisanje','Korisnik je obrisan!');
    }
}
