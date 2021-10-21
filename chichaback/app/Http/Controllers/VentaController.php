<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use App\Models\Venta;
use App\Models\Prestamo;
use App\Models\Inventario;
use App\Models\Pago;
use App\Models\Detalleprestamo;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function misventas(Request $request){
        return Venta::with('user')
            ->with('cliente')
            ->with('pagos')
            ->with('detalle')
            ->whereDate('fecha','>=',$request->fecha1)
            ->whereDate('fecha','<=',$request->fecha2)
            ->get();
    }

    public function listventa(Request $request){
        return Venta::with('user')
            ->with('cliente')
            ->with('pagos')
            ->whereDate('fecha','>=',$request->fecha1)
            ->whereDate('fecha','<=',$request->fecha2)
            ->where('estado','<>','ANULADO')
            ->orderBy('estado','desc')
            ->get();
    }

    public function listado(Request $request){
        return Venta::with('user')
            ->with('cliente')
            ->with('pagos')
            ->where('estado','<>','ANULADO')
            ->orderBy('estado','desc')
            ->get();
    }

    public function index(Request $request)
    {
        return $request;
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
//        return $request->user();
        $venta= new Venta();
        $venta->fecha=$request->fecha;
        $venta->total=$request->total;
        $venta->tipo=$request->tipo;
        $venta->acuenta=$request->acuenta;
        $venta->saldo=$request->saldo;
        $venta->estado=$request->estado;
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
            $d->producto_id=$detalle['producto_id'];
            $d->cantidad=$detalle['cantidad'];
            $d->nombreproducto=$detalle['nombreproducto'];
            $d->precio=$detalle['precio'];
            $d->subtotal=$detalle['subtotal'];
            $d->save();
//            echo $detalle;
        }
        return $this->impresiondetalle($venta->id);

    }

    public function directa(Request $request)
    {
        $venta= new Venta();
        $venta->fecha=$request->fecha;
        $venta->total=$request->total;
        $venta->acuenta=$request->acuenta;
        $venta->saldo=$request->saldo;
        $venta->estado=$request->estado;
        $venta->user_id=$request->user()->id;
        $venta->cliente_id=$request->cliente_id;
        $venta->save();
        foreach ($request->detalles as $detalle){

            $d= new Detalle();
            $d->venta_id=$venta->id;
            $d->user_id=$request->user()->id;
            $d->producto_id=$detalle['producto_id'];
            $d->cantidad=$detalle['cantidad'];
            $d->nombreproducto=$detalle['nombreproducto'];
            $d->precio=$detalle['precio'];
            $d->subtotal=$detalle['subtotal'];
            $d->save();

            $prod=Producto::find($d->producto_id);
            $prod->cantidad-=$d->cantidad;
            $prod->save();
        }
        foreach ($request->garantias as $garantia){

            $g=new Garantia();
            $g->fecha=date('Y-m-d');
            $g->efectivo=$garantia['efectivo'];
            $g->fisico=$garantia['fisico'];
            $g->observacion=$garantia['observacion'];
            $g->estado=$garantia['estado'];
            $g->user_id=$request->user()->id;
            $g->cliente_id=$request->cliente_id;
            $g->save();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        $venta->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        //
    }

    public function listadoventa(Request $request){
        if ($request->id==0 || $request->id == ''){
            return Venta::with('user')
                ->with('cliente')
                ->whereDate('fecha','>=',$request->fecha)
                ->whereDate('fecha','<=',$request->fin)
//                ->where('user_id',$request->id)
                ->get();
        }else{
            return Venta::with('user')
                ->with('cliente')
                ->whereDate('fecha','>=',$request->fecha)
                ->whereDate('fecha','<=',$request->fin)
                ->get();
        }

    }

    public function listadodeudores(){
        return Venta::with('user')
        ->with('cliente')
        ->with('pagos')
        ->where('estado','POR COBRAR')
        ->orderBy('fecha','asc')
        ->get();
    }

    public function impresiondetalle($id){
        $venta=Venta::with('user')
        ->with('detalle')
        ->with('cliente')
        ->where('id',$id)
        ->get()[0];
         $cinit=00;
        $cadena='
        <style>
        .textcnt{
            text-align:center;
        }</style>
        <div class="textcnt"> CONTROL DESPACHO</div>
        <div class="textcnt">Nro '.$venta->id.'</div>
        <hr>
        <div>Nombre: '.$venta->cliente->titular.'</div>
        <div>Fecha: '.$venta->fecha.'</div>
        <hr>
        <div>Cantidad '.$venta->detalle->cantidad.'</div>
        <div>Producto: '.$venta->detalle->nombreproducto.'</div>
              ';
              return $cadena;
    }

    public function ruta($id){
        $venta=Venta::with('user')
        ->with('detalle')
        ->with('cliente')
        ->where('id',$id)
        ->get()[0];
         $cinit=00;
        $cadena='
        <style>
        .textcnt{
            text-align:center;
        }</style>
        <div class="textcnt"> HOJA DE RUTA</div>
        <div class="textcnt">Nro '.$venta->id.'</div>
        <hr>
        <div>Nombre: '.$venta->cliente->titular.'</div>
        <div>Direccion: '.$venta->cliente->direccion.'</div>
        <div>Telefono: '.$venta->cliente->telefono.'</div>
        <div>Fecha: '.$venta->fecha.'</div>
        <hr>
        <div>Cantidad '.$venta->detalle->cantidad.'</div>
        <div>Producto: '.$venta->detalle->nombreproducto.'</div>
        <div>Total: '.$venta->total.'</div>
        <div>A cuenta: '.$venta->acuenta.'</div>
        <div>Saldo: '.$venta->saldo.'</div>

              ';
              return $cadena;
    }

    public function anular($id){
        $venta=Venta::find($id);
        $venta->estado='ANULADO';
        $venta->total=0;
        $venta->acuenta=0;
        $venta->saldo=0;
        return $venta->save();

    }



}
