<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Potkategorija;
use Illuminate\Http\Request;

class PotkategorijaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $svePotkategorije = Potkategorija::all();
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Potkategorija  $potkategorija
     * @return \Illuminate\Http\Response
     */
    public function show(Potkategorija $potkategorija)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Potkategorija  $potkategorija
     * @return \Illuminate\Http\Response
     */
    public function edit(Potkategorija $potkategorija)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Potkategorija  $potkategorija
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Potkategorija $potkategorija)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Potkategorija  $potkategorija
     * @return \Illuminate\Http\Response
     */
    public function destroy(Potkategorija $potkategorija)
    {
        //
    }
}
