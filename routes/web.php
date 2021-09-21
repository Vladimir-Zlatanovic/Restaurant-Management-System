<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\JelovnikController as AdminJelovnikController;
use App\Http\Controllers\Admin\PotkategorijaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PocetnaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JelovnikController;
use App\Http\Controllers\ProfilController;
use Gloudemans\Shoppingcart\Facades\Cart;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/pocetna',[PocetnaController::class, 'index'])->name('pocetna');
Route::get('/pretraga',[JelovnikController::class,'pretraziJelovnik'])->name('pretraga');
Route::get('/jelovnik',[JelovnikController::class,'index'])->name('jelovnik');


Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth','admin']
], function(){
    Route::resource('users', UsersController::class, ['except' => ['create','store']]);
    Route::get('/dashboard', function(){
        return view('admin.dashboard.panel');
    })->name('dashboard');
    
    Route::get('/prikazi_potkategorije/{kategorija?}',[AdminJelovnikController::class,'prikaziPotkategorije'])->name('prikazi.potkategorije.ajax');
    Route::get('/prikazi sva jela', [AdminJelovnikController::class,'prikaziSvaJela'])->name('prikazi.jela.ajax');
    Route::resource('jelovnik', AdminJelovnikController::class);
    Route::resource('potkategorije',PotkategorijaController::class);
    
    
});

//rute za autentikaciju
Auth::routes();


Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'korisnik','as' => 'korisnik.'], function(){

        //rute za korisnicki profil
        Route::group(['prefix' => 'profil', 'as' => 'profil.'],function(){
            Route::get('',[ProfilController::class,'index'])
              ->name('prikazi');
            Route::put('izmeni_podatke', [ProfilController::class,'izmeniPodatke'])
                ->name('izmeni_podatke');
            Route::get('get_porudzbine',[ProfilController::class,'getPorudzbine'])
                ->name('get_porudzbine');
            
        
        });
        
        
        //rute za korpu
        Route::group(['prefix' => 'korpa', 'as' => 'korpa.'],function(){

            Route::post('dodaj/{jelo}',[CartController::class,'dodajUKorpu'])
                    ->whereNumber('jelo')
                    ->name('dodaj');
            Route::get('prikazi',[CartController::class,'prikaziKorpu'])->name('prikazi');
            Route::delete('ukloni/{jelo}',[CartController::class,'ukloniIzKorpe'])
                    ->whereNumber('jelo')
                    ->name('ukloni');
            Route::post('poruci',[CartController::class,'poruci'])->name('poruci');
            Route::post('azuriraj_kolicinu/{jelo}',[CartController::class,'azurirajKolicinu'])
                   ->whereNumber(['jelo'])
                   ->name('azuriraj_kolicinu');
        });
        
        //rute za checkout
        Route::group(['prefix' => 'checkout', 'as' => 'checkout.'],function(){

            Route::get('prikazi',[CheckoutController::class, 'prikaziCheckout'])->name('prikazi');
            Route::post('poruci',[CheckoutController::class,'poruci'])->name('poruci');

        });
        
    });
});




