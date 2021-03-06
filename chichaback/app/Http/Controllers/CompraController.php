<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Material;
use App\Models\General;
use App\Models\Loggeneral;
use App\Models\Logcompra;
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
        $compra->subtotal=$r['subtotal'];
        $compra->deuda=$r['subtotal'];
        $compra->fechaven=$r['fechaven'];
        $compra->observacion=$r['observacion'];
        $compra->lote=$r['lote'];
        $compra->material_id=$r['material_id'];
        $compra->provider_id=$request->provider_id;
        $compra->user_id=$request->user_id;
        $compra->estado='POR PAGAR';
        $compra->save();

        /*$general=General::find(1);
        $general->monto=$general->monto - $compra->subtotal;
        $general->save();

        $loggeneral= new Loggeneral;
        $loggeneral->numero=$compra->id;
        $loggeneral->monto=$compra->subtotal;
        $loggeneral->detalle='COMPRA ALMACEN';
        $loggeneral->motivo='';
        $loggeneral->tipo='EGRESO';
        $loggeneral->fecha=$compra->fecha;
        $loggeneral->hora=date("H:i:s");
        $loggeneral->glosa_id=null;
        $loggeneral->user_id= $compra->user_id;
        $loggeneral->save();*/

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
        return Compra::with('material')->with('provider')->with('logcompras')->where('material_id',$request->material_id)
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
        $material->save();


    }
        /*$general=General::find(1);
        $general->monto=$general->monto +  $compra->subtotal - $request->subtotal;
        $general->save();

        $loggeneral= Loggeneral::where('numero',$compra->id)->where('detalle','COMPRA ALMACEN')->where('tipo','EGRESO')->get()[0];
        $loggeneral->monto=$compra->subtotal;
        $loggeneral->glosa_id=null;
        $loggeneral->save();

        $compra->fechaven=$request->fechaven;
        $compra->cantidad=$request->cantidad;
        $compra->costo=$request->costo;
        $compra->subtotal=$request->subtotal;
        $compra->observacion=$request->observacion;
        $compra->lote=$request->lote;
        $compra->save();
*/


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
        /*$general=General::find(1);
        $general->monto=$general->monto +  $compra->subtotal ;
        $general->save();

        $loggeneral= Loggeneral::where('numero',$compra->id)->where('detalle','COMPRA ALMACEN')->where('tipo','EGRESO')->first();
        $loggeneral->delete();
        */
        $material=Material::find($compra->material_id);
        $material->stock=$material->stock - $compra->cantidad;
        $material->save();
        $compra->delete();
    }


}
