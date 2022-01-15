<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
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
        $pago=new Pago;
        $pago->fecha=date('Y-m-d');
        $pago->venta_id=$request->venta_id;
        $pago->user_id=$request->user()->id;
        $pago->monto=$request->monto;
        $pago->observacion=$request->observacion;
        $pago->save();
        $venta=Venta::find($request->venta_id);
        $venta->saldo=$venta->saldo - $request->monto;
        if($venta->saldo==0)
        $venta->estado='CANCELADO';
        return $venta->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function show(Pago $pagos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pago $pagos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pago $pagos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pagos  $pagos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pago $pagos)
    {
        //
    }

    public function reportepago(Request $request){
        if($request->user()->id==1)
        {
            if($request->id==0)
            return DB::SELECT("SELECT p.fecha,v.fechaentrega,p.monto,v.tipo,d.cantidad,d.nombreproducto, c.local,c.titular
            FROM pagos p inner join ventas v on p.venta_id=v.id inner join detalles d ON v.id=d.venta_id
            inner join clientes c on v.cliente_id=c.id
            where date(p.fecha)>='$request->fecha1' and date(p.fecha)<='$request->fecha2'");
            else
            return DB::SELECT("SELECT p.fecha,v.fechaentrega,p.monto,v.tipo,d.cantidad,d.nombreproducto, c.local,c.titular
            FROM pagos p inner join ventas v on p.venta_id=v.id inner join detalles d ON v.id=d.venta_id
            inner join clientes c on v.cliente_id=c.id
            where p.user_id=$request->id and
            date(p.fecha)>='$request->fecha1' and date(p.fecha)<='$request->fecha2'");


        }
        else
        return DB::SELECT("SELECT p.fecha,v.fechaentrega,p.monto,v.tipo,d.cantidad,d.nombreproducto, c.local,c.titular
        FROM pagos p inner join ventas v on p.venta_id=v.id inner join detalles d ON v.id=d.venta_id
        inner join clientes c on v.cliente_id=c.id
        where p.user_id=".$request->user()->id." and
        date(p.fecha)>='$request->fecha1' and date(p.fecha)<='$request->fecha2'");


    }


}
