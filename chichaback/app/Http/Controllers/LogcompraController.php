<?php

namespace App\Http\Controllers;

use App\Models\Logcompra;
use App\Models\Compra;
use App\Models\General;
use App\Models\Loggeneral;
use Illuminate\Http\Request;

class LogcompraController extends Controller
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
        //
        $logcompra=new Logcompra;
        $logcompra->fecha=date('Y-m-d');
        $logcompra->compra_id=$request->compra_id;
        $logcompra->user_id=$request->user()->id;
        $logcompra->monto=$request->monto;
        $logcompra->observacion=$request->observacion;
        $logcompra->save();

        $compra=Compra::find($request->compra_id);
        $compra->deuda=$compra->deuda - $request->monto;

        $general=General::find(1);
        $general->monto=$general->monto - $request->monto;
        $general->save();

        $loggeneral= new Loggeneral;
        $loggeneral->numero=$compra->id;
        $loggeneral->monto= $request->monto;
        $loggeneral->detalle='MATERIAL ALMACEN';
        $loggeneral->motivo='PAGO COMPRA';
        $loggeneral->tipo='EGRESO';
        $loggeneral->fecha=date('Y-m-d');
        $loggeneral->hora=date("H:i:s");
        $loggeneral->glosa_id=null;
        $loggeneral->user_id=$request->user()->id;
        $loggeneral->save();

        if($compra->deuda==0)
            $compra->estado='CANCELADO';
        return $compra->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Logcompra  $logcompra
     * @return \Illuminate\Http\Response
     */
    public function show(Logcompra $logcompra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logcompra  $logcompra
     * @return \Illuminate\Http\Response
     */
    public function edit(Logcompra $logcompra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logcompra  $logcompra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logcompra $logcompra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logcompra  $logcompra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logcompra $logcompra)
    {
        //
    }
}
