<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContableController extends Controller
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

    public function repventa(Request $request){
       return  DB::SELECT("SELECT tipo, sum(acuenta) total from ventas where fecha>='$request->fecha1' AND fecha<='$request->fecha2' GROUP By tipo");

    }

    public function repventpago(Request $request){
        $res=DB::SELECT("SELECT sum(monto) total from pagos where fecha>='$request->fecha1' AND fecha<='$request->fecha2'");
        return $res;
    }

    public function repingprestamo(Request $request){
        return DB::SELECT("SELECT estado,sum(efectivo) total from prestamos where fecha>='$request->fecha1' AND fecha<='$request->fecha2' and estado in('VENTA','ANULADO') GROUP by estado;");
    }

    public function repgastos(Request $request){
        return DB::SELECT("SELECT o.nombre as glosa,sum(precio) total FROM gastos g inner join glosas o on g.glosa_id=o.id WHERE glosa<>'CAJA CHICA' and fecha>='$request->fecha1' AND fecha<='$request->fecha2' group by o.nombre;");
    }

    public function repcompra(Request $request){
        return DB::SELECT("SELECT SUM(monto) as total from logcompras where fecha >= '$request->fecha1' and  fecha <= '$request->fecha2'");
    }

    public function repcaja(Request $request){
        return DB::SELECT("SELECT g.nombre as glosa,sum(monto) total FROM logcajas l inner join glosas g on l.glosa_id=g.id WHERE l.tipo='GASTO' and fecha>='$request->fecha1' AND fecha<='$request->fecha2' group by g.nombre");
    }
}
