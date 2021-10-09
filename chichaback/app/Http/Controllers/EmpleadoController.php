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
        return Empleado::all();
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
        SELECT e.nombre,e.salario,
        (SELECT SUM(monto) FROM sueldos WHERE empleado_id=e.id AND tipo='ADELANTO' AND  month(fecha) = month('".$request->fecha1."') AND year(fecha)= year('".$request->fecha1."')) as adelanto,
        (SELECT SUM(monto) FROM sueldos WHERE empleado_id=e.id AND tipo='DESCUENTO' AND  month(fecha) = month('".$request->fecha1."') AND year(fecha)= year('".$request->fecha1."')) as descuento,
        (SELECT SUM(monto) FROM sueldos WHERE empleado_id=e.id AND tipo='BONO' AND  month(fecha) = month('".$request->fecha1."') AND year(fecha)= year('".$request->fecha1."')) as bono
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
    public function edit(Empleado $empleado)
    {
        //
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
