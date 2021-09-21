<?php

namespace App\Http\Controllers;

use App\Models\Jelovnik;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

class CartController extends Controller
{
    public function dodajUKorpu(Request $request, int $jeloId){
        if($request->ajax()){
            $response = array();
           $jelo = Jelovnik::findOrfail($jeloId);
            if(intval($request->input('kolicina')) > 0){
                Cart::add(
                    $jelo->id,
                    $jelo->ime,
                    intval($request->input('kolicina')),
                    $jelo->cena
                 );
                 $response['kolicina-promenjena'] = true;
            }
           $response['jelo'] = $jelo->ime;
           $response['kolicina'] = $request->input('kolicina',0);
           $response['korpa-broj'] = Cart::content()->count();
            return response()->json($response);
        }
    }
    public function prikaziKorpu(Request $request){

        $cart = Cart::content()->groupBy('id');
        $jelaIzKorpe = Jelovnik::with('potKategorija','potKategorija.kategorija')
                        ->whereIn('id',$cart->keys())
                        ->get();
        return response(view('korpa.korpa',compact('cart','jelaIzKorpe')))
                    ->withHeaders([
                        'Cache-Control' => 'no-cache, no-store, must-revalidate',
                        'Pragma' => 'no-cache',
                        'Expires' => '0',
                    ]);
                //headeri dodati da se ne bi prikazivala kesirana stranica na browser back dugme (ne prikazuje tacnu kolicinu stavki u korpi)
    }
    public function ukloniIzKorpe(Request $request, int $idArtikla){
        $stavka = Cart::content()->first(function($cartItem,$rowId) use($idArtikla){
            return $cartItem->id == $idArtikla;
        });
        Cart::remove($stavka->rowId);
        if($request->ajax()){
            return response()->json([
                'poruka-uspeh' => 'Uklonjeno iz korpe!',
                'korpa-broj' => Cart::content()->count(),
            ]);
        }
        return back()->with('poruka-uspeh','Uklonjeno iz korpe!');
        

    }
    public function azurirajKolicinu(Request $request, int $idArtikla){
        
        $stavka = Cart::content()->first(function($cartItem,$rowId) use($idArtikla){
            return $cartItem->id == $idArtikla;
        });
       
       if($request->has('kolicina')&& is_numeric($kolicina = $request->input('kolicina'))
            && intval($kolicina) > 0
        ){
            Cart::update($stavka->rowId,['qty' => intval($kolicina) ]);
            return response()->json([
                'poruka-uspeh' => 'kolicina je uspesno azurirana',
                'kolicina' => $stavka->qty,
                'ukupno' => $stavka->qty * $stavka->price,
                'ceo-zbir' => Cart::subtotal(),
            ]); 
        }
        return response()->json([
            'greska' => 'Doslo je do greske prilikom azuriranja kolicine!'
        ]);
       
    }
    public function poruci(){
       $user = auth()->user();
       
    }
}
