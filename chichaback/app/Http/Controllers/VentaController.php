<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use App\Models\Venta;
use App\Models\Prestamo;
use App\Models\Inventario;
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
            ->whereDate('fecha','>=',$request->fecha1)
            ->whereDate('fecha','<=',$request->fecha2)
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
        $venta->fecha=date('Y-m-d');
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
        $verificar=0;
        foreach ($request->prestamo as $pdetalle) {
            $verificar+=intval($pdetalle['cantidad']);
        }
        if($verificar>0){
        $prestamo=new Prestamo();
        $prestamo->venta_id=$venta->id;
        $prestamo->user_id=$request->user()->id;
        $prestamo->cliente_id=$request->cliente_id;
        $prestamo->save();

        foreach ($request->prestamo as $pdetalle) {
            if($pdetalle['cantidad'] >0){
            $p=new DetallePrestamo();
            $p->cantidad=$pdetalle['cantidad'];
            $p->prestamo_id=$prestamo->id;
            $inv= Inventario::where('producto_id',$pdetalle['producto_id'])->get()[0];
            $p->inventario_id=$inv->id;
            $p->save();
            $inv->cantidad-=intval($pdetalle['cantidad']);
            $inv->save();
        
        }
        }}
    }

    public function directa(Request $request)
    {
        $venta= new Venta();
        $venta->fecha=date('Y-m-d');
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
        //
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
}
