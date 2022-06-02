<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Empleado::with('sueldos')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return $request;
    }
    public function missueldos(Request $request){
//        return $request;
        return DB::select("
        SELECT e.id,e.nombre,e.salario,e.ci,e.celular,e.fechanac,e.tipo,
        (SELECT SUM(monto) FROM sueldos WHERE empleado_id=e.id AND tipo='ADELANTO' AND  date(fecha) >= '".$request->fecha1."' AND date(fecha)<= '".$request->fecha2."') as adelanto,
        (SELECT SUM(monto) FROM sueldos WHERE empleado_id=e.id AND tipo='DESCUENTO' AND  date(fecha) >= '".$request->fecha1."' AND date(fecha)<= '".$request->fecha2."') as descuento,
        (SELECT SUM(monto) FROM sueldos WHERE empleado_id=e.id AND tipo='EXTRA' AND  date(fecha) >= '".$request->fecha1."' AND date(fecha)<= '".$request->fecha2."') as extra,
        (SELECT SUM(monto) FROM sueldos WHERE empleado_id=e.id AND tipo='PAGO' AND  date(fecha) >= '".$request->fecha1."' AND date(fecha)<= '".$request->fecha2."') as pago,
        (SELECT SUM(monto) FROM sueldos WHERE empleado_id=e.id AND tipo='CANCELAR' AND  date(fecha) >= '".$request->fecha1."' AND date(fecha)<= '".$request->fecha2."') as cancelar,
        (SELECT GROUP_CONCAT(observacion SEPARATOR ' <br> ') FROM sueldos WHERE empleado_id=e.id AND tipo='PAGO' AND date(fecha) >= '".$request->fecha1."' AND date(fecha)<= '".$request->fecha2."') as obs
        FROM empleados e
        ");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Empleado::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        return Empleado::with('sueldos')
            ->where('id',$empleado->id)
            ->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($empleado)
    {
//        return $empleado;
        return Empleado::with('planillas')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        $empleado->update($request->all());
        return $empleado;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return 1;
    }
}
