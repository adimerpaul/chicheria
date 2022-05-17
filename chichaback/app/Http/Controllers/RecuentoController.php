<?php

namespace App\Http\Controllers;

use App\Models\Recuento;
use App\Models\Material;
use Illuminate\Http\Request;

class RecuentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return Recuento::all();
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
        $material=Material::find($request->material_id);
        $material->stock=$material->stock - $request->cantidad;
        $material->save();
        
        $recuento=new Recuento;
        $recuento->fecha=date('Y-m-d');
        $recuento->hora=date('H:i:s');
        $recuento->cantidad=$request->cantidad;
        $recuento->observacion=$request->observacion;
        $recuento->material_id=$request->material_id;
        $recuento->user_id=$request->user_id;
        $recuento->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recuento  $recuento
     * @return \Illuminate\Http\Response
     */
    public function show(Recuento $recuento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recuento  $recuento
     * @return \Illuminate\Http\Response
     */
    public function edit(Recuento $recuento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recuento  $recuento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recuento $recuento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recuento  $recuento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recuento $recuento)
    {
        //
        $recuento=Recuento::find($id);
        $recuento->delete();
    }
}
