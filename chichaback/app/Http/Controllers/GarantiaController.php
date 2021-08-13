<?php

namespace App\Http\Controllers;

use App\Models\Garantia;
use App\Models\Gdetalle;
use Illuminate\Http\Request;

class GarantiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Garantia::with('cliente')->get();
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
        $garantia= new Garantia();
        $garantia->fecha=$request->fecha;
        $garantia->efectivo=$request->efectivo;
        $garantia->fisico=$request->fisico;
        $garantia->detalle=$request->detalle;
        $garantia->estado=$request->estado;
        $garantia->user_id=$request->user()->id;
        $garantia->cliente_id=$request->cliente_id;
        $garantia->save();
        foreach ($request->detalles as $detalle){
            $d= new Gdetalle();
            $d->garantia_id=$garantia->id;
            $d->user_id=$request->user()->id;
            $d->inventario_id=$detalle['inventario_id'];
            $d->cantidad=$detalle['cantidad'];
            $d->nombreinv=$detalle['nombreinv'];
            $d->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Garantia  $garantia
     * @return \Illuminate\Http\Response
     */
    public function show(Garantia $garantia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Garantia  $garantia
     * @return \Illuminate\Http\Response
     */
    public function edit(Garantia $garantia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Garantia  $garantia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Garantia $garantia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Garantia  $garantia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Garantia $garantia)
    {
        //
    }

    public function listado(Request $request){
        return Garantia::with('user')->with('cliente')->whereDate('fecha',$request->fecha)->get();
        
    }
}
