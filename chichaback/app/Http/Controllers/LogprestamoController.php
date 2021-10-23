<?php

namespace App\Http\Controllers;

use App\Models\Logprestamo;
use App\Models\Prestamo;
use App\Models\Inventario;
use App\Models\Cliente;
use Illuminate\Http\Request;

class LogprestamoController extends Controller
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
        $logpres= new Logprestamo;
        $logpres->fecha=$request->fecha;
        $logpres->cantidad=$request->cantidad;
        $logpres->motivo=$request->motivo;
        $logpres->prestamo_id=$request->id;
        $logpres->user_id=$request->user()->id;
        $logpres->save();
        $prestamo=Prestamo::find($request->id);
        $prestamo->prestado = $prestamo->prestado - $request->cantidad;
        if($prestamo->prestado == 0) 
        $prestamo->estado='DEVUELTO';
        $prestamo->save();
        $inv=Inventario::find($request->inventario_id); 
        $inv->cantidad= $inv->cantidad + $request->cantidad;
        $inv->save();
        $cliente=Cliente::find($prestamo->cliente_id);
        $cadena="
        <div> Fecha: $logpres->fecha</div>
        <div>Cliente: $cliente->local  $cliente->titular</div>
        <div>Item: $inv->nombre</div>
        <div>Cantidad: $logpres->cantidad</div>
        <div>Efectivo: $prestamo->efectivo</div>
        <div>Fisico: $prestamo->fisico</div><br><br>
        <div style='text-align:center'>FIRMA</div>
";
        return $cadena;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Logprestamo  $logprestamo
     * @return \Illuminate\Http\Response
     */
    public function show(Logprestamo $logprestamo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logprestamo  $logprestamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Logprestamo $logprestamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logprestamo  $logprestamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logprestamo $logprestamo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logprestamo  $logprestamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logprestamo $logprestamo)
    {
        //
    }
}
