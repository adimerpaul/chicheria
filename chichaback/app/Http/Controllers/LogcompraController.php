<?php

namespace App\Http\Controllers;

use App\Models\Logcompra;
use App\Models\Compra;
use App\Models\General;
use App\Models\Caja;
use App\Models\Logcaja;
use App\Models\User;
use App\Models\Loggeneral;
use App\Models\Material;
use App\Models\Provider;
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

        if($request->checktipo=='GASTO'){
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
        }
        else{
        $caja=Caja::find(1);
        $caja->monto= floatval($caja->monto) - floatval($request->monto);
        $caja->save();

        $log=new Logcaja ;
        $log->monto=$request->monto;
        $log->motivo='Almacen Pago '.$compra->id.' : '.$request->observacion;
        $log->tipo='GASTO';
        $log->fecha=date('Y-m-d');
        $log->hora=date('H:i:s');
        $log->glosa_id=null;
        $log->user_id=$request->user()->id;
        $log->save();
        }
        if($compra->deuda<=0)
            $compra->estado='CANCELADO';
        $compra->save();
        $usuario=User::find($request->user()->id);
        $prov=Provider::find($compra->provider_id);
        $mat=Material::find($compra->material_id);
        $cadena='
        <style>
        .textcnt{
            text-align:center;
        }
        table{width:100%;}
        td{vertical-align:top;}
        </style>
        <div class="textcnt"> DETALLE PAGO COMPRA</div>
        <div class="textcnt">Nro '.$compra->id.'</div>
        <hr>
        <div>Usuario   : '.$usuario->name.'</div>
        <div>Fec Compra: '.$compra->fecha.'</div>
        <div>Proveedor : '.$prov->razon.'</div>
        <div>Material  : '.$mat->nombre.'</div>
        <div>Cantidad  : '.$compra->cantidad.'</div>
        <div>Costo     : '.$compra->costo.'</div>
        <hr>
        <table>
        <tr><td>Fecha Pago: </td><td><b>'.$logcompra->fecha.'</b></td></tr>
        <tr><td>Monto: </td><td><b>'.$logcompra->monto.'</b></td></tr>
        <tr><td>Saldo: </td><td><b>'.$compra->deuda.'</b></td></tr>
        <tr><td>Observacion: </td><td><b>'.$logcompra->observacion.'</b></td></tr>
        </table>
        <br>
              ';
        return $cadena;
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
