<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jelovnik;
use App\Models\Kategorija;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class JelovnikController extends Controller
{
    //prikazi sva jela iz jelovnika
    public function index(Request $request)
    {
       

        return view('admin.dashboard.prikazi_jelovnik',);
    }

    //prikazi formu za kreiranje novog jela
    public function create(Request $request)
    {
      
        $kategorije = Kategorija::all();
        $potKategorije = null;
        if($request->has('kategorija')){
            $kategorija = Kategorija::where('slug', $request->input('kategorija'))->first();
            $potKategorije = $kategorija->potKategorije()->get();
        }
        return view('admin.dashboard.dodaj_jelo', compact('kategorije','potKategorije'));
    }

    //obrada podataka poslatih iz dodaj jelo forme i cuvanje novog jela u bazi
    public function store(Request $request)
    {
        $rules = [
            'ime' => ['required', 'max:255', 'unique:jelovnik,ime', 'regex:/^\p{Lu}[\p{L} \d\-]*$/u'],
            'opis' => ['max:700'],
            'cena' => ['required', 'numeric', 'min:0.0', 'max:999999.99' ],
            'kategorija' => ['required','integer','exists:kategorije,id'],
            'potKategorija' => ['required','integer','exists:potkategorije,id'],
            'slika' => ['nullable','bail','file','mimes:jpg,jpeg,png', 'max:4096']
            
        ];
       $custom_messages = [
           
                'ime.regex'=> 'Polje :attribute mora početi velikim slovom, i može da sadrži samo slova,
                            cifre, razmake i crte',
                'required' => 'Polje :attribute je obavezno',
                'ime.max' => 'Polje :attribute moze biti najvise :value karaktera dugacko',
                'ime.unique' => 'Vec postoji jelo u meniju sa tim imenom, izaberite neko drugo',
               'opis.max' => 'Opis jela moze sadrzati najvise :value karaktera.',
               'cena.required' => 'Morate uneti cenu',
               'cena.numeric' => 'Cena mora biti broj',
               'cena.min' => 'Cena ne može biti manja od :min',
               'cena.max' => 'Cena može biti najviše :max',
               'kategorija.required' => 'Morate izabrati kategoriju za novo jelo',
               'kategorija.integer' => 'Izabrana kategorija ne postoji',
               'kategorija.exists' => 'Izabrana kategorija ne postoji',
               'potKategorija.exists' => 'Izabrana potkategorija ne postoji',
               'potKategorija.required' => 'Morate izabrati potkategoriju za novo jelo',
               'potKategorija.integer' => 'Potkategorija mora biti neka od postojecih potkategorija',
               'slika.file' => 'Slika mora biti fajl',
               'slika.mimes' => 'Podržane ekstenzije su .jpg, .jpeg i .png',
               'slika.max' => 'Slika ne može biti veća od 4MB'
        ]; 

        $attribute_names = [
            'ime' => 'Ime jela',
        ];
        
        $validator = Validator::make($request->all(),$rules,$custom_messages,$attribute_names);
        if($validator->fails()){
           return response()->json([
               'errors' => $validator->errors()->toArray(),
            
           ]);

        } else {
            $novoImeSlike = "";
            if($request->hasFile('slika')){
                $slika =$request->file('slika');
                
                $imeSlike = $request->post('ime');
                $imeSlike = preg_replace("/\s+/", '-', $imeSlike);

                $novoImeSlike = time() . '-' . $imeSlike
                                . '.' . $slika->getClientOriginalExtension();
                
               //Promeni dimenzije slike
               $resizovanaSlika = Image::make($slika)->resize(300,300,function($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
               })->encode('jpg');

               $thumbnail = Image::make($slika)->resize(110,110,function($constraint){
                   $constraint->aspectRatio();
                   $constraint->upsize();
               })->encode('jpg');
               $saveFullsize = Storage::put("public/slike/fullsize/{$novoImeSlike}", $resizovanaSlika->__toString());
               $saveThumbnail = Storage::put("public/slike/thumbnail/{$novoImeSlike}",$thumbnail->__toString());
               
            } else {
                $novoImeSlike = 'default.png';
            }
            $kolone = collect(['ime','cena', 'opis', 'slika', 'potkategorija_id','slika']);

            // prvo iskombinuje kolone sa poljima iz forme, kolone su kljucevi, polja vrednosti,
            //pa onda izbaci svako polje iz forme koje je null
            $parovi = $kolone->combine([
                $request->post('ime'),
                $request->post('cena'),
                $request->post('opis'),
                $request->post('slika'),
                $request->post('potKategorija'),
                $novoImeSlike,
            ])->filter(function($val, $key){
                return isset($val);
            });
            
            $novoJelo = Jelovnik::create($parovi->all());
            if($novoJelo->exists){
                return response()->json([
                    'message' => 'Jelo je dodato u meni!'
                ]);
            } else {
                return response()->json(['error'=>'Doslo je do greske!']);
            }
                        
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jelovnik  $jelovnik
     * @return \Illuminate\Http\Response
     */
    public function show(Jelovnik $jelovnik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jelovnik  $jelovnik
     * @return \Illuminate\Http\Response
     */
    public function edit(Jelovnik $jelovnik)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jelovnik  $jelovnik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jelovnik $jelovnik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jelovnik  $jelovnik
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jelovnik $jelovnik)
    {
        //
    }

    public function prikaziSvaJela()
    {
        $svaJela = Jelovnik::with('potKategorija')->get();
        
        return DataTables::of($svaJela)
                ->editColumn('kreirano',function(Jelovnik $porudzbina){
                    return Carbon::parse($porudzbina->created_at)->format('d.m.Y H:i:s');
                })
                ->editColumn('azurirano',function(Jelovnik $porudzbina){
                    return Carbon::parse($porudzbina->created_at)->format('d.m.Y H:i:s');
                })
                ->addColumn('potKategorija', function(Jelovnik $jelo){
                    return $jelo->potKategorija->ime;
                })
                
                ->make(true);
    }

    // funkcija koja odgovara na ajax zahtev kada se odabere kategorija za novo jelo u dodaj_jelo formi
    public function prikaziPotkategorije(Request $request, Kategorija $kategorija = null){
        if(isset($kategorija)){
            $potKategorije = $kategorija->potKategorije()->get();
        } else {
            $potKategorije = [];
        }
        if($request->ajax()){
            return response()->json(["potKategorije" => $potKategorije]);
        }
        
    }
}
