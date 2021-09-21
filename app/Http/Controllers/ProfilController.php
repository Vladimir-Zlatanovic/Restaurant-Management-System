<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProfilController extends Controller
{
    public function index(){
       
        return view('korisnicki_profil.profil');
    }
    public function izmeniPodatke(Request $request){
        $pravilaTelefon = ['bail','nullable','string'];
        if($request->has('telefon') && !empty($request->input('telefon'))){
            
            $pravilaTelefon = array_merge($pravilaTelefon,['min:8','max:17','regex:/^\d+$/']);
        }
        $pravila = [
            'name' => ['bail', 'nullable', 'filled','string', 'string', 'max:255'],
            'email' => ['bail', 'nullable', 'filled', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['bail', 'nullable', 'filled', 'string', 'min:8','max:255', 'confirmed'],
            'telefon' => $pravilaTelefon,
            
        ];
        $poruke = [
            'name.string' =>':attribute koje ste uneli nije validno.',
            'name.max' => ':attribute moze sadrzati najvise :max karaktera.',
            'name.min' => ':attribute mora da sadrzi bar :min karakter.',
            'email.string' => ':attribute koju ste uneli nije validna.',
            'email.min' => ':attribute mora da sadrzi bar :min karakter.',
            'email.email' => ':attribute koju ste uneli nije validna.',
            'email.max' => ':attribute moze sadrzati najvise :max karaktera',
            'email.unique' => 'Vec postoji korisnik sa ovom email adresom, molimo vas izaberite neku drugu.',
            'password.string' => ':attribute koju ste uneli nije validna.',
            'password.min' => ':attribute mora da sadrzi bar :min karaktera.',
            'password.max' => ':attribute moze sadrzati najvise :max karaktera',
            'password.confirmed' => ':attribute i polje potvrdi lozinku se ne poklapaju.',
            'telefon.string' => ':attribute koji ste uneli nije validan',
            'telefon.min' => ':attribute mora da sadrzi bar :min cifara',
            'telefon.max' => ':attribute moze sadrzati najvise :max cifara',
            'telefon.regex' => ":attribute moze da sadrzi iskljucivo cifre",
            'filled' => "Polje :attribute ne moze biti prazno."

        ];
        $imena_atributa = [
            'name' => 'Ime',
            'email' => 'Email adresa',
            'password' => 'Lozinka',
            'telefon' => 'Broj telefona',
        ];
        $validator = Validator::make($request->all(),$pravila,$poruke,$imena_atributa);
        $validator->validate();
        //ako su polja prosla validaciju, izmeni podatke korisnika
        $validiranInput = $validator->validated();
        if(array_key_exists('password',$validiranInput)){
            $validiranInput['password']  = Hash::make($validiranInput['password']);
        }
        if(array_key_exists('telefon',$validiranInput) && !empty($validiranInput['telefon'])){
            $validiranInput['telefon'] = "381" . $validiranInput['telefon'];
        }
        
        $user = User::find(auth()->user()->id);
        $user->update($validiranInput);
        $noviPodaci = collect($validiranInput)->except('password');
        return response()->json([
            'poruka-uspeh' => 'Podaci su izmenjeni!',
            'novi-podaci' => $noviPodaci->all(),
        ]);
        
    }
    public function getPorudzbine(Request $request){
        if($request->ajax()){
            $porudzbine = Order::where('user_id',auth()->user()->id)
                            ->latest()
                            ->get();

            return DataTables::of($porudzbine)
                            ->addIndexColumn()
                            ->editColumn('created_at',function(Order $porudzbina){
                                return Carbon::parse($porudzbina->created_at)->format('d.m.Y H:i:s');
                            })
                            ->make(true);
        }
    }
        
}
