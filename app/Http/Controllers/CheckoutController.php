<?php

namespace App\Http\Controllers;

use App\Models\Jelovnik;
use App\Models\Order;
use App\Models\OrderDetail;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function prikaziCheckout(){
        if(Cart::content()->count() == 0){
            return redirect()->route('korisnik.korpa.prikazi');
        }
        $cart = Cart::content()->groupBy('id');
        $jelaIzKorpe = Jelovnik::with('potKategorija','potKategorija.kategorija')
                        ->whereIn('id',$cart->keys())
                        ->get();
        return response(view('korpa.checkout',compact('cart','jelaIzKorpe')))
                    ->withHeaders([
                        'Cache-Control' => 'no-cache, no-store, must-revalidate',
                        'Pragma' => 'no-cache',
                        'Expires' => '0',
                    ]);
    }
    public function poruci(Request $request){
            $pravila = [
                'telefon' => ['bail','required','string','min:8','max:17','regex:/^\d+$/'],
                'adresa' => ['bail','required','string','max:255'],
            ];
            $poruke = [
                'telefon.required' => ':attribute je obavezan.',
                'telefon.min' => ':attribute mora sadrzati bar :min cifara.',
                'telefon.max' => ':attribute ne moze sadrzati vise od :max cifara.',
                'telefon.regex' => ':attribute sme da sadrzi samo cifre.',
                'telefon.string' => ':attribute koji ste uneli nije validan.',
                'adresa.required' => 'Morate uneti adresu na koju ce porudzbina stici.',
                'adresa.string' => ':attribute koju ste uneli nije validna.',
                'adresa.max' => ':attribute ne moze sadrzati vise od :max karaktera.'

            ];
            $imena_atributa = [
                'telefon' => 'Broj telefona',
                'adresa' => 'Adresa',
            ];
            $validator = Validator::make($request->all(),$pravila,$poruke,$imena_atributa);
            $validator->validate();

            //ovaj deo koda se izvrsava samo ako request prodje validaciju
            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->iznos = 0.0;
            $validiranInput = $validator->validated();
            $order->adresa = $validiranInput['adresa'];
            $order->telefon = "381" . $validiranInput['telefon'];
            $order->save();
            //uzmi sve artikle iz korpe i za svaki artikal napravi order_details
            $sadrzaj_korpe = Cart::content();
            foreach($sadrzaj_korpe as $idJela => $stavka){
                $user_id = auth()->user()->id;
                $iznos = $stavka->qty * $stavka->price;
                $jelovnik_id = $stavka->id;
                $order_detail = new OrderDetail;
                $order_detail->kolicina = $stavka->qty;
                $order_detail->iznos = $stavka->qty * $stavka->price;
                //povezi order_detail sa jelom
                $order_detail->jelo()->associate(Jelovnik::find($stavka->id));
                $order_detail->order()->associate($order);
                //povezi order sa order_detail
               
                //insert order_detail u bazu
                $order_detail->save();
                //dodaj iznos order_detail na ukupan iznos order
                $order->iznos += $order_detail->iznos;
               

            }
            $order->save();
            Cart::destroy();
            // insert order u bazu
            return redirect()
                    ->route('pocetna')
                    ->with(['porudzbina-kreirana' => 'Vaša porudžbina je poslata!']);

    }
};
