<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;

class SaleController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $venta= new Venta();
        $venta->fecha=date("Y-m-d");
        $venta->hora=date("H:i:s");
        $venta->total=$request->total;
        $venta->tipo=$request->tipo;
        $venta->acuenta=$request->acuenta;
        $venta->saldo=$request->saldo;
        $venta->estado=$request->estado;
        $venta->observacion=strtoupper($request->observacion);
        $venta->user_id=$request->user()->id;
        $venta->cliente_id=$request->cliente_id;
        $venta->save();

//        return $venta;
        foreach ($request->detalles as $detalle){
//            var_dump($detalle);
//            echo $detalle['producto_id'].'--';
            $d= new Detalle();
            $d->venta_id=$venta->id;
            $d->user_id=$request->user()->id;
            $d->producto_id=$detalle['id'];
            $d->cantidad=$detalle['cantidad'];
            $d->nombreproducto=$detalle['nombre'];
            $d->precio=$detalle['precio'];
            $d->subtotal=$detalle['subtotal'];
            $d->save();
//            echo $detalle;
        }
        $general=General::find(1);
        $general->monto=$general->monto + $venta->acuenta;
        $general->save();

        $loggeneral= new Loggeneral;
        $loggeneral->numero=$venta->id;
        $loggeneral->monto=$venta->acuenta;
        $loggeneral->detalle=$venta->tipo;
        $loggeneral->motivo='VENTA PRODUCTOS';
        $loggeneral->tipo='INGRESO';
        $loggeneral->fecha=$venta->fecha;
        $loggeneral->hora=date("H:i:s");
        $loggeneral->glosa_id=null;
        $loggeneral->user_id= $venta->user_id;
        $loggeneral->save();

        return $this->impresiondetalle($venta->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
