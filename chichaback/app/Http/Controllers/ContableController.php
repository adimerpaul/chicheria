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
        return DB::SELECT("SELECT sum(monto) total from pagos where fecha>='$request->fecha1' AND fecha<='$request->fecha2'");
    }

    public function repingprestamo(Request $request){
        return DB::SELECT("SELECT estado,sum(efectivo) total from prestamos where fecha>='$request->fecha1' AND fecha<='$request->fecha2' and estado in('VENTA','ANULADO') GROUP by estado;");
    }

    public function repgastos(Request $request){
        return DB::SELECT("SELECT glosa,sum(precio) total FROM gastos WHERE glosa<>'CAJA CHICA' and fecha>='$request->fecha1' AND fecha<='$request->fecha2' group by glosa;");
    }
}
