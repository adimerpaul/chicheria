<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Prestamo::with('cliente')->with('inventario')->with('logprestamos')->get();
    }

    public function reportecliente(){
        return DB::SELECT('select local,titular,i.id,i.nombre,sum(p.prestado) as total,tipocliente,sum(p.efectivo) as monto from prestamos p inner join clientes c on p.cliente_id=c.id inner join inventarios i on p.inventario_id = i.id where p.prestado>0 group by local,titular,i.id,i.nombre,tipocliente');
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
         $inv=Inventario::find($request->inventario_id);
         if( $inv->cantidad>=$request->cantidad){
        $prestamo=new Prestamo();
        $prestamo->fecha=date('Y-m-d');
//        $prestamo->estado='DEVUELTO';
        $prestamo->cantidad=$request->cantidad;
        $prestamo->prestado=$request->cantidad;
        $prestamo->efectivo=$request->efectivo;
        $prestamo->fisico=$request->fisico;
        $prestamo->observacion=$request->observacion;
        $prestamo->user_id=$request->user()->id;
        $prestamo->cliente_id=$request->cliente_id;
        $prestamo->inventario_id=$request->inventario_id;
         $prestamo->save();
         $inv=Inventario::find($request->inventario_id);
         $inv->cantidad=$inv->cantidad - $request->cantidad;
         $inv->save();
         return $this->impresion($prestamo->id);}
         else
            return response()->json(['error' => 'No se cuenta con la cantidad'], 404);
//        return $prestamo->
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function show(Prestamo $prestamo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Prestamo $prestamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        $prestamo->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prestamo $prestamo)
    {
//        return $prestamo;
        $prestamo->delete();
    }

    public function impresion($id){
        $garantia=Prestamo::with('cliente')->where('id',$id)->get()[0];
        $cadena='
        <style>
        .textc{text-align:center}
        </style>
        <div>N '.$garantia->id.'</div>
        <div>Nombre: '.$garantia->cliente->titular.'</div>
        <div>Telefono: '.$garantia->cliente->telefono.'</div>
        <div>Efectivo '.$garantia->efectivo.'</div>
        <div>Detalle '.$garantia->fisico.'</div>
        <div>Fecha '.$garantia->fecha.'</div>
        <br>
        <div class="textc">Firma</div>
        ';
        return $cadena;

    }

    public function tefectivo(){
        return DB::SELECT('SELECT SUM(efectivo) as total from prestamos where estado="EN PRESTAMO"');
    }
}
