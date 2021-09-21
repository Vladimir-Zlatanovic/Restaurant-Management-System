<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Jelovnik;
use App\Models\Kategorija;
use App\Models\Potkategorija;
use Illuminate\Support\Facades\Validator;
use stdClass;

class JelovnikController extends Controller
{
    public function index(){
        //DB::enableQueryLog(); - kada hoces da pogledas sql query koji je builder generisao!!!
      /*  $jela = DB::table('jelovnik')
                    ->select()
                    ->where(function($qB){
                        $qB->whereBetween('id',[1,2]);
                        $qB->orWhere('cena','>',100.0);
                    })
                    ->orderBy('cena','desc')
                    ->get(); */
        /* $jela = DB::table('jelovnik')
                        ->select()
                       ->orderBy('created_at','desc')
                       ->orderBy('id','asc')
                       ->get(); */
   //dd(DB::getQueryLog());  
    }
    
    public function pretraziJelovnik(Request $request){
 
        $query = $this->pretraziHelper($request);
        $svaJela = $query->paginate(8);
        if($request->ajax()){
            return view('jelovnik.paginacija',compact('svaJela'))->render();
        }
        $kategorije = Kategorija::all();
        $maxCena = $query->max('cena');
        $minCena = $query->min('cena');
        $promenljive = [
            'svaJela',
            'kategorije',
            'maxCena',
            'minCena',
            'promenljive',
        ];
        return view('jelovnik.search_stranica',compact($promenljive));
       
    }
    
    private function pretraziHelper(Request $request){

        $query = DB::table('jelovnik')
                         ->join('potkategorije','jelovnik.potkategorija_id','=','potkategorije.id')
                         ->select('jelovnik.id','jelovnik.ime','jelovnik.cena','jelovnik.slika');  
         if ($request->has('kategorija')){
             $query = $query->whereIn('potkategorije.kategorija_id',$request->input('kategorija'));
         } 
         if ($request->has('potKategorija')){
             $query = $query->whereIn('jelovnik.potkategorija_id',$request->input('potKategorija'));
         }
         if($request->has('pretraga') && $request->input('pretraga') != null){
             $pretraga = preg_replace('/\s+/','%',$request->input('pretraga'));
             $query = $query->where('jelovnik.ime','like',"%{$pretraga}%");
         }
         
         $query = $query->orderBy('jelovnik.cena',$request->input('sort-cena','asc'));
         return $query;
         
     }
     
   
}
