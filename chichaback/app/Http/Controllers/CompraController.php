<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Material;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
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
        //        return $request; 
        foreach ($request->compras as $r) {
            $material=Material::find($r['material_id']);
            $material->stock=$material->stock + $r['cantidad'];
            $material->save();


        
        $compra=new Compra;
        $compra->fecha=date('Y-m-d');
        $compra->hora=date('H:i:s');
        $compra->cantidad=$r['cantidad'];
        $compra->costo=$r['costo'];
        $compra->fechaven=$r['fechaven'];
        $compra->observacion=$r['observacion'];
        $compra->lote=$r['lote'];
        $compra->material_id=$r['material_id'];
        $compra->provider_id=$request->provider_id;
        $compra->user_id=$request->user_id;
        $compra->save();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function consultar(Request $request)
    {
        //
        return Compra::with('material')->with('provider')->where('material_id',$request->material_id)
        ->whereDate('fecha','>=',$request->fecha1)->where('fecha','<=',$request->fecha2)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        //
        $compra=Compra::find($request->id);
        $material=Material::find($request->material_id);
        if($compra->cantidad != $request->cantidad){
        $material->stock=$material->stock - $compra->cantidad + $request->cantidad;
        $material->save();}
        $compra->fechaven=$request->fechaven;
        $compra->cantidad=$request->cantidad;
        $compra->costo=$request->costo;
        $compra->observacion=$request->observacion;
        $compra->lote=$request->lote;
        $compra->save();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $compra=Compra::find($id);
        $material=Material::find($compra->material_id);
        $material->stock=$material->stock - $compra->cantidad;
        $material->save();
        $compra->delete();
    }
}
